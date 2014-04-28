<?php
class EmployeeBenefit extends MX_Controller {

	private $template = "iso/template";
	private $_redirect = 'hrm/employeebenefit';
	private $_view = "employeebenefit/";
	private $_table = "mc_benefit_employee";
	private $_navi = 'Định mức nhóm';
	private $_model;
	private $_uid;

	function __construct() {
		parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0) {
			redirect(base_url('home'), 'refresh');
		}

		$this->load->helper('unit_helper');
		$this->load->helper('base_helper');
		$this->load->model('hrm/GroupbenefitModel', 'employeebenefit');
		$this->_model = $this->employeebenefit;
	}

	public function index() {
		redirect(base_url('hrm/employeebenefit/listing'));
	}

	public function listing() {
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');

		$data['depart'] = $this->department->get_depart('id,name', '');
		$data['employ'] = $this->employ->get_employ_by_depart();

		// Pagination
		$where = array();
		
		// Get by department
		$department = (int)$this->input->get('department');
		if ($department > 0) $where = array('department' => $department);
		
		$config['base_url'] = base_url($this->_redirect) . '/index';
		$config['total_rows'] = $this->_model->count_all($where);
		$config['per_page'] = PER_PAGE_HRM;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$data['query'] = $this->_model->get($where, $config['per_page'], (int) $this->uri->segment(4), 'DESC');
		$data['actionDel'] = base_url($this->_redirect) . '/delete';
		
		// Navigation
		$data['navi'] = array(array('name' => $this->_navi, 'href' => base_url('hrm/employeebenefit')));
		
		$data['main_content'] = $this->_view . "listing";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
	
	public function add() {
		// LEFT BOX
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');
		$data['depart'] = $this->department->get_depart('id,name', '');
		$data['employ'] = $this->employ->get_employ_by_depart();

		// Load model
		$this->load->model('setting/BenefitModel', 'benefit');
		$this->load->model('setting/DepartmentModel', 'department');
		$this->load->model('setting/CompanyModel', 'company');
		$this->load->model('setting/UnitModel', 'unit');
		$this->load->model('setting/PositionModel', 'position');

		// Data
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

		// Navigation
		$data['navi'] = array(	array('name' => $this->_navi, 'href' => base_url('hrm/employeebenefit')),
										array('name' => 'Thêm mới', 'href' => base_url('hrm/employeebenefit/add')));
		
		$data['main_content'] = $this->_view . "add";
		$this->load->vars($data);
		$this->load->view($this->template);
	}

	public function edit() {
		$groupId = (int)$this->uri->segment(4);
		if ($groupId < 0) redirect(base_url($this->_redirect), 'refresh');
		
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');
		$this->load->model('setting/BenefitModel', 'benefit');
		$this->load->model('setting/UnitModel', 'unit');
		$this->load->model('setting/PositionModel', 'position');
		$this->load->model('setting/CompanyModel', 'company');

		$data['depart'] = $this->department->get_depart('id,name', '');
		$data['employ'] = $this->employ->get_employ_by_depart();
		$data['query'] = $this->_model->row($groupId);
		
		if (!$data['query']) {
			redirect(base_url($this->_redirect), 'refresh');
		}
		
		// Data
		$data['groupBenefit'] = $this->_model->get_group_benefit_detail($groupId);
		$data['numBenefit'] = (int)count($data['groupBenefit']);
		$data['benefit'] = $this->benefit->getAllBenefit();
		$data['unit'] = $this->unit->getAllUnit();
		$data['company'] = $this->company->get();
		$data['position'] = $this->position->get_position_by_department($data['query']->department_id);
		
		$data['main_content'] = $this->_view . "edit";
		$this->load->vars($data);
		$this->load->view($this->template);
	}

	public function insert() {
		if (isset($_POST['input']) && !empty($_POST['input'])) {
			$this->db->insert($this->_table, $_POST['input']);
			$newGroupId = (int)$this->db->insert_id();
			if ($newGroupId > 0) {
				$numBenefit = (int)$this->input->post('num_benefit');
				$arBenefit = $this->input->post('benefit_id');
				$arLimitation = $this->input->post('limitation');
				$arUnit = $this->input->post('unit');
				$ii = 0;
				$data = array();
				for ($i=0; $i<$numBenefit; $i++) {
					if ($arBenefit[$i] > 0) {
						$ii++;
						$data[$ii]['group_id'] = $newGroupId;
						$data[$ii]['benefit_id'] = $arBenefit[$i];
						$data[$ii]['limitation'] = str_replace('.', '', $arLimitation[$i]);
						$data[$ii]['unit_id'] = $arUnit[$i];
					}
				}
				if (!empty($data)) $this->db->insert_batch('mc_benefit_employee_detail', $data);
			}
		}
		
		$redirect = base_url() . 'hrm/employeebenefit';
		$this->session->set_flashdata('success', 'Bạn đã thêm mới thành công !');
		redirect($redirect, 'refresh');
	}

	public function update() {
		$groupId = (int)$this->input->post('group_id');
		if ($groupId <= 0) redirect($this->_redirect);
		
		if (isset($_POST['input']) && !empty($_POST['input'])) {
			$this->db->where('id', $groupId);
			$this->db->update($this->_table, $_POST['input']);
			if ($groupId > 0) {
				$numBenefit = (int)$this->input->post('num_benefit');
				$arBenefit = $this->input->post('benefit_id');
				$arLimitation = $this->input->post('limitation');
				$arUnit = $this->input->post('unit');
				$ii = 0;
				$data = array();
				for ($i=0; $i<$numBenefit; $i++) {
					if ($arBenefit[$i] > 0) {
						$ii++;
						$data[$ii]['group_id'] = $groupId;
						$data[$ii]['benefit_id'] = $arBenefit[$i];
						$data[$ii]['limitation'] = str_replace('.', '', $arLimitation[$i]);
						$data[$ii]['unit_id'] = $arUnit[$i];
					}
				}
				if (!empty($data)) {
					$this->db->query('DELETE FROM mc_benefit_employee_detail WHERE group_id = '.$groupId);
					$this->db->insert_batch('mc_benefit_employee_detail', $data);
				}
			}
		}
		
		$redirect = base_url() . 'hrm/employeebenefit';
		$this->session->set_flashdata('success', 'Bạn đã thêm mới thành công !');
		redirect($redirect, 'refresh');
	}

	public function delete() {
		if ($this->input->is_ajax_request()) {
			$id = (int) $_POST['id'];
			$this->db->delete($this->_table, array('id' => $id));
			$this->db->delete('mc_benefit_employee_detail', array('group_id' => $id));
		}
	}

}