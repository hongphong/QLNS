<?php
class Department extends MX_Controller
{
	private $template  = "iso/template";
	private $_view	   = "department/";
	private $_redirect = '/setting/department';
	private $_table    = "mc_department";
	private $_uid;
	
	function __construct(){
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."setting/department",'refresh');
		}
		$this->load->helper('city_helper');
		$this->load->model('DepartmentModel', 'department');
	}
	
	public function data(){
		$data['activeDepartment'] = TRUE;
		return $data;
	}
	
	public function index(){
		$data			   = $this->data();
		$data['query']     = $this->department->get_main_category();
		$data['actionDel'] = base_url().'setting/department/delete';
		
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
	
	public function add(){
		$data			   	  = $this->data();
		
		/* load model module setting/company */
		$this->load->model('setting/CompanyModel', 'company');
		
		$data['action']		  = base_url().'setting/department/insert';
		$data['parent']	      = $this->company->get();
		$data['depart']		  = $this->department->get_main_category_menu();
		
		$data['main_content'] = $this->_view."add";
		$this->load->vars($data);
		$this->load->view($this->template);		
	}
	
	public function edit(){
		$data = $this->data();
		$id   = (int)$this->uri->segment(4);
		if($id <= 0){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect($this->_redirect, 'refresh');
		}
		$data['query']		  = $this->department->row($id);
		if(!$data['query']){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect($this->_redirect, 'refresh');
		}
		
		/* load model module setting/company */
		$this->load->model('setting/CompanyModel', 'company');
		
		$data['depart']		  = $this->department->get_main_category_menu();
		$data['parent']	      = $this->company->get_parent_company();
		$data['action']		  = base_url().'setting/department/update/';
		$data['main_content'] = $this->_view."edit";
		$this->load->vars($data);
		$this->load->view($this->template);			
	}
	
	public function insert(){
		if($this->db->insert($this->_table, $_POST['input'])){
			$this->session->set_flashdata('success','Bạn đã thêm mới thành công !');		
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
		}	
		redirect( $this->_redirect, 'refresh');
	}
	
	public function update(){
		$id = (int)$this->input->post('id');
		
		if($id <= 0){
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
			redirect( $this->_redirect, 'refresh');	
		}
			
		if($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']) )){
			$this->session->set_flashdata('success','Bạn đã cập nhật thành công !');		
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác!');	
		}	
		redirect( $this->_redirect, 'refresh');		
	}
	
	public function delete(){
		if($this->input->is_ajax_request()){
			$id = (int)$_POST['id'];
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