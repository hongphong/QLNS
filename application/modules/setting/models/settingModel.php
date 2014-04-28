<?php
class ProcessModel extends CI_Model {
	private $_table = 'iso_process';
	
	function __construct() {
    	parent::__construct();
	}
	
	function insert($record) {
		$last_id = $this->db->insert($this->_table, $record);
		return $last_id;
	}
	
	function insert_phase($record) {
		$last_id = $this->db->insert('iso_process_phase', $record);
		return $last_id;
	}
	
	function insert_step($record) {
		$last_id = $this->db->insert('iso_process_step', $record);
		return $last_id;
	}
	
	function insert_multi_document($record) {
		$this->db->insert_batch('iso_document', $record);
	}
	
	function update_step($record, $column, $value) {
		$this->db->where($column, $value);
		$rel = $this->db->update('iso_process_step', $record);
		return $rel;
	}
	
	function update_phase($record, $column, $value) {
		$this->db->where($column, $value);
		$rel = $this->db->update('iso_process_phase', $record);
		return $rel;
	}
	
	function update($record, $column, $value) {
		$this->db->where($column, $value);
		$rel = $this->db->update($this->_table, $record);
		return $rel;
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
	
	function count_all($where) {
		if($where) $this->db->where($where);
		$this->db->from($this->_table);
		return $this->db->count_all_results();	
	}
	
	function get_phase($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM iso_process_phase';
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
	
	function get_step($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM iso_process_step';
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
	
	function get_process($select='*', $where='', $limit='', $order='') {
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
}






