<?php

class ReportLog extends MX_Controller {

	protected $_template = 'iso/template';
	protected $_sessLife = 7200;

	function __construct() {
		parent::__construct();
		$this->load->helper('base_helper');
	}

	function update_dayoff() {
		$action = $this->input->post('action');
		if ($action == 'update_dayoff') {

			$total_em = $this->input->post('total_em');
			$numday = $this->input->post('numday');
			$month = $this->input->post('month');
			$year = $this->input->post('year');

			// Get json string
			$json = $this->input->post('json_data');
			if ($json != '') {
				$arData = json_decode(base64_decode($json), true);
			}

			if ($total_em != '') {
				$arEm = explode(',', $total_em);
				$cem = 0;
				foreach ($arEm as $em) {
					for ($i = 1; $i <= $numday; $i++) {
						$value = 0;
						$value = (int) $this->input->post('rec-' . $em . '-' . $i . '-' . $month . '-' . $year);

						// Check exist record
						$existValue = 0;
						if (!empty($arData)) {
							if (isset($arData['rec-' . $em . '-' . $i . '-' . $month . '-' . $year])) {
								$existValue = $arData['rec-' . $em . '-' . $i . '-' . $month . '-' . $year];
							}
						}
						if ($value > 0) {
							if ($existValue == 0) {
								$cem++;
								$rec[$cem]['employ_id'] = $em;
								$rec[$cem]['day'] = $i;
								$rec[$cem]['month'] = $month;
								$rec[$cem]['year'] = $year;
								$rec[$cem]['reason'] = $value;
							} else {
								if ($value != $existValue) {
									$cem++;
									$rec[$cem]['employ_id'] = $em;
									$rec[$cem]['day'] = $i;
									$rec[$cem]['month'] = $month;
									$rec[$cem]['year'] = $year;
									$rec[$cem]['reason'] = $value;

									// Delete old record
									$this->db->delete('mc_dayoff', array('employ_id' => $em, 'day' => $i, 'month' => $month, 'year' => $year, 'reason' => $existValue));
								}
							}
						}
					}
				}

				if (!empty($rec))
				$this->db->insert_batch('mc_dayoff', $rec);
				redirect(base_url() . 'hrm/reportlog/dayoff');
			}
		} else {
			redirect(base_url() . 'home');
		}
	}

	function dayoff() {
		// Load model
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('hrm/ReportLogModel', 'reportlog');
		$this->load->model('setting/DepartmentModel', 'department');

		// Time
		$month = 0;
		$year = 0;
		if (isset($_POST['m']))
		$month = $_POST['m'];
		if (isset($_POST['y']))
		$year = $_POST['y'];
		if ($month <= 0)
		$month = date('m') - 1;
		if ($year <= 0)
		$year = date('Y');
		$data['month'] = $month;
		$data['year'] = $year;
                if($month <= 0){
                   $data['month'] = $month = 1;
                   $year = $year -1;
                   $data['year'] = $year;
                }
		// Get days of month
		$data['numday'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		// LEFT BOX
		$data['depart'] = $this->department->get_depart('id,name', '');
		$data['employ'] = $this->employ->get_employ_by_depart();
		$data['total_em'] = array();
		foreach ($data['employ'] as $emp) {
			foreach ($emp as $em) {
				$data['total_em'][] = $em['id'];
			}
		}

		// Total record
		$data['rec'] = $this->reportlog->get_dayoff($month, $year);
		$data['navi'] = array(array('name' => 'Ngày phép tháng', 'href' => ''));
		$data['main_content'] = 'reportlog/dayoff';

		$this->load->vars($data);
		$this->load->view($this->_template);
	}

	function dayoffyear() {
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('hrm/ReportLogModel', 'reportlog');
		$this->load->model('setting/DepartmentModel', 'department');
		$data['employ'] = $this->employ->get_employ_by_depart();
		$data['navi'] = array(array('name' => 'Ngày phép năm', 'href' => ''));
		if (isset($_POST['year'])) {
			$year = $_POST['year'];
		} else {
			$year = date('Y',time());
		}
		$data['year'] = $year;
		$data['dayoff'] = $this->reportlog->get_dayoff_year($year);
		$data['main_content'] = 'reportlog/dayoffyear';
		$this->load->vars($data);
		$this->load->view($this->_template);
	}

	function index() {
		$uid = 0;
		if (isset($_GET['uid']))
		$uid = $_GET['uid'];
		if ($uid > 0) {
			// Load model
			$this->load->model('hrm/ReportLogModel', 'reportlog');
			$this->load->model('hrm/EmployeeModel', 'employ');
			
			// LEFT BOX
			$this->load->model('setting/DepartmentModel', 'department');

			$data['depart'] = $this->department->get_depart('id,name', '');
			$data['employ'] = $this->employ->get_employ_by_depart();
			$data['userInfo'] = $this->employ->get_employ_info($uid);

			// Time
			$month = 0;
			$year = 0;
			if (isset($_POST['m']))
			$month = $_POST['m'];
			if (isset($_POST['y']))
			$year = $_POST['y'];
			if ($month <= 0)
			$month = date('m');
			if ($year <= 0)
			$year = date('Y');
			$data['month'] = $month;
			$data['year'] = $year;
			
			// Get days of month
			$data['numday'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			
			// Get log activity
			$temp = $this->reportlog->get('*', 'uid = ' . $uid . ' AND month = ' . $month . ' AND year = ' . $year, '', 'time ASC');
			$flag = 0;
			if (!empty($temp)) {
				for ($i = 1; $i <= $data['numday']; $i++) {
					if (!empty($temp[$i])) {
						foreach ($temp[$i] as $key => $item) {
							$h = date('H', $item['time']);
							$m = date('i', $item['time']);
							$temp[$i][$key]['position'] = (($h - 7) * 2) + 1;
							if ($m >= 30) {
								$temp[$i][$key]['position']++;
							}
						}
					}
				}
			}
			
			$position = array();
			if (!empty($temp)) {
				for ($i = 1; $i <= $data['numday']; $i++) {
					if (!empty($temp[$i])) {
						$index = 0;
						$count = 0;
						foreach ($temp[$i] as $key => $item) {
							$index++;
							$count++;
							if ($flag == 1) {
                                if ($item['action'] == 'login') {
                                    $tmp = $temp[$i][$key]['time'] + $this->_sessLife;
                                    $tmpH = date('H', $item['time']);
                                    $tmpM = date('m', $item['time']);

                                    $position[$i][$index]['action'] = 'end';
                                    $position[$i][$index]['position'] = (($h - 7) * 2) + 1;
                                    $position[$i][$index]['area'] = $item['from'];

                                    if ($tmpM >= 30) {
                                        $position[$index]['position']++;
                                    }
                                    $index++;
                                    $position[$i][$index]['action'] = 'start';
                                    $position[$i][$index]['position'] = $item['position'];
                                    $position[$i][$index]['area'] = $item['from'];
                                } else {
                                    $position[$i][$index]['action'] = 'end';
                                    $position[$i][$index]['position'] = $item['position'];
                                    $position[$i][$index]['area'] = $item['from'];
                                    $flag = 0;
                                }
                            } else {
                                if ($item['action'] == 'login') {
                                    $position[$i][$index]['action'] = 'start';
                                    $position[$i][$index]['position'] = $item['position'];
                                    $position[$i][$index]['area'] = $item['from'];
                                    $flag = 1;
                                }
                            }
                            if ($count == count($temp[$i])) {
                                if ($flag == 1) {
                                    $index++;
                                    $dur = 0;
                                    $dur = time() - $item['time'];
                                    $position[$i][$index]['action'] = 'end';
                                    if ($dur < $this->_sessLife) {
                                        $h = date('H');
                                        $m = date('i');
                                        $rPos = (($h - 7) * 2) + 1;
                                        if ($m >= 30)
                                            $rPos++;
                                        $position[$i][$index]['position'] = $rPos;
                                    } else {
                                        $position[$i][$index]['position'] = $item['position'] + ($this->_sessLife / 1800);
                                    }
                                    $position[$i][$index]['area'] = $item['from'];
                                }
                            }
                        }
                    }
                }
            }

            $data['logAct'] = $position;
            $data['navi'] = array(array('name' => 'Chấm công', 'href' => ''), array('name' => $data['userInfo']['fullname'], 'href' => ''));
            $data['main_content'] = 'reportlog/view';

            $this->load->vars($data);
            $this->load->view($this->_template);
        } else {
            redirect(base_url() . 'hrm/reportlog/dayoff');
        }
    }

}

