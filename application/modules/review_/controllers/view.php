<?php
class View extends MX_Controller
{
	private $template = "review/template";
	private $_view	  = "view/";
	private $_redirect = 'review/view';
	private $_table    = "tbl_review";
	private $_uid;
	private $_model;

	function __construct(){
        parent::__construct();
		$this->_uid = $this->session->userdata('uid');
		if (!isset($this->_uid) OR $this->_uid <= 0){
			redirect(base_url().'?ref='.base_url()."review/view",'refresh');
		}
		
		$this->load->model('ViewModel', 'models');
		$this->_model = $this->models;
	}

	public function data(){
		$data['activeView'] = TRUE;
		return $data;
	}

	public function index(){
		/* load data */
		$data			   = $this->data();
		$this->load->model('review/UnitModel', 'unit');
		$data['unit']	  = $this->unit->getAllUnit();
		
		$this->load->model('hrm/EmployeeModel', 'employee');
		$data['employee'] = $this->employee->getAll();

		$uid = (int)$this->input->post('user-uid');
		$month = (int)$this->input->post('month');
		$year = (int)$this->input->post('year');
		
		$where = array();
		if($uid > 0)
			$where['uid'] = $uid;
		
		if($month > 0)
			$where['month'] = $month;
			
		if($year > 0)
			$where['year'] = $year;
			
		$data['uid'] = $uid;
		$data['month'] = $month;
		$data['year'] = $year;
			
		// Pagination
		$config['base_url']=base_url().$this->_redirect.'/index';
		$config['total_rows']=$this->_model->count_all($where);
		$config['per_page']=PER_PAGE_HRM; 
		$config['uri_segment']=4;
		$config['full_tag_open']='<div class="pagination">';
		$config['full_tag_close']='</div>';
		$this->pagination->initialize($config); 
		$data['pagination']=$this->pagination->create_links();
		
		$data['query']     = $this->_model->get($config['per_page'], (int)$this->uri->segment(4), 'DESC', $where);
		$data['actionDel'] = base_url().$this->_redirect.'/delete';
		
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
}