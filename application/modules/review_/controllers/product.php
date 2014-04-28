<?php
class Product extends MX_Controller
{
	private $template = "review/template";
	private $_view	  = "product/";
	private $_redirect = 'review/product';
	private $_table    = "tbl_product";
	private $_uid;
	private $_model;
	
	function __construct(){
        parent::__construct();
		$this->_uid = $this->session->userdata('uid');
		if (!isset($this->_uid) OR $this->_uid<= 0){
			redirect(base_url().'?ref='.base_url()."review/product",'refresh');
		}

		$this->load->model('ProductModel', 'product');
		$this->_model = $this->product;
	}
	
	public function data(){
		$data['activeProduct'] = TRUE;
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
		$this->load->model('review/UnitModel', 'unit');
		$this->load->model('review/GroupModel', 'group');
	
		/* data */
		$data['group']	  = $this->group->getAllGroup($this->_uid);
		$data['unit']	  = $this->unit->getAllUnit();
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
		$this->load->model('review/UnitModel', 'unit');
		$this->load->model('review/GroupModel', 'group');
		
		/* data */
		$data['action']	= base_url().$this->_redirect.'/update';
		$data['group']	= $this->group->getAllGroup($this->_uid);
		$data['unit']	= $this->unit->getAllUnit();
		
		/* load view */
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
	
	public function listProduct(){
		if($this->input->is_ajax_request()){
			$id    = (int)$_POST['id'];
			$gid   = $_POST['gid'];
			$data['group_id'] = $gid;
			$data['product'] = $this->_model->get_where(array('gid' => $id));
			$this->load->vars($data);
			$this->load->view('review/product/list');	
		}
	}
	
	public function listProductByModelId(){
		if($this->input->is_ajax_request()){
			$id    = (int)$this->input->post('id');
			$mid   = (int)$this->input->post('model_id');
			$gid   = $this->input->post('gid');
			
			$this->load->model('review/ModelsModel', 'model');
			$pr_model = $this->model->getModels($mid);
			$pr1 = "";
			$pr2 = "";
			foreach($pr_model as $row){
				if($row->status == 1)
					$pr1 = $row->dataid;
				else
					$pr2 = $row->dataid;
			}
			
			$data['pr1'] = json_decode($pr1);
			$data['pr2'] = json_decode($pr2);
			
			$data['group_id'] = $gid;
			$data['product'] = $this->_model->get_where(array('gid' => $id));
			$this->load->vars($data);
			$this->load->view('review/product/list-update');	
		}
	}
}