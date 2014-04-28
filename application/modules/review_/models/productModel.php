<?php 
class ProductModel extends CI_Model{
	protected $_name = 'tbl_product';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($limit,$start,$typeorder)
	{
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_where($where)
	{
		$this->db->where($where);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_where_in($where)
	{
		$this->db->where_in('id', $where);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function get_where_in_id($where)
	{
		$this->db->select(array('id'));
		$this->db->where_in('id', $where);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		
		$array = array();
		foreach($data as $row){
			$array[] = $row->id;	
		}
		return $array;
	}
	
	function get_where_in_gid($where)
	{
		$this->db->select(array('gid'));
		$this->db->where_in('id', $where);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->_name);
		$data = $query->result();
		$query->free_result();
		
		$array = array();
		foreach($data as $row){
			$array[] = $row->gid;	
		}
		return $array;
	}
	
	function getAllProduct(){
		$query = $this->db->query("select * FROM $this->_name c");
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