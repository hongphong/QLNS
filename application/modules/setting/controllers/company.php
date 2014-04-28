<?php
class Company extends MX_Controller
{
	private $template  = "iso/template";
	private $_view	   = "company/";
	private $_redirect = '/setting/company';
	private $_table    = "mc_company";
	private $_uid;
	
	function __construct(){
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."setting/company",'refresh');
		}
		$this->load->helper('city_helper');
		$this->load->model('CompanyModel', 'company');
	}
	
	public function data(){
		$data['activeCompany'] = TRUE;
		return $data;
	}
	
	public function index(){
		$data = $this->data();
		$data['query'] = $this->company->get_parent_company();
		$data['actionDel'] = base_url().'setting/company/delete';
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
	
	public function add(){
		$data			   	  = $this->data();
		$data['action']		  = base_url().'setting/company/insert';
		$data['parent']	      = $this->company->get_parent_company();
		
		$data['main_content'] = $this->_view."add";
		$this->load->vars($data);
		$this->load->view($this->template);		
	}
	
	public function edit(){
		$data = $this->data();
		$id   = (int)$this->uri->segment(4);
		if($id <= 0){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect( $this->_redirect, 'refresh');
		}
      
		$data['query']		  = $this->company->row($id);
		if(!$data['query']){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect( $this->_redirect, 'refresh');
		}
		
		$data['parent']	      = $this->company->get_parent_company();
		$data['action']		  = base_url().'setting/company/update';
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
      
      // Upload logo
      $this->load->library('UploadManager');
      if (is_array($_FILES['file_attachment']['name'])) {
         for ($i=0; $i<count($_FILES['file_attachment']['name']); $i++) {
         	$upload = $this->uploadmanager->uploadImages('file_attachment', $i);
            if (trim($upload['origin']) != '') {
               $_POST['input']['logo'] = trim($upload['origin']);
               break;
            }
         }
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
			$cid 	  = (int)$this->input->post('id');
			$district = districts();
			
			if($district[$cid]){
				foreach($district[$cid] as $index => $row){
					echo '<option value="'.$index.'">'.$row.'</option>';	
				}
			} else {
				echo '';	
			}
		} else {
			echo '';	
		}
		exit();
	}
}


