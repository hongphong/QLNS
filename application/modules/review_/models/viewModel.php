<?php 
class ViewModel extends CI_Model{
	protected $_name = 'tbl_review';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($limit,$start,$typeorder,$where)
	{
		//if($where) $this->db->where($where);
		if(isset($where['uid']))
			$this->db->where('tbl_review.uid', $where['uid']);
		if(isset($where['month']))
			$this->db->where('tbl_review.month', $where['month']);
		if(isset($where['year']))
			$this->db->where('tbl_review.year', $where['year']);
		$this->db->select(array('tbl_review.*', 'mc_employee.fullname'));
		$this->db->join('mc_employee', 'mc_employee.id = tbl_review.uid', 'left');
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function count_all($where)
	{	
		if($where) $this->db->where($where);
		$this->db->from($this->_name);
		return $this->db->count_all_results();	
	}
}