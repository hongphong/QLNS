<?php
class Notification extends MX_Controller{
	
	private $_uid = 0;
	private $_template = "iso/template";
	
	function __construct(){
      parent::__construct();
		// Load helper and library
		$this->load->helper('base_helper');
	}
	
	public function index() {
		redirect(base_url() . 'customer/company');
	}
   
   function deny() {
      $data = array();
		
		// View
		$data['main_content'] = 'deny/index';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
   }
}










