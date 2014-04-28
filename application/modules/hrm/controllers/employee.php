<?php
class Employee extends MX_Controller {

   private $template = "iso/template";
   private $_redirect = 'hrm/employee';
   private $_view = "employee/";
   private $_table = "mc_employee";
   private $_uid;
   private $_model;

   function __construct() {
      parent::__construct();
      $this->_uid = $this->session->userdata('uid');
      if (!isset($this->_uid) OR $this->_uid <= 0) {
         redirect(base_url() . '?ref=' . base_url() . "hrm/employee", 'refresh');
      }
      $this->load->helper('city_helper');
      $this->load->helper('base_helper');
      $this->load->model('hrm/EmployeeModel', 'employee');
      $this->_model = $this->employee;
   }

   public function data() {
      $data['activeEmployee'] = TRUE;
      return $data;
   }

   public function index() {
      // Load data
      $data = $this->data();

      $this->load->model('hrm/EmployeeModel', 'employ');
      $this->load->model('setting/DepartmentModel', 'department');

      $data['depart'] = $this->department->get_depart('id,name', '');
      $data['employ'] = $this->employ->get_employ_by_depart();
      $data['position'] = $this->employ->get_all_position();
      
      // Pagination
      $config['base_url'] = base_url() . $this->_redirect . '/index';
      $config['total_rows'] = $this->_model->count_all('');
      $config['per_page'] = PER_PAGE_HRM;
      $config['uri_segment'] = 4;
      $config['full_tag_open'] = '<div class="pagination">';
      $config['full_tag_close'] = '</div>';
      $this->pagination->initialize($config);
      $data['pagination'] = $this->pagination->create_links();
      $data['query'] = $this->_model->get($config['per_page'], (int) $this->uri->segment(4), 'DESC');
      $data['actionDel'] = base_url() . $this->_redirect . '/delete';
      $data['main_content'] = $this->_view . "view";
      
      $data['navi'] = array(array('name' => 'Nhân viên', 'href' => base_url('/hrm/employee')),
                           array('name' => 'Danh sách', 'href' => base_url('/hrm/employee')));

      $this->load->vars($data);
      $this->load->view($this->template);
   }

   public function add() {
      /* Load data */
      $data = $this->data();

      /* Load model */
      $this->load->model('setting/CompanyModel', 'company');
      $this->load->model('hrm/EmployeeModel', 'employ');
      $this->load->model('setting/DepartmentModel', 'department');

      $data['depart'] = $this->department->get_depart('id,name', '');
      $data['employ'] = $this->employ->get_employ_by_depart();

      /** Data */
      $data['company'] = $this->company->get();
      $data['action'] = base_url() . $this->_redirect . '/insert';
      
      $data['navi'] = array(array('name' => 'Nhân viên', 'href' => base_url('/hrm/employee')),
                           array('name' => 'Thêm mới', 'href' => base_url('/hrm/employee/add')));

      /** Load view */
      $data['main_content'] = $this->_view . "add";
      $this->load->vars($data);
      $this->load->view($this->template);
   }

   public function edit() {
      /* Load data */
      $data = $this->data();
      $id = (int) $this->uri->segment(4);
      $uid = $this->session->userdata('uid');
      $data['uid'] = $uid;
      /* Load model */
      $this->load->model('setting/PositionModel', 'position');
      $this->load->model('setting/CompanyModel', 'company');
      $this->load->model('hrm/EmployeeModel', 'employ');
      $this->load->model('setting/DepartmentModel', 'department');

      $data['depart'] = $this->department->get_depart('id,name', '');
      $data['employ'] = $this->employ->get_employ_by_depart();

      /** Check privacy */
      if ($id <= 0) {
         $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      $data['query'] = $this->_model->row($id);
      if (!$data['query']) {
         $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      /* Data */
      $data['action'] = base_url($this->_redirect . '/update');
      $data['company'] = $this->company->get();
      $data['position'] = $this->position->get_position_by_department($data['query']->department_id);

      $data['navi'] = array(array('name' => 'Nhân viên', 'href' => base_url('/hrm/employee')),
                           array('name' => $data['query']->fullname, 'href' => base_url('/hrm/employee/edit/'.$data['query']->id)));

      /* Load view */
      $data['main_content'] = $this->_view . "edit";
      $this->load->vars($data);
      $this->load->view($this->template);
   }

   public function insert() {
      $this->load->model('setting/CompanyModel', 'company');
      $this->load->library('UserManager');
      
      $child = $this->input->post('child_name');
      $_POST['input']['child_name'] = '';
      $arName = array();
      if (!empty($child)) {
      	foreach ($child as $c) {
      		$c = trim($c);
      		if ($c != '') {
      			$arName[] = $c;
      		}
      	}
      }
      if (!empty($arName)) $_POST['input']['child_name'] = implode('|', $arName);
      
      $messages = array();
      $error_code = 0;
      $username = trim($this->input->post('name'));

      $tmp = UserManager::validate($username);
      if (is_array($tmp) && count($tmp) > 0) {
         $error_code = $error_code | 1;
      }
      $messages = array_merge($messages, $tmp);

      // Job level
      if (isset($_POST['input']['job_level'])) {
         if ((int) $_POST['input']['job_level'] <= 0) {
            $_POST['input']['job_level'] = 1;
         }
      } else {
         $_POST['input']['job_level'] = 1;
      }

      // Position
      if (!isset($_POST['input']['position_id'])) {
         $_POST['input']['position_id'] = 1;
      }

      if (count($messages) == 0) {
         if ((int) $_POST['input']['job_level'] == 0)
            $_POST['input']['job_level'] = 1;
         
         if ($this->db->insert($this->_table, $_POST['input'])) {
            $this->session->set_flashdata('success', 'Bạn đã thêm mới thành công !');

            // Return employee ID after insert
            $emid = $this->db->insert_id();

            // Perm user
            $perm['name'] = $username;
            $perm['password'] = md5($this->input->post('password'));
            $perm['employ_id'] = $emid;

            // Insert user account in table Perm_user
            $this->db->insert('perm_user', $perm);

            // Return user account ID after insert
            $uid = $this->db->insert_id();

            // Update "uid" for table employee
            $this->db->update('mc_employee', array('uid' => $uid), array('id' => $emid));
         } else {
            $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác !');
         }
         redirect(base_url() . $this->_redirect, 'refresh');
      } else {
         /* load data */
         $data = $this->data();

         $_POST['input']['name'] = $username;
         $data['password'] = $this->input->post('password');

         /* load model */
         $this->load->model('hrm/EmployeeModel', 'employ');
         $this->load->model('setting/DepartmentModel', 'department');

         $data['depart'] = $this->department->get_depart('id,name', '');
         $data['employ'] = $this->employ->get_employ_by_depart();
         $data['company'] = $this->company->get();

         /* data */
         $data['action'] = base_url() . $this->_redirect . '/insert';
         $data['data'] = $_POST['input'];
         $data['messages'] = $messages;
         $data['navi'] = array(array('name' => 'Nhân viên', 'href' => base_url('/hrm/employee')),
                           array('name' => 'Thêm mới', 'href' => base_url('/hrm/employee/add')));

         /* load view */
         $data['main_content'] = $this->_view . "add";
         $this->load->vars($data);
         $this->load->view($this->template);
      }
   }

   public function update() {
      // Employee ID
      $id = (int) $this->input->post('id');
      if ($id <= 0) {
         $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      // Update user account
      if (isset($_POST['username'])) $uu['name'] = $_POST['username'];
      if (isset($_POST['password'])) $uu['password'] = md5($_POST['password']);
      $uid = (int) $this->input->post('uid');
		if ($this->_uid == 1 && !empty($uu)) {
         $this->db->update('perm_user', $uu, array('id' => $uid));
      }
      
      // Update infomation
      $child = $this->input->post('child_name');
      $childAge = $this->input->post('child_age');
      $_POST['input']['child_name'] = '';
      $_POST['input']['child_age'] = '';
      $_POST['input']['date_start_work'] = 0;
      
      $strDateStartWork = $this->input->post('date_start_work');
      if ($strDateStartWork != DATE_FORMAT) $_POST['input']['date_start_work'] = convert_date_to_time($strDateStartWork);
      
      $arName = array();
      if (!empty($child)) {
      	foreach ($child as $key=>$c) {
      		$c = trim($c);
      		if ($c != '') {
      			$arName[] = $c;
      			$arAge[] = $childAge[$key];
      		}
      	}
      }
      if (!empty($arName)) $_POST['input']['child_name'] = implode('|', $arName);
      if (!empty($arAge)) $_POST['input']['child_age'] = implode('|', $arAge);
      
      if ($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']))) {
         $this->session->set_flashdata('success', 'Bạn đã cập nhật thành công !');
      } else {
         $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác!');
      }
      redirect(base_url() . $this->_redirect, 'refresh');
   }

   public function delete() {
      if ($this->input->is_ajax_request()) {
         $id = (int) $_POST['id'];
         $this->db->delete($this->_table, array('id' => $id));
      }
   }

   public function deletemulti() {
      if ($this->input->is_ajax_request()) {
         $ids = $_POST['ids'];
         $this->db->where_in('id', $ids);
         $this->db->delete($this->_table);
      }
   }

   public function location() {
      if ($this->input->is_ajax_request()) {
         $cid = (int) $this->input->post('id');
         if ($cid <= 0)
            exit();

         /* load model */
         $this->load->model('setting/PositionModel', 'position');

         /* data */
         $data = $this->position->get_position_by_department($cid);
         if ($data) {
            foreach ($data as $row) {
               echo '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
         } else {
            echo '';
         }
      } else {
         echo '';
      }
      exit();
   }

   public function ajax_employee() {
      if ($this->input->is_ajax_request()) {
         $department = (int) $this->input->post('department');
         if ($department > 0) {
            $html = '';
            $this->load->model('EmployeeModel', 'employ');
            $listEmploy = $this->employ->get_employee($department);
            if (!empty($listEmploy)) {
               $html .= '<option value="0">- Chọn nhân viên -</option>';
               foreach ($listEmploy as $em) {
                  $html .= '<option id="em_' . $em['id'] . '" value="' . $em['id'] . '">' . $em['fullname'] . '</option>';
               }
            } else {
               $html .= '<option value="">- Phòng chưa có nhân viên -</option>';
            }
            print $html;
         }
         exit();
      }
      exit();
   }

   public function detail() {
      $this->load->model('setting/DepartmentModel', 'department');
      $this->load->model('hrm/EmployeeModel', 'employee');
      
      $uid = $this->session->userdata('uid');
      $emInfo = $this->employee->get_employee_info_by_uid($uid);
      $data['emInfo'] = $emInfo;
      // LEFT BOX
      $data['depart'] = $this->department->get_depart('id,name', '');
      $data['employ'] = $this->employee->get_employ_by_depart();
      //var_dump($data['employ']);die;
      // Get month && year
      $year = 0;
      $month = 0;
      $month1 = 0;
      $year1 = 0;
      $department = 0;
      if (isset($_POST['m']))
         $month1 = $_POST['m'];
      if (isset($_POST['y']))
         $year1 = $_POST['y'];
      if (isset($_POST['d']))
         $department = $_POST['d'];
      if ($month <= 0)
         $month = date('m') - 1;
      if ($year <= 0)
         $year = date('Y');
      
      $emId = $this->uri->segment(4);
      
      $data['allEmploy'] = $this->employee->get_employee_info_by_id($emId);
      $data['allDepart'] = $this->department->get_depart('id,name', '');
      
      $data['navi'] = array(array('name' => 'Chi tiết nhân viên', 'href' => ''),
          array('name' => $data['allEmploy'][0]['fullname'], 'href' => ''));

      /* Load data */
      $data['month'] = $month;
      $data['year'] = $year;
      $data['department'] = $department;
      $id = (int) $this->uri->segment(4);
      $uid = $this->session->userdata('uid');
      $data['uid'] = $uid;
      
      /* Load model */
      $this->load->model('setting/PositionModel', 'position');
      $this->load->model('setting/CompanyModel', 'company');
      $this->load->model('hrm/EmployeeModel', 'employ');
      $this->load->model('setting/DepartmentModel', 'department');
      $data['employ'] = $this->employ->get_employ_by_depart();

      /** Check privacy */
      if ($id <= 0) {
         $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      $data['query'] = $this->_model->row($id);
      if (!$data['query']) {
         $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      /* Data */
      $data['action'] = base_url() . $this->_redirect . '/update';
      $data['company'] = $this->company->get();
      $data['position'] = $this->position->get_position_by_department($data['query']->department_id);
      $data['degree'] = $this->employee->get_employee_degree($emId);
      $data['main_content'] = 'detail';
      $this->load->vars($data);
      $this->load->view($this->template);
   }

}

