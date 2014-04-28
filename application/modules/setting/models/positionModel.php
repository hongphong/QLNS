<?php 
class PositionModel extends CI_Model{
	protected $_name = 'mc_position';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($limit,$start,$typeorder) {
		$this->db->select(array('mc_position.name', 'mc_position.id', 'mc_position.department_id', 'mc_department.name as department_name', 'mc_company.name as company_name'));	
		$this->db->join('mc_department', 'mc_department.id = mc_position.department_id');
		$this->db->join('mc_company', 'mc_company.id = mc_position.company_id');
		$this->db->limit($limit, $start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_position_by_department($id) {
		$query = $this->db->query("SELECT * FROM $this->_name c WHERE c.department_id = ".$id);
		$data  = $query->result();
		$query->free_result();
		return $data;	
	}
	
	function count_all($where) {
		if($where) $this->db->where($where);
		$this->db->from($this->_name);
		return $this->db->count_all_results();	
	}
	
	function row($id) {
		$query = $this->db->query("SELECT * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}








