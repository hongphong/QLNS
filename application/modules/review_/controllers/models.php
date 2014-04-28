<?php
class Models extends MX_Controller
{
	private $template = "review/template";
	private $_view	  = "models/";
	private $_redirect = 'review/models';
	private $_table    = "tbl_models";
	private $_uid;
	private $_model;

	function __construct(){
        parent::__construct();
		$this->_uid = $this->session->userdata('uid');
		if (!isset($this->_uid) OR $this->_uid <= 0){
			redirect(base_url().'?ref='.base_url()."review/models",'refresh');
		}

		$this->load->model('ModelsModel', 'models');
		$this->_model = $this->models;
	}

	public function data(){
		$data['activeModels'] = TRUE;
		return $data;
	}

	public function index(){
		/* load data */
		$data			   = $this->data();
		
		// Pagination
		$config['base_url']=base_url().$this->_redirect.'/index';
		$config['total_rows']=$this->_model->count_all(array('mid' => 0));
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
		$this->load->model('review/GroupModel', 'group');

		/* data */
		$data['group']	  = $this->group->getAllGroup();
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
		$this->load->model('review/GroupModel', 'group');

		/* data */
		$data['group']	  = $this->group->getAllGroup();
		$data['action']		  = base_url().$this->_redirect.'/update';
		$data['listgroup_bymodel'] = $this->_model->getModels($id);
		
		/* load view */
		$data['main_content'] = $this->_view."edit";
		$this->load->vars($data);
		$this->load->view($this->template);			
	}

	public function insert(){
		$_POST['input']['name'] = $this->input->post('model_name');
		$_POST['input']['created'] = time();
		if($this->db->insert($this->_table, $_POST['input'])){
			
			$gid = $this->db->insert_id();
			if($gid > 0){
				$this->load->model('review/ProductModel', 'product');
				
				$pid1 = $this->input->post('gr1');
				$pid2 = $this->input->post('gr2');
				$data1 = array();
				$data2 = array();
				$datagid1 = array();
				$datagid2 = array();
				
				if(count($pid1) > 0){
					$data1 = $this->product->get_where_in($pid1);
					$dataid1 = $this->product->get_where_in_id($pid1);
					$datagid1 = $this->product->get_where_in_gid($pid1);
				}
				if(count($pid2) > 0){
					$data2 = $this->product->get_where_in($pid2);
					$dataid2 = $this->product->get_where_in_id($pid2);
					$datagid2 = $this->product->get_where_in_gid($pid2);
				}
				$_POST['pr1']['name'] = 'Nhóm sản phẩm chính';
				$_POST['pr1']['mid'] = $gid;
				$_POST['pr1']['data'] = json_encode($data1);
				$_POST['pr1']['dataid'] = json_encode($dataid1);
				$_POST['pr1']['datagid'] = json_encode($datagid1);
				$_POST['pr1']['created'] = time();
				$_POST['pr1']['status'] = 1;
				$this->db->insert($this->_table, $_POST['pr1']);
				
				$_POST['pr2']['name'] = 'Nhóm sản phẩm phụ';
				$_POST['pr2']['mid'] = $gid;
				$_POST['pr2']['data'] = json_encode($data2);
				$_POST['pr2']['dataid'] = json_encode($dataid2);
				$_POST['pr2']['datagid'] = json_encode($datagid2);
				$_POST['pr2']['created'] = time();
				$_POST['pr2']['status'] = 2;
				$this->db->insert($this->_table, $_POST['pr2']);
				
				$_POST['pr3']['datagid'] = json_encode(array('gr1' => $datagid1, 'gr2' => $datagid2));
				$this->db->update($this->_table, $_POST['pr3'], array('id' => $gid));
			}			
			$this->session->set_flashdata('success','Bạn đã thêm mới thành công !');		
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
		}	
		redirect( base_url().$this->_redirect, 'refresh');
	}

	public function update(){
		$id = (int)$this->input->post('id');
		$_POST['input']['name'] = $this->input->post('model_name');
		
		if($id <= 0){
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');
			redirect( base_url().$this->_redirect, 'refresh');
		}

		if($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']) )){
			
			$this->load->model('review/ProductModel', 'product');
				
			$pid1 = $this->input->post('gr1');
			$pid2 = $this->input->post('gr2');
			$data1 = array();
			$data2 = array();
			
			if(count($pid1) > 0){
				$data1 = $this->product->get_where_in($pid1);
				$dataid1 = $this->product->get_where_in_id($pid1);
			}
			if(count($pid2) > 0){
				$data2 = $this->product->get_where_in($pid2);
				$dataid2 = $this->product->get_where_in_id($pid2);
			}
			
			$_POST['pr1']['data'] = json_encode($data1);
			$_POST['pr1']['dataid'] = json_encode($dataid1);
			$this->db->update($this->_table, $_POST['pr1'], array('id' => $_POST['id_pr1']));
		
			$_POST['pr2']['data'] = json_encode($data2);
			$_POST['pr2']['dataid'] = json_encode($dataid2);
			$this->db->update($this->_table, $_POST['pr2'], array('id' => $_POST['id_pr2']));
			
			
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
			$this->db->delete($this->_table, array('mid' => $id));
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