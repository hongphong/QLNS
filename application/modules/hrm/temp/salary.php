<?php
class Salary extends MX_Controller {
	private $_template = 'iso/template';
        private $_template_login = "login/template";
	
	function __construct() {
		parent::__construct();
		$this->load->helper('base_helper');
	}
	
	function pertotal() {
		$uid = $this->input->get('uid');
		if ($uid > 0) {
			// Load model
			$this->load->model('hrm/SalaryModel', 'salary');
			
			// LEFT BOX
			$this->load->model('hrm/EmployeeModel', 'employ');
			$this->load->model('setting/DepartmentModel', 'department');
			
			$data['depart'] = $this->department->get_depart('id,name','');
			$data['employ'] = $this->employ->get_employ_by_depart();
			
			// Time
			$month = 0;
			$year = 0;
			if (isset($_GET['m'])) $month = $_GET['m'];
			if (isset($_GET['y'])) $year = $_GET['y'];
			if ($month <= 0) $month = date('m') - 1;
			if ($year <= 0) $year = date('Y');
			$data['month'] = $month;
			$data['year'] = $year;
			
			$data['userInfo'] = $this->employ->get_employ_info($uid);
			$data['userCost'] = $this->salary->get_cost($uid, $month, $year);
			$data['userSalary'] = $this->salary->get_base_salary($uid, $month, $year);
			$data['allDepart'] = $this->department->get_depart('id,name', '');
			$data['navi'] = array(	array('name' => 'Tổng hợp', 'href' => base_url() . 'hrm/salary/total'),
									array('name' => $data['userInfo']['fullname'], 'href' => ''));
			
			$data['main_content'] = 'salary/total_person';
			
			$this->load->vars($data);
			$this->load->view($this->_template);
			
		} else {
			redirect(base_url().'hrm/salary');
		}
	}
	
	function total() {
		// Check permisson
		if (1) {
			// Load model
			$this->load->model('setting/DepartmentModel', 'department');
			$this->load->model('hrm/EmployeeModel', 'employee');
			$this->load->model('hrm/SalaryModel', 'salary');
			$uid = $this->session->userdata('uid');
                        $emInfo = $this->employee->get_employee_info_by_uid($uid);
                        $data['emInfo'] = $emInfo;
			// LEFT BOX
			$data['depart'] = $this->department->get_depart('id,name','');
			$data['employ'] = $this->employee->get_employ_by_depart();
			
			// Get month && year
			$year = 0;
			$month = 0;
			$department = 0;
			if (isset($_POST['m'])) $month = $_POST['m'];
			if (isset($_POST['y'])) $year = $_POST['y'];
			if (isset($_POST['d'])) $department = $_POST['d'];
			if ($month <= 0) $month = date('m') - 1;
			if ($year <= 0) $year = date('Y');
			$data['month'] = $month;
			$data['year'] = $year;
			$data['department'] = $department;
			//var_dump($department);
			$data['allEmploy'] = $this->employee->get_employee($department);
			$data['allDepart'] = $this->department->get_depart('id,name', '');
                        //var_dump($department);die;
			$data['allSalary'] = $this->salary->get_base_salaries($month, $year, $department);
			// Navigation
			$label = 'Toàn công ty';
			if ($department > 0) {
				if (!empty($data['allDepart'])) {
					foreach ($data['allDepart'] as $d) {
						if ($d['id'] == $department) {
							$label = $d['name'];
						}
					}
				}
			}
			
			$data['navi'] = array(	array('name' => 'Tổng hợp', 'href' => base_url() . 'hrm/salary/total'),
									array('name' => $label, 'href' => ''));
			
			$data['allCost'] = $this->salary->get_costs($month, $year, $department);
                        //var_dump($data['allSalary']);die;
			$data['main_content'] = 'salary/total';
			
			$this->load->vars($data);
			$this->load->view($this->_template);
		}
	}
	
	function cost() {
		if (1) {
			// Load model
			$this->load->model('setting/DepartmentModel', 'department');
			$this->load->model('hrm/EmployeeModel', 'employee');
			$this->load->model('hrm/SalaryModel', 'salary');
			
			// LEFT BOX
			$data['depart'] = $this->department->get_depart('id,name','');
			$data['employ'] = $this->employee->get_employ_by_depart();
			$uid = $this->session->userdata('uid');
                        $emInfo = $this->employee->get_employee_info_by_uid($uid);
                        $data['emInfo'] = $emInfo;
			// Time
			$department = 0;
			$month = 0;
			$year = 0;
			if (isset($_POST['m'])) $month = $_POST['m'];
			if (isset($_POST['y'])) $year = $_POST['y'];
			if (isset($_POST['d'])) $department = $_POST['d'];
			if ($month <= 0) $month = date('m') - 1;
			if ($year <= 0) $year = date('Y');
			if($month == 0){
                           $month = 12;
                           $year = date('Y') - 1; 
                        }
			$data['department'] = $department;
			$data['month'] = $month;
			$data['year'] = $year;
			
			// Navigation
			$data['navi'] = array(	array('name' => 'Chi phí', 'href' => base_url() . 'salary'),
									array('name' => 'Toàn công ty', 'href' => base_url() . ''));
			
			$data['allDepart'] = $this->department->get_depart('id,name', '');
			$data['allEmploy'] = $this->employee->get_employee($department);
			$data['allCost'] = $this->salary->get_costs($month, $year, $department);
			
			$data['main_content'] = 'salary/cost';
			
			$this->load->vars($data);
			$this->load->view($this->_template);
		}
	}
	
	function percost() {
		$uid = (int)$this->input->get('uid');
                
		if ($uid > 0) {
			// Load model
                        
			$this->load->model('hrm/BenefitEmployeeModel', 'benefitemploy');
			$this->load->model('hrm/SalaryModel', 'salary');
			$this->load->model('hrm/EmployeeModel', 'employ');
			$this->load->model('setting/UnitModel', 'unit');
			$this->load->model('setting/DepartmentModel', 'department');
			
			// LEFT BOX
			$data['depart'] = $this->department->get_depart('id,name','');
			$data['employ'] = $this->employ->get_employ_by_depart();
			$emId = $this->employ->get_employee_id_by_uid($uid);
			// Time
			$month = 0;
			$year = 0;
			if (isset($_GET['m'])) $month = $_GET['m'];
			if (isset($_GET['y'])) $year = $_GET['y'];
			if ($month <= 0) $month = date('m') - 1;
			if ($year <= 0) $year = date('Y');
			$data['month'] = $month;
			$data['year'] = $year;
			
			$data['unit'] = $this->unit->getAllUnit();
			$data['userInfo'] = $this->employ->get_employ_info($uid);
			$data['userBenefit'] = $this->benefitemploy->get_benefit_employee($emId);
			$data['userCost'] = $this->salary->get_cost($uid, $month, $year);
			$temp = array();
			$data['userTotalCost'] = 0;
                        //var_dump($data['userBenefit']);die;
			if (!empty($data['userBenefit'])) {
				foreach ($data['userBenefit'] as $key=>$ub) {
					$temp[] = $ub['id'];
					$data['userBenefit'][$key]['realspend'] = 0;
					$data['userBenefit'][$key]['quantity'] = 1;
					$data['userBenefit'][$key]['price'] = $ub['limitation'];
					$data['userBenefit'][$key]['money'] = $ub['limitation'];
					if (!empty($data['userCost'])) {
						foreach ($data['userCost'] as $cost) {
							if ($cost['benefit_id'] == $ub['id']) {
                                                                $money = $cost['quantity']*$ub['limitation'];
								$data['userBenefit'][$key]['realspend'] = $cost['realspend'];
								$data['userBenefit'][$key]['quantity'] = $cost['quantity'];
								$data['userBenefit'][$key]['money'] = $money;
								$data['userTotalCost'] += doubleval($cost['realspend']);
								continue;
							}
						}
					}
				}
			}
			$data['listId'] = implode(',', $temp);
			
			// Navigation
			$data['navi'] = array(	array('name' => 'Chi phí', 'href' => base_url() . 'hrm/salary/cost'),
									array('name' => $data['userInfo']['fullname'], 'href' => base_url() . ''));
			//var_dump($data);die;
			$data['main_content'] = 'salary/cost_person';
			
			$this->load->vars($data);
			$this->load->view($this->_template);
			
		} else {
			redirect(base_url().'home');
		}
	}
	
	function index() {
		// Check permisson
		if (1) {
			$uid = (int)$this->session->userdata('uid');
			if($uid > 0){
			
			// Load model
			$this->load->model('setting/DepartmentModel', 'department');
			$this->load->model('hrm/EmployeeModel', 'employee');
			$this->load->model('hrm/SalaryModel', 'salary');
			$uid = $this->session->userdata('uid');
			$emInfo = $this->employee->get_employee_info_by_uid($uid);
			$data['emInfo'] = $emInfo;
			
			// LEFT BOX
			$data['depart'] = $this->department->get_depart('id,name','');
			$data['employ'] = $this->employee->get_employ_by_depart();
			
			// Get month && year
			$year = 0;
			$month = 0;
			$department = 0;
			if (isset($_POST['m'])) $month = $_POST['m'];
			if (isset($_POST['y'])) $year = $_POST['y'];
			if (isset($_POST['d'])) $department = $_POST['d'];
			if ($month <= 0) $month = date('m') - 1;
			if ($year <= 0) $year = date('Y');
                        if($month == 0){
                           $month = 12;
                           $year = $year - 1;
                        }
			$data['month'] = $month;
			$data['year'] = $year;
			$data['department'] = $department;
			
			// Navigation
			$data['navi'] = array(	array('name' => 'Tính lương', 'href' => base_url() . 'salary'),
									array('name' => 'Toàn công ty', 'href' => base_url() . ''));
			$data['nkl'] = $this->employee->get_nkl_by_month($month);
                        
			$data['allEmploy'] = $this->employee->get_employee($department);
			$data['allDepart'] = $this->department->get_depart('id,name', '');
			$data['allTimeWork'] = $this->salary->get_time_work($month, $year, $department);
			$data['main_content'] = 'salary/main';
			$this->load->vars($data);
			$this->load->view($this->_template);
                   }else{
                      $this->load->view($this->_template_login);
                   }
		}
	}
	
	function update_cost() {
		if (isset($_POST['submit'])) {
			$strId = $this->input->post('listId');
			$listId = explode(',', $strId);
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			$uid = $this->input->post('uid');
			if (!empty($listId)) {
				$count = 0;
				foreach ($listId as $id) {
					$count++;
					$data[$count]['benefit_id'] = $id;
					$data[$count]['month'] = $month;
					$data[$count]['year'] = $year;
					$data[$count]['uid'] = $uid;
					$data[$count]['price'] = str_replace('.', '', $this->input->post('price-'.$id));
					$data[$count]['quantity'] = $this->input->post('quantity-'.$id);
					$data[$count]['money'] = str_replace('.', '', $this->input->post('money-'.$id));
					$data[$count]['realspend'] = str_replace('.', '', $this->input->post('realspend-'.$id));
				}
				if (!empty($data)) {
					$this->load->model('hrm/SalaryModel', 'salary');
					$this->salary->empty_cost($uid, $month, $year);
					$this->salary->inserts_cost($data);
					redirect(base_url().'hrm/salary/cost?uid='.$uid);
				}
			}
		}
	}
	
	function update_salary() {
		if (isset($_POST['submit'])) {
			$listEmpId = $this->input->post('allEmployId');
			$redirect = $this->input->post('redirect');
			$arEmpId = explode(',', $listEmpId);
			if (!empty($arEmpId)) {
				$count = 0;
				$this->load->model('hrm/SalaryModel', 'salary');
				foreach ($arEmpId as $empId) {
					$salValue = $this->input->post($empId.'-salary');
					$month = $this->input->post('month');
					$year = $this->input->post('year');
					$salValue = intval(str_replace('.', '', $salValue));
					if ($salValue > 0) {
						$count++;
						$data[$count]['uid'] = $empId;
						$data[$count]['value'] = $salValue;
						$data[$count]['month'] = $month;
						$data[$count]['year'] = $year;
						$this->salary->empty_salary_base($empId, $month, $year);
					}
				}
				if (!empty($data)) $this->salary->inserts_base($data);
				redirect($redirect);
			}
		} else {
			redirect(base_url().'home');
		}
	}
	
	function update_time_work() {
		if (!$this->input->is_ajax_request()) {
			redirect('/home');
		} else {
			$employId = $this->input->post('employ_id');
			$level = $this->input->post('level');
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			$value = $this->input->post('value');
			
			$db = $this->db->query('SELECT id FROM sal_time_work WHERE month = '.$month.' AND year = '.$year.' AND uid = '.$employId);
			
			if ($db->num_rows() > 0) {
				$this->db->query('UPDATE sal_time_work SET `tw'. $level .'`='. $value .' WHERE uid = '. $employId .' AND month = '. $month .' AND year = '. $year);
			} else {
				$this->load->model('hrm/SalaryModel', 'salary');
				$data['uid'] = $employId;
				$data['month'] = $month;
				$data['year'] = $year;
				$data['tw'.$level] = $value;
				$this->salary->insert_work_time($data);
			}
		}
	}
}


