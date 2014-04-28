<?php

class HumanBenefit extends MX_Controller {

	private $template = "iso/template";
	private $_redirect = 'hrm/humanbenefit';
	private $_view = "humanbenefit/";
	private $_table = "mc_benefit_limitation ";
	private $_uid;
	private $_model;

	function __construct() {
		parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0) {
			redirect(base_url() . '?ref=' . base_url() . "hrm/benefit", 'refresh');
		}

		$this->load->helper('unit_helper');
		$this->load->helper('base_helper');
		$this->load->model('hrm/HumanBenefitModel', 'humanbenefit');
		$this->_model = $this->humanbenefit;
	}

	function bexist() {
		if ($this->input->is_ajax_request()) {
			$department = (int) $this->input->post('department');
			$position = (int) $this->input->post('position');
			if ($department > 0 && $position > 0) {
				$temp = $this->_model->get_benefit_id_by_position($department, $position);
				if (!empty($temp)) {
					$data = '';
					$count = 0;
					foreach ($temp as $item) {
						$count++;
						$data .= $item['benefit_id'];
						if ($count < count($temp)) {
							$data .= ',';
						}
					}
					print $data;
				}
			}
		} else {
			print '';
		}
	}

	public function data() {
		$data['activeLimitBenefit'] = TRUE;
		$data['listUrl'] = $this->_redirect;
		$data['addUrl'] = $this->_redirect . '/add';
		return $data;
	}

	public function index() {
		// Load data
		$data = $this->data();

		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');

		$data['depart'] = $this->department->get_depart('id,name', '');
		$data['employ'] = $this->employ->get_employ_by_depart();

		/* get name */
		$position = (int) $this->input->get('position');
        if ($position <= 0) {
            $where = '';
        } else {
            $where = array('position_id' => $position);
            $data['listUrl'] = $this->_redirect . '/?position=' . $position;
            $data['addUrl'] = $this->_redirect . '/add/?position=' . $position;
        }

        // Pagination
        $config['base_url'] = base_url() . $this->_redirect . '/index';
        $config['total_rows'] = $this->_model->count_all($where);
        $config['per_page'] = PER_PAGE_HRM;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['query'] = $this->_model->get($where, $config['per_page'], (int) $this->uri->segment(4), 'DESC');
        $data['actionDel'] = base_url() . $this->_redirect . '/delete';

        $data['main_content'] = $this->_view . "view";
        $this->load->vars($data);
        $this->load->view($this->template);
    }

    public function add() {
            // Load data
            $data = $this->data();

            // LEFT BOX
            $this->load->model('hrm/EmployeeModel', 'employ');
            $this->load->model('setting/DepartmentModel', 'department');

            $data['depart'] = $this->department->get_depart('id,name', '');
            $data['employ'] = $this->employ->get_employ_by_depart();

            /* get name */
            $position = (int) $this->input->get('position');
            if ($position <= 0) {
                $where = '';
                $request = '';
            } else {
                $where = array('position_id' => $position);
                $request = '/?position=' . $position;
                $data['listUrl'] = $this->_redirect . '/?position=' . $position;
                $data['addUrl'] = $this->_redirect . '/add/?position=' . $position;
            }

            /* load model */
            $this->load->model('setting/BenefitModel', 'benefit');
            $this->load->model('setting/DepartmentModel', 'department');
            $this->load->model('setting/CompanyModel', 'company');
            $this->load->model('setting/UnitModel', 'unit');
            $this->load->model('setting/PositionModel', 'position');
            $this->load->model('hrm/EmployeeModel', 'employ');
            $this->load->helper('base_helper');

            /* data */
            $data['action'] = base_url() . $this->_redirect . '/insert' . $request;
            $data['benefit'] = $this->benefit->getAllBenefit();

            $data['unit'] = $this->unit->getAllUnit();
            $data['company'] = $this->company->get();
            $data['depart'] = $this->department->get_depart('id,name', '');
            $data['employ'] = $this->employ->get_employ_by_depart();

            // CASE: exist company_id
            $getCom = (int) $this->input->get('com');
            if ($getCom > 0) {
                $data['eDepart'] = $this->department->get_depart('*', 'company_id=' . $getCom);
            }

            // CASE: exist department_id
            $getDep = (int) $this->input->get('dep');
            if ($getDep > 0) {
                $data['ePosition'] = $this->position->get_position_by_department($getDep);
            }

            /* load view */
            $data['main_content'] = $this->_view . "add";
            $this->load->vars($data);
            $this->load->view($this->template);
    }

    public function edit() {
            // Load data
            $data = $this->data();
            $id = (int) $this->uri->segment(4);

            $this->load->model('hrm/EmployeeModel', 'employ');
            $this->load->model('setting/DepartmentModel', 'department');

            $data['depart'] = $this->department->get_depart('id,name', '');
            $data['employ'] = $this->employ->get_employ_by_depart();

            /* Check Privacy */
            if ($id <= 0) {
                $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
                redirect(base_url() . $this->_redirect, 'refresh');
            }
            $data['query'] = $this->_model->row($id);

            if (!$data['query']) {
                $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
                redirect(base_url() . $this->_redirect, 'refresh');
            }

            /* get name */
            $position = (int) $this->input->get('position');
            if ($position <= 0)
                $request = '';
            else
                $request = '/?position=' . $data['query']->position_id;

            /* load model */
            $this->load->model('setting/BenefitModel', 'benefit');
            $this->load->model('setting/UnitModel', 'unit');
            $this->load->model('setting/PositionModel', 'position');
            $this->load->model('setting/CompanyModel', 'company');

            /* data */
            $data['action'] = base_url() . $this->_redirect . '/update' . $request;
            $data['benefit'] = $this->benefit->getAllBenefit();
            $data['unit'] = $this->unit->getAllUnit();
            $data['company'] = $this->company->get();
            $data['position'] = $this->position->get_position_by_department($data['query']->department_id);

            /* load view */
            $data['main_content'] = $this->_view . "edit";
            $this->load->vars($data);
            $this->load->view($this->template);
    }

    public function insert() {
            $_POST['input']['created'] = time();

            // Load model
            $this->load->model('hrm/EmployeeModel', 'employee');

            for ($i = 0; $i < count($_POST['benefit_id']); $i++) {
                $_POST['limitation'][$i] = str_replace('.', '', $_POST['limitation'][$i]);
                if ($_POST['benefit_id'][$i] > 0) {
                    $_POST['input']['limitation'] = $_POST['limitation'][$i];
                    $_POST['input']['benefit_id'] = $_POST['benefit_id'][$i];
                    $_POST['input']['unit'] = $_POST['unit'][$i];

                    $this->db->insert($this->_table, $_POST['input']);
                    $limit_id = $this->db->insert_id();

                    // Get employ by department and position
                    if ($_POST['input']['position_id'] > 0 && $_POST['input']['department_id'] > 0) {
                        $listEmployee = $this->employee->get_by_joblevel($_POST['input']['position_id'], $_POST['input']['department_id']);
                        if (isset($listEmployee) && count($listEmployee) > 0 && is_array($listEmployee)) {
                            $zz = 0;
                            $be = array();
                            foreach ($listEmployee as $row) {
                                $zz++;
                                $be[$zz]['benefit_limitation_id'] = $limit_id;
                                $be[$zz]['employee_id'] = $row['id'];
                                $be[$zz]['limitation'] = $_POST['limitation'][$i];
                                $be[$zz]['benefit_id'] = $_POST['benefit_id'][$i];
                                if ($_POST['unit'][$i] != '') {
                                    $be[$zz]['unit'] = $_POST['unit'][$i];
                                } else {
                                    $be[$zz]['unit'] = 1;
                                }
                            }
                            $this->db->insert_batch('mc_benefit_employee', $be);
                        }
                    }
                }
            }
            $redirect = base_url() . 'hrm/humanbenefit';
            $this->session->set_flashdata('success', 'Bạn đã thêm mới thành công !');
            redirect($redirect, 'refresh');
    }

    public function update() {
            $id = (int) $this->input->post('id');
            if ($id <= 0) {
                $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác !');
                redirect(base_url() . $this->_redirect, 'refresh');
            }

            /* get name */
            $name = trim($this->input->get('name'));
            if (isset($name) && $name != "")
                $request = '/?name=' . $name;
            else
                $request = '';
			
            if ($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']))) {
                $this->session->set_flashdata('success', 'Bạn đã cập nhật thành công !');
            } else {
                $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác!');
            }
            redirect(base_url() . $this->_redirect . $request, 'refresh');
    }

    public function delete() {
            if ($this->input->is_ajax_request()) {
                $id = (int) $_POST['id'];
                $this->db->delete($this->_table, array('id' => $id));
            }
    }

}