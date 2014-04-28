<?php
class Review extends MX_Controller {
	private $template = "review/template";
	private $_view = "index/";
	private $_uid;
	
	function __construct(){
        parent::__construct();
		$this->uid = $this->session->userdata('uid');
		if (!isset($this->uid) OR $this->uid <= 0){
			redirect(base_url().'?ref='.base_url()."review",'refresh');
		}
	}
	
	public function index(){		
		$data['main_content'] = $this->_view."view";
		$this->load->vars($data);
		$this->load->view($this->template);
	}
	
	public function add(){
		
	}
	
	public function update(){
		
	}
	
	public function delete(){
		
	}
}




