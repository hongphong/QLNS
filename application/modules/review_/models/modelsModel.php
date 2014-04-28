<?php 
class ModelsModel extends CI_Model{
	protected $_name = 'tbl_models';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($limit,$start,$typeorder)
	{
		$this->db->where('mid', 0);
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function getAllModel(){
		$query = $this->db->query("select * FROM $this->_name c WHERE `status` = 0 ORDER BY `id`");
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function getModels($id){
		$query = $this->db->query("select * FROM $this->_name c WHERE `mid` = ".$id." ORDER BY `id`");
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
	
	function row($id){
		$query = $this->db->query("select * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}