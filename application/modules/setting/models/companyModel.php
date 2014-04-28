<?php 
class CompanyModel extends CI_Model{
	protected $_name = 'mc_company';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get(){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.status FROM $this->_name c");
		$data  = $query->result();
		$query->free_result();
		return $data;			
	}
	
	function get_parent_company(){
		$query = $this->db->query("select c.name, c.id, c.parent_id FROM $this->_name c WHERE c.parent_id = 0");
		$data  = $query->result();
		$query->free_result();
		return $data;			
	}
	
	function row($id){
		$query = $this->db->query("select * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}