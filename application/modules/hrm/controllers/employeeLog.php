<?php
class EmployeeLog extends MX_Controller
{
	private $template  = "iso/template";
	private $_redirect = 'hrm/employeeLog';
	private $_view	   = "employeeLog/";
	private $_table    = "mc_employee_log";
	private $_uid;
	private $_model;
	
	function __construct(){
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."hrm/employeeLog",'refresh');
		}
		
		$this->load->model('hrm/EmployeeLogModel', 'employeeLog');
		$this->_model = $this->employeeLog;
	}
	
	public function data(){
		$data['activeEmployeeLog'] = TRUE;
		$data['listUrl']			  = $this->_redirect;
		$data['addUrl']				  = $this->_redirect.'/add';
		return $data;
	}
	
	public function index(){		
		/* load data */
		$data			   = $this->data();
		
		// LEFT BOX
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');
		
		$data['depart'] = $this->department->get_depart('id,name','');
		$data['employ'] = $this->employ->get_employ_by_depart();
		
		/* get name */
		$name 			   = trim($this->input->get('name'));
		if(isset($name) && $name != ""){
			$where = array('employee'=>$name);
			$data['listUrl']			= $this->_redirect.'/?name='.$name;
			$data['addUrl']				= $this->_redirect.'/add/?name='.$name;
		} else {
			$where = '';	
		}
		
		// Pagination
		$config['base_url']=base_url().$this->_redirect.'/index';
		$config['total_rows']=$this->_model->count_all($where);
		$config['per_page']=PER_PAGE_HRM; 
		$config['uri_segment']=4;
		$config['full_tag_open']='<div class="pagination">';
		$config['full_tag_close']='</div>';
		$this->pagination->initialize($config); 
		$data['pagination']=$this->pagination->create_links();
		
		$data['query']     = $this->_model->get($where, $config['per_page'], (int)$this->uri->segment(4), 'DESC');
		$data['actionDel'] = base_url().$this->_redirect.'/delete';
		
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
	
	public function add(){
		/* load data */
		$data			   	  = $this->data();
		
		// LEFT BOX
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');
		
		$data['depart'] = $this->department->get_depart('id,name','');
		$data['employ'] = $this->employ->get_employ_by_depart();
		
		/* get name */
		$name 			   = trim($this->input->get('name'));
		if(isset($name) && $name != ""){
			$where = array('employee'=>$name);
			$data['listUrl']			= $this->_redirect.'/?name='.$name;
			$data['addUrl']				= $this->_redirect.'/add/?name='.$name;
			$request = '/?name='.$name;
		} else {
			$where = '';
			$request = '';
		}
		
		/* data */
		$data['action']		  = base_url().$this->_redirect.'/insert'.$request;
		$data['name']		  = $name;
		
		/* load view */
		$data['main_content'] = $this->_view."add";
		$this->load->vars($data);
		$this->load->view($this->template);		
	}
	
	public function edit(){
		/* load data */
		$data = $this->data();
		$id   = (int)$this->uri->segment(4);
		
		// LEFT BOX
		$this->load->model('hrm/EmployeeModel', 'employ');
		$this->load->model('setting/DepartmentModel', 'department');
		
		$data['depart'] = $this->department->get_depart('id,name','');
		$data['employ'] = $this->employ->get_employ_by_depart();
		
		/* check privacy */
		if($id <= 0){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect( base_url().$this->_redirect, 'refresh');
		}
		$data['query']		  = $this->_model->row($id);
		
		if(!$data['query']){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect( base_url().$this->_redirect, 'refresh');
		}
		
		/* get name */
		$name 			   = trim($this->input->get('name'));
		if(isset($name) && $name != "")
			$request = '/?name='.$data['query']->employee;	
		else
			$request = '';
		
		/* data */
		$data['action']		  = base_url().$this->_redirect.'/update'.$request;
		
		/* load view */
		$data['main_content'] = $this->_view."edit";
		$this->load->vars($data);
		$this->load->view($this->template);			
	}
	
	public function insert(){
		/* load model */
		$this->load->model('hrm/EmployeeModel', 'employee');
		
		/* check month */
		if($_POST['input']['year'] <= 0){
			$this->session->set_flashdata('error','Có lỗi bạn phải nhập năm đánh giá !');	
			redirect( base_url().$this->_redirect, 'refresh');		
		}
		
		/* check employee */
		$name = $this->input->post('employee');
		$row  = $this->employee->get_by_name($name);
		
		if(!$row){
			$this->session->set_flashdata('error','Không tồn tại nhân viên này !');	
			redirect( base_url().$this->_redirect, 'refresh');			
		} else {
			$_POST['input']['employee']    = $row->name;
			$_POST['input']['employee_id'] = $row->id;
			$_POST['input']['created']	   = time();
			$_POST['input']['user_id']		   = $this->uid;
		}
		
		/* get name */
		$uname = trim($this->input->get('name'));
		if(isset($uname) && $uname != "")
			$request = '/?name='.$uname;	
		else
			$request = '';
			
		for($i = 0; $i < count($_POST['comment']); $i++){
			if($_POST['comment'][$i] != '' && $_POST['comment'][$i] != '<br>'){
				$count_s = $this->_model->count_by_month_year($_POST['month'][$i], $_POST['input']['year']);
				if($count_s == 0){
					$_POST['input']['comment'] = $_POST['comment'][$i];
					$_POST['input']['month']   = $_POST['month'][$i];
					$this->db->insert($this->_table, $_POST['input']);
				}
			}
		}
			
		$redirect = base_url().$this->_redirect.$request;
		$this->session->set_flashdata('success','Bạn đã thêm mới thành công !');	
		redirect( $redirect, 'refresh');
	}
	
	public function update(){
		$id = (int)$this->input->post('id');
		
		if($id <= 0){
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
			redirect( base_url().$this->_redirect, 'refresh');	
		}
		
		$name 			   = trim($this->input->get('name'));
		if(isset($name) && $name != "")
			$request = '/?name='.$name;	
		else
			$request = '';
			
		if($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']) )){
			$this->session->set_flashdata('success','Bạn đã cập nhật thành công !');		
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác!');	
		}	
		redirect( base_url().$this->_redirect.$request, 'refresh');		
	}
	
	public function delete(){
		if($this->input->is_ajax_request()){
			$id    = (int)$_POST['id'];
			$this->db->delete($this->_table, array('id' => $id)); 
		}
	}
	
	public function deletemulti(){
		if($this->input->is_ajax_request()){
			$ids = $_POST['ids'];
			$this->db->where_in('id', $ids);
			$this->db->delete($this->_table); 
		}
	}
}