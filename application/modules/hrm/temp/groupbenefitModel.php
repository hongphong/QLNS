<?php 
class GroupbenefitModel extends CI_Model{
	protected $_name = 'mc_benefit_group ';
	protected $_nameDetail = 'mc_benefit_group_detail ';
	
    function __construct() {
    	parent::__construct();
	}
	
	function count_all($where) {
		if($where) $this->db->where($where);
		$this->db->from($this->_name);
		return $this->db->count_all_results();	
	}
	
	function get($where, $limit, $start, $typeorder='DESC') {
		if($where) $this->db->where($where);
		$this->db->select(array('mc_benefit_group.*', 'mc_department.name as department', 'mc_position.name as position'));
		$this->db->join('mc_department', 'mc_department.id = mc_benefit_group.department_id');
		$this->db->join('mc_position', 'mc_position.id = mc_benefit_group.position_id');
		$this->db->limit($limit, $start);
		$this->db->order_by('mc_benefit_group.id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function row($id){
		$query = $this->db->query("SELECT * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
	
	function get_group_benefit_detail($groupId) {
		$sql = "SELECT c.* FROM $this->_nameDetail c WHERE c.group_id = ".$groupId." ORDER BY id ASC";
		$query = $this->db->query($sql);
		$data = $query->result('array');
		$query->free_result();
		return $data;
	}
	
	function get_all() {
		$this->db->select('*');
		$query = $this->db->get($this->_name);
		$data = $query->result('array');
		$query->free_result();
		return $data;
	}
	
	/*********************************** executed **********************************/
	
	function get_benefit_by_position($position_id, $department_id = 0) {
		$sql = "SELECT c.* FROM $this->_name c WHERE c.position_id = ".$position_id;
		if ($department_id > 0) $sql .= ' AND c.department_id = '.$department_id;
		$query = $this->db->query($sql);
		$data  = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_benefit_id_by_position($department, $position) {
		$sql = "SELECT benefit_id FROM mc_benefit_group WHERE department_id = $department AND position_id = $position";
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
	
}