<?php 
class TaskModel extends CI_Model {
	
	private $_table = 'task_warning';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get($select='*', $where='', $limit='', $order='') {
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
	
	function get_task_by_user($uid) {
		$data = array();
		if ($uid > 0) {
			$query = '	SELECT t1.id,t1.uid,t1.iso_type,t1.iso_id,t1.iso_name,t1.function,t1.duration,t1.time_update 
						FROM '. $this->_table .' t1 
						WHERE uid = '. $uid;
			
			$db = $this->db->query($query);
			if ($db->num_rows() > 0) {
				foreach ($db->result('array') as $row) {
					$data[$row['function']][] = $row;
				}
			}
			$db->free_result();
		}
		return $data;
	}
}




