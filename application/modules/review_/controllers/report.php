<?php
class Report extends MX_Controller
{
	private $template = "review/template";
	private $_view	  = "report/";
	private $_redirect = 'review/report';
	private $_table    = "tbl_review";
	private $_uid;
	private $_model;

	function __construct(){
        parent::__construct();
		$this->_uid = $this->session->userdata('uid');
		if (!isset($this->_uid) OR $this->_uid <= 0){
			redirect(base_url().'?ref='.base_url()."review/report",'refresh');
		}

		$this->load->model('ModelsModel', 'models');
		$this->_model = $this->models;
	}

	public function data(){
		$data['activeReport'] = TRUE;
		return $data;
	}

	public function index(){
		/* load data */
		$data = $this->data();
		
		// Time
		$department = 0;
		$month = 0;
		$year = 0;
		if (isset($_POST['m'])) $month = $_POST['m'];
		if (isset($_POST['y'])) $year = $_POST['y'];
		if (isset($_POST['d'])) $department = $_POST['d'];
		if ($month <= 0) $month = date('m') - 1;
		if ($year <= 0) $year = date('Y');
		$data['department'] = $department;
		$data['month'] = $month;
		$data['year'] = $year;
		
		$this->load->model('hrm/EmployeeModel', 'employee');
		$data['employee'] = $this->employee->get_employee($department);
		dump($data['employee']);
		
		// Pagination
		/* $config['base_url']=base_url().$this->_redirect.'/index';
		$config['total_rows']=$this->_model->count_all(array('mid' => 0));
		$config['per_page']=PER_PAGE_HRM; 
		$config['uri_segment']=4;
		$config['full_tag_open']='<div class="pagination">';
		$config['full_tag_close']='</div>';
		$this->pagination->initialize($config); 
		$data['pagination']=$this->pagination->create_links();
		$data['query'] = $this->_model->get($config['per_page'], (int)$this->uri->segment(4), 'DESC'); */
		
		$data['actionDel'] = base_url().$this->_redirect.'/delete';
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}

	public function rep(){
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
		$this->load->model('review/UnitModel', 'unit');

		/* data */
		$data['unit']	  = $this->unit->getAllUnit();
		$data['group']	  = $this->group->getAllGroup();
		$data['action']		  = base_url().$this->_redirect.'/insert';
		$data['listgroup_bymodel'] = $this->_model->getModels($id);
		
		/* load view */
		$data['main_content'] = $this->_view."report";
		$this->load->vars($data);
		$this->load->view($this->template);			
	}
	
	public function insert(){
		$pr1 = $this->input->post('pr1_name');
		$array1 = array();
		$array1['result'] = $this->input->post('pr1_result_total');
		for($i = 0; $i < count($pr1); $i++){
			$product = new stdClass();
			$product->name = $pr1[$i];
			$product->unit = $_POST['pr1_unit'][$i];
			$product->weight = $_POST['pr1_weight'][$i];
			$product->const = $_POST['pr1_const'][$i];
			$product->result = $_POST['pr1_result'][$i];
			$product->req  = $_POST['pr1_req'][$i];
			
			$array1['data'][] = $product;
		}
		
		$pr2 = $this->input->post('pr2_name');
		$array2 = array();
		$array2['result'] = $this->input->post('pr2_result_total');
		for($i = 0; $i < count($pr2); $i++){
			$product = new stdClass();
			$product->name = $pr2[$i];
			$product->unit = $_POST['pr2_unit'][$i];
			$product->weight = $_POST['pr2_weight'][$i];
			$product->const = $_POST['pr2_const'][$i];
			$product->result = $_POST['pr2_result'][$i];
			$product->req  = $_POST['pr2_req'][$i];
			
			$array2['data'][] = $product;
		}
		
		$_POST['input']['mid'] = $this->input->post('id');
		$_POST['input']['uid'] = $this->_uid;
		$_POST['input']['day'] = date('d');
		$_POST['input']['month'] = date('m');
		$_POST['input']['year'] = date('Y');
		$_POST['input']['review_data_first'] = json_encode($array1);
		$_POST['input']['review_data_second'] = json_encode($array2);
		$_POST['input']['result'] = $this->input->post('pr3_result_total');
	
		if($this->db->insert($this->_table, $_POST['input'])){
			$this->session->set_flashdata('success','Bạn đã thêm mới thành công !');
			
			$this->db->update('tbl_models', array('isReport' => 1), array('id' => $_POST['input']['mid']));
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
		}	
		redirect( base_url().$this->_redirect, 'refresh');
	}
}