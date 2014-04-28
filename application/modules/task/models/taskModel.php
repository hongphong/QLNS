<?php
class ProjectModel extends CI_Model {
	private $_table = 'iso_project';
	
	function __construct() {
		parent::__construct();
	}
	
	function get($limit, $start, $typeorder, $where='') {
		$this->db->select(array('*'));
		$this->db->limit($limit,$start);
		$this->db->where($where);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_table);
		$data = $query->result('array');
		$query->free_result();
		return $data;
	}
	
	function delete($condition) {
		$db = $this->db->delete($this->_table, $condition);
	}
	
	function insert($record) {
		$this->db->insert($this->_table, $record);
		return $this->db->insert_id();
	}
	
	function update($record, $column, $value) {
		$this->db->where($column, $value);
		$rel = $this->db->update($this->_table, $record);
		return $rel;
	}
	
	function count_all($where) {
		if($where) $this->db->where($where);
		$this->db->from($this->_table);
		return $this->db->count_all_results();
	}
	
	function get_project($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM '. $this->_table;
		if ($where != '') {
			$query .= ' WHERE '. $where;
		}
		if ($order != '') {
			$query .= ' ORDER BY '. $order;
		}
		if ($limit != '') {
			$query .= ' LIMIT '. $limit;
		}
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
		} else {
			return false;
		}
		
		return $data;
	}
	
	function is_PM($pid, $uid) {
		if (intval($pid) > 0 && intval($uid) > 0) {
			$is = $this->get_project('id', "id = $pid AND per_lead = $uid OR per_create = $uid", '1');
			if ($is) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
	
	function is_creator($pid, $uid) {
		if (intval($pid) > 0 && intval($uid) > 0) {
			$is = $this->get_project('id', "id = $pid AND per_create = $uid", '1');
			if ($is) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
}




