<?php

class EmployeeDegree extends MX_Controller {

   private $template = "iso/template";
   private $_redirect = 'hrm/employeeDegree';
   private $_view = "employeedegree/";
   private $_table = "mc_employee_degree";
   private $_uid;
   private $_model;

   function __construct() {
      parent::__construct();
      $this->_uid = $this->session->userdata('uid');
      if (!isset($this->_uid) OR $this->_uid <= 0) {
         redirect(base_url() . '?ref=' . base_url() . "hrm/employeeDegree", 'refresh');
      }

      $this->load->model('hrm/EmployeeDegreeModel', 'employeedegree');
      $this->load->helper('base_helper');
      $this->_model = $this->employeedegree;
   }

   public function data() {
      $data['activeEmployeeDegree'] = TRUE;
      $data['listUrl'] = $this->_redirect;
      $data['addUrl'] = $this->_redirect . '/add';
      return $data;
   }

   public function index() {
      // Load data
      $data = $this->data();

      // Load model
      $this->load->model('hrm/EmployeeModel', 'employ');
      $this->load->model('setting/DepartmentModel', 'department');
      $uid = $this->_uid;
      // For left block
      $data['depart'] = $this->department->get_depart('id,name', '');
      $data['employ'] = $this->employ->get_employ_by_depart();
      $em_id = 0;
      $em_id = $this->input->get('employee_id');
      $data['userInfo'] = $this->employ->get_employ_info($em_id);
      $where = '';
      $data['userInfo'] = array();
      if ($em_id != 0) {
         foreach ($data['employ'] as $key => $value) {
            foreach ($value as $val) {
               if ($val['id'] == $em_id) {
                  $data['userInfo'] = $val;
               }
            }
         }
      }
      if ($em_id != 0)
         $where = "employee_id = $em_id";
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
      $data['navi'] = array();
      if ($data['userInfo']) {
         $data['navi'] = array(array('name' => 'Bằng cấp', 'href' => ''), array('name' => $data['userInfo']['fullname'], 'href' => ''));
      }
      $data['main_content'] = $this->_view . "view";
      
      $data['navi'] = array(array('name' => 'Hồ sơ', 'href' => base_url('/hrm/employeeDegree')),
                           array('name' => 'Danh sách', 'href' => base_url('/hrm/employeeDegree')));

      $this->load->vars($data);
      $this->load->view($this->template);
   }

   public function add() {
      // Load
      $data = $this->data();

      $this->load->model('hrm/EmployeeModel', 'employ');
      $this->load->model('setting/DepartmentModel', 'department');

      $data['depart'] = $this->department->get_depart('id,name', '');
      $data['employ'] = $this->employ->get_employ_by_depart();

      /* get name */
      $name = trim($this->input->get('name'));
      if (isset($name) && $name != "") {
         $where = array('employee' => $name);
         $data['listUrl'] = $this->_redirect . '/?name=' . $name;
         $data['addUrl'] = $this->_redirect . '/add/?name=' . $name;
         $request = '/?name=' . $name;
      } else {
         $where = '';
         $request = '';
      }

      /* data */
      $data['action'] = base_url() . $this->_redirect . '/insert' . $request;
      $data['name'] = $name;
      
      $data['navi'] = array(array('name' => 'Hồ sơ', 'href' => base_url('/hrm/employeeDegree')),
                           array('name' => 'Thêm mới', 'href' => base_url('/hrm/employeeDegree/add')));

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

      /* check privacy */
      if ($id <= 0) {
         $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }
      $data['query'] = $this->_model->row($id);
      $data['document'] = array(array('id' => $data['query']->id, 'path' => $data['query']->file_attachment));

      if (!$data['query']) {
         $this->session->set_flashdata('error', 'Lỗi không tồn tại !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      /* get name */
      $name = trim($this->input->get('name'));
      if (isset($name) && $name != "")
         $request = '/?name=' . $data['query']->employee;
      else
         $request = '';

      /* data */
      $data['action'] = base_url() . $this->_redirect . '/update' . $request;

      $data['navi'] = array(array('name' => 'Hồ sơ', 'href' => base_url('/hrm/employeeDegree')),
                           array('name' => $data['query']->employee, 'href' => base_url('/hrm/employeeDegree/'.$data['query']->id)));

      /* load view */
      $data['main_content'] = $this->_view . "edit";
      $this->load->vars($data);
      $this->load->view($this->template);
   }
   
   public function insert() {
      // Load 
      $this->session->set_flashdata('error_em_up', '');
      $this->load->model('hrm/EmployeeModel', 'employee');

      $name = $this->input->post('fullname');
      $name = trim(str_replace('-', '', $name));
      $_POST['input']['employee'] = $name;
      $_POST['input']['department_id'] = (int) $this->input->post('department_id');
      $_POST['input']['employee_id'] = (int) $this->input->post('employ_id');
      $_POST['input']['created'] = time();

      // Upload file attachment
      $this->load->library('UploadManager');
      
      if ($_FILES['img']['tmp_name'] != '') {
         $fileName = '';
         if (is_array($_FILES['img']['name'])) {
				$doc = array();
				for ($i=0; $i<count($_FILES['img']['name']); $i++) {
					$abc = $this->uploadmanager->uploadImages('img', $i);
					$fileName = trim($abc['origin']);
				}
			}
      } else {
         $this->session->set_flashdata('error_em_up', ' Bạn chưa chọn file.');
         redirect(base_url() . 'hrm/employeeDegree/add');
      }
      if ($fileName) {
         $_POST['input']['file_attachment'] = $fileName;
      }

      if ($this->db->insert($this->_table, $_POST['input'])) {
         $this->session->set_flashdata('success', 'Bạn đã thêm mới thành công !');
      } else {
         $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác !');
      }
      redirect(base_url() . 'hrm/employeeDegree', 'refresh');
   }

   public function update() {
      $file = array();
      $id = (int) $this->input->post('id');
      if ($id <= 0) {
         $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác !');
         redirect(base_url() . $this->_redirect, 'refresh');
      }

      $name = trim($this->input->get('name'));
      if (isset($name) && $name != "")
         $request = '/?name=' . $name;
      else
         $request = '';

      /* load library */
      $this->load->library('UploadManager');
      if ($_FILES['img']['tmp_name'] != '') {
         $fileName = '';
         if (is_array($_FILES['img']['name'])) {
				for ($i=0; $i<count($_FILES['img']['name']); $i++) {
					$abc = $this->uploadmanager->uploadImages('img', $i);
					$fileName = trim($abc['origin']);
				}
			}
      }
      
      if ($fileName) {
         $_POST['input']['file_attachment'] = $fileName;
         
         // Delete old file
         $rec = $this->employeedegree->row($id);
         if ($rec->file_attachment) delete_file($rec->file_attachment);
      }

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

   public function deletemulti() {
      if ($this->input->is_ajax_request()) {
         $ids = $_POST['ids'];
         $this->db->where_in('id', $ids);
         $this->db->delete($this->_table);
      }
   }

}