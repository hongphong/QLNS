<?php
class Search extends MX_Controller
{
	private $template  = "hrm/template";
	private $_redirect = 'hrm/employee';
	private $_view	   = "employee/";
	private $_table    = "mc_employee";
	private $_uid;
	private $_model;
	
	function __construct(){
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."hrm/employee",'refresh');
		}
		$this->load->helper('city_helper');
		$this->load->model('EmployeeModel', 'employee');
		$this->_model = $this->employee;
	}
	
	public function data(){
		$data['activeEmployee'] = TRUE;
		return $data;
	}

	function index(){
		/* load data */
		$data			   = $this->data();
		
		/* load library */
		$this->load->library('ValidateQuery');
		
		$messages 	= array();
		$error_code = 0;
		$qr         = $this->input->post('qr');
		
		$tmp = ValidateQuery::validate($qr);
		
		if (is_array($tmp) && count($tmp) > 0)
			$error_code = $error_code | 1;
			
		$messages = array_merge($messages, $tmp);
		
		if(count($messages) == 0)
			echo $qr;
		else
			echo 'error';
			
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
}