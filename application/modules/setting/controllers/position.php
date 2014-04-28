<?php
class Position extends MX_Controller
{
	private $template = "iso/template";
	private $_redirect = 'setting/position';
	private $_view = "position/";
	private $_table = "mc_position";
	private $_model;
	private $_uid;
	
	function __construct(){
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."iso/setting/benefit",'refresh');
		}
		$this->load->helper('base_helper');
		$this->load->model('setting/PositionModel', 'position');
		$this->_model = $this->position;
	}
	
	public function data(){
		$data['activePositon'] = TRUE;
		return $data;
	}
	
	public function index(){
		/* load data */
		$data			   = $this->data();
		
		// Pagination
		$config['base_url']=base_url().$this->_redirect.'/index';
		$config['total_rows']=$this->_model->count_all('');
		$config['per_page']=PER_PAGE_HRM; 
		$config['uri_segment']=4;
		$config['full_tag_open']='<div class="pagination">';
		$config['full_tag_close']='</div>';
		$this->pagination->initialize($config); 
		$data['pagination']=$this->pagination->create_links();
		
		$data['query']     = $this->_model->get($config['per_page'], (int)$this->uri->segment(4), 'DESC');
		$data['actionDel'] = base_url().$this->_redirect.'/delete';
		
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
	
	public function add(){
		/* load data */
		$data			   	  = $this->data();
		
		/* load model */
		$this->load->model('setting/CompanyModel', 'company');
	
		/* data */
		$data['company']	  = $this->company->get();
		$data['action']		  = base_url().$this->_redirect.'/insert';
		
		/* load view */
		$data['main_content'] = $this->_view."add";
		$this->load->vars($data);
		$this->load->view($this->template);		
	}
	
	public function edit(){
		/* load data */
		$data = $this->data();
		$id   = (int)$this->uri->segment(4);
		
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
		
		/* load model */
		$this->load->model('setting/DepartmentModel', 'department');
		$this->load->model('setting/CompanyModel', 'company');
		
		/* data */
		$data['action']		  = base_url().$this->_redirect.'/update';
		$data['parent']		  = $this->company->get();
		$data['depart']	      = $this->department->get();
		
		/* load view */
		$data['main_content'] = $this->_view."edit";
		$this->load->vars($data);
		$this->load->view($this->template);			
	}
	
	public function insert(){
		$this->db->insert($this->_table, $_POST['input']);
		$newid = (int)$this->db->insert_id();
		if ($newid > 0) {
			$this->session->set_flashdata('success','Bạn đã thêm mới thành công !');
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');
		}
		redirect( base_url().$this->_redirect, 'refresh');
	}
	
	public function update(){
		$id = (int)$this->input->post('id');
		
		if($id <= 0){
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
			redirect( base_url().$this->_redirect, 'refresh');	
		}
		
		if($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']) )){
			$this->session->set_flashdata('success','Bạn đã cập nhật thành công !');
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác!');
		}	
		redirect( base_url().$this->_redirect, 'refresh');
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
	
	public function location(){
		if($this->input->is_ajax_request()){
			$cid = (int)$this->input->post('id');
			if ($cid <= 0) exit();
			
			/* load model */
			$this->load->model('setting/DepartmentModel', 'depart');
			
			/* data */
			$data = $this->depart->get_depart_by_company($cid);
			if ($data) {
				echo $data;
			} else {
				echo '';
			}
		} else {
			echo '';
		}
		exit();
	}
	
}










