<?php
class Hrm extends MX_Controller {
	private $template = "iso/template";
	private $_view = "index/";
	private $_uid;
	
	function __construct() {
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."hrm/company",'refresh');
		}
	}
	
	public function index() {
		redirect(base_url().'hrm/employee');
	}
	
}







