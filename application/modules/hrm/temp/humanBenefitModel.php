<?php 
class HumanBenefitModel extends CI_Model{
	protected $_name = 'mc_benefit_limitation ';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($where, $limit,$start,$typeorder)
	{
		if($where) $this->db->where($where);	
		$this->db->select(array('mc_benefit_limitation.*', 'mc_benefit.name', 'mc_department.name as department', 'mc_position.name as position_name'));
		$this->db->join('mc_benefit', 'mc_benefit.id = mc_benefit_limitation.benefit_id');
		$this->db->join('mc_position', 'mc_position.id = mc_benefit_limitation.position_id');
		$this->db->join('mc_department', 'mc_department.id = mc_benefit_limitation.department_id');
		$this->db->limit($limit,$start);
		$this->db->order_by('department_id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_benefit_by_position($position_id, $department_id = 0) {
		$sql = "SELECT c.* FROM $this->_name c WHERE c.position_id = ".$position_id;
		if ($department_id > 0) $sql .= ' AND c.department_id = '.$department_id;
		$query = $this->db->query($sql);
		$data  = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_benefit_id_by_position($department, $position) {
		$sql = "SELECT benefit_id FROM mc_benefit_limitation WHERE department_id = $department AND position_id = $position";
		$db = $this->db->query($sql);
		$data = $db->result('array');
		if (!empty($data)) return $data;
		return false;
	}
	
	function count_benefit_human_by_benefit_id($benefit_id, $position, $department) {
		$this->db->where(array('benefit_id' => $benefit_id, 'position_id' => $position_id));
		$this->db->from($this->_name);
		return $this->db->count_all_results();
	}
	
	function count_all($where)
	{	
		if($where) $this->db->where($where);
		$this->db->from($this->_name);
		return $this->db->count_all_results();	
	}
	
	function row($id){
		$query = $this->db->query("SELECT * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}