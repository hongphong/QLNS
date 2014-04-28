<?php
class Project extends MX_Controller {
	
	private $_uid = 0;
	private $_template = 'iso/template';
	
	function __construct() {
		parent::__construct();
		
		// Load library
		$this->load->model('CronModel', 'cron');
		$this->load->helper('base_helper');
		$this->load->library('session');
		
		$uid = $this->session->userdata('uid');
		if (intval($uid) > 0) {
			$this->_uid = $uid;
		} else {
			redirect($this->_home, 'refresh');
		}
	}
	
	public function index() {
		
		$data['myTask'] = $this->cron->get('*', 'uid = '.$this->_uid.'AND iso_type = "project"');
		$data['right_content'] = 'task_list_right';
		$data['main_content'] = 'task_list';
		
		$this->load->vars($data);
		$this->load->views($this->_template);
	}
	
}





