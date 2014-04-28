<?php
class Setting extends MX_Controller{
	
	private $_home = 'home';
	private $_template = 'iso/template';
	private $_uid = 0;
	
	function __construct() {
        parent::__construct();
        
        // Load libraries & Helpers
        $this->load->helper('base_helper');
        $this->load->library('perm');
        $this->load->library('iso');
	}
	
	public function index() {
		redirect(base_url() . 'setting/permission');
	}
	
}


















