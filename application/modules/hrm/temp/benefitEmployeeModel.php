<?php 
class BenefitEmployeeModel extends CI_Model{
	protected $_name = 'mc_benefit_employee';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($where){
		if($where) $this->db->where($where);	
		$this->db->select(array('mc_benefit_employee.*', 'mc_benefit.name'));
		$this->db->join('mc_benefit', 'mc_benefit.id = mc_benefit_employee.benefit_id');
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;		
	}
	
	function update($record, $column, $value) {
		$this->db->where($column, $value);
		$rel = $this->db->update($this->_name, $record);
		return $rel;
	}
	
	function count_by_benefit_employee($benefit_id, $employee_id){
		$this->db->where(array('employee_id' => $employee_id, 'benefit_id' => $benefit_id));
		$this->db->from($this->_name);
		return $this->db->count_all_results();
	}
	
	function get_benefit_employee($employ_id) {
		$sql = 'SELECT t1.*,t2.name,t2.per_unit
				FROM mc_benefit_employee t1
				LEFT JOIN mc_benefit t2 ON(t1.benefit_id = t2.id)
				WHERE t1.employee_id = '.$employ_id;
		$db = $this->db->query($sql);
		return $db->result('array');
	}
	
	function get_benefit_position($position_id, $department_id) {
		$sql = 'SELECT t1.*,t2.name
				FROM mc_benefit_limitation t1
				LEFT JOIN mc_benefit t2 ON(t1.benefit_id = t2.id)
				WHERE t1.position_id = '. $position_id .' AND t1.department_id = '. $department_id;
		
		$db = $this->db->query($sql);
		return $db->result('array');
	}
	
	function row($id){
		$this->db->where(array('mc_benefit_employee.id' => $id));
		$this->db->select(array('mc_benefit_employee.*', 'mc_benefit.name'));
		$this->db->join('mc_benefit', 'mc_benefit.id = mc_benefit_employee.benefit_id');
		$query = $this->db->get($this->_name);
		return $query->row();
	}
        public function get_all_benefit(){
            $sql = 'SELECT * FROM mc_benefit';
            $query = $this->db->query($sql);
            return $query->result_array();
        }
}













