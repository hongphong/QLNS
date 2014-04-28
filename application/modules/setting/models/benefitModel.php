<?php 
class BenefitModel extends CI_Model{
	protected $_name = 'mc_benefit';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($limit, $start, $typeorder) {
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function getAllBenefit() {
		$query = $this->db->query("SELECT * FROM $this->_name c");
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_benefit($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM '. $this->_name;
		if ($where != '') $query .= ' WHERE '. $where;
		if ($order != '') $query .= ' ORDER BY '. $order;
		if ($limit != '') $query .= ' LIMIT '. $limit;
		$db = $this->db->query($query);
		$numRows = $db->num_rows();
		if ($numRows > 0) {
			if ($numRows == 1) {
				return $db->result('array');
			} else {
				foreach ($db->result('array') as $row) {
					$data[] = $row;
				}
			}
		} else return false;
		return $data;
	}
	
	function count_all($where)
	{	
		if($where) $this->db->where($where);
		$this->db->from($this->_name);
		return $this->db->count_all_results();	
	}
	
	function row($id){
		$query = $this->db->query("select * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}