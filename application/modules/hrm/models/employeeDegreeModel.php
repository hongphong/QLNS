<?php 
class EmployeeDegreeModel extends CI_Model{
	protected $_name = 'mc_employee_degree';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($where, $limit, $start, $typeorder) {
		if($where) $this->db->where($where);	
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function count_all($where) {	
		if($where) $this->db->where($where);
		$this->db->from($this->_name);
		return $this->db->count_all_results();	
	}
	
	function row($id){
		$query = $this->db->query("select * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}