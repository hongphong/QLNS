<?php
class PermissionModel extends CI_Model {
	
	private $_tbl = 'perm_user';
	private $_tblEmployee = 'mc_employee';
	private $_tblGroup = 'perm_user_group';
	private $_tblPermission = 'perm_user_in';
	private $_tblUserPermission = 'perm_user_real';
	
	function __construct() {
		parent::__construct();
	}
	
	function get($where, $limit, $start, $typeorder) {
		if($where) $this->db->where($where);
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_tbl);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function count_all($where) {
		if($where) $this->db->where($where);
		$this->db->from($this->_tbl);
		return $this->db->count_all_results();
	}
	
	function get_group_pg($where, $limit, $start, $typeorder) {
		if($where) $this->db->where($where);
		$this->db->limit($limit,$start);
		$this->db->order_by('id', $typeorder);
		$query = $this->db->get($this->_tblGroup);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
	
	function count_all_group($where) {
		if($where) $this->db->where($where);
		$this->db->from($this->_tblGroup);
		return $this->db->count_all_results();
	}
	
	function get_group($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM '. $this->_tblGroup;
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
			foreach ($db->result('array') as $row) {
				$data[$row['id']] = $row;
			}
		} else {
			return false;
		}
		return $data;
	}
	
	function get_group_perm($groupId) {
		if ($groupId > 0) {
			$data = array();
			$sql = "SELECT t1.view, t1.add, t1.edit, t1.delete, t1.module_id FROM $this->_tblPermission t1 WHERE t1.group_id = $groupId";
			$db = $this->db->query($sql);
			$numrow = $db->num_rows();
			if ($numrow > 0) {
				foreach ($db->result('array') as $row) {
					$data[$row['module_id']] = $row;
				}
			}
			return $data;
		}
		return false;
	}
	
	function get_user_perm($userId) {
		if ($userId > 0) {
			$data = array();
			$sql = "SELECT t1.view, t1.add, t1.edit, t1.delete, t1.module_id FROM $this->_tblUserPermission t1 WHERE t1.uid = $userId";
			$db = $this->db->query($sql);
			$numrow = $db->num_rows();
			if ($numrow > 0) {
				foreach ($db->result('array') as $row) {
					$data[$row['module_id']] = $row;
				}
			}
			return $data;
		}
		return false;
	}
	
	function get_employee($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM '. $this->_tblEmployee;
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
			foreach ($db->result('array') as $row) {
				$data[$row['id']] = $row;
			}
		} else {
			return false;
		}
		return $data;
	}
	
	function gett($table='', $select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM '. $table;
		if ($where != '') $query .= ' WHERE '. $where;
		if ($order != '') $query .= ' ORDER BY '. $order;
		if ($limit != '') $query .= ' LIMIT '. $limit;
		$db = $this->db->query($query);
		$numRows = $db->num_rows();
		if ($numRows > 0) {
			foreach ($db->result('array') as $row) {
				$data[] = $row;
			}
		} else {
			return false;
		}
		return $data;
	}
   
   /**
    * PermissionModel::getAllFunction() - NQH
    * get all function for permission
    * @return void
    */
   function getAllFunction($module_id = 0, $controller_id = 0) {
      $db_select  =  $this->db->query("SELECT *
                                       FROM sys_modules
                                       WHERE 1" . ($module_id > 0 ? " AND id = $module_id" : "") . "
                                       ORDER BY name");
      $module  =  $db_select->result_array();
      $data    =  array();
      foreach ($module as $k => $m) {
         $data[$m['id']]   =  array('info' => array(), 'child' => array());
         $db_select  =  $this->db->query("SELECT *
                                          FROM sys_controllers
                                          WHERE con_module_id = " . intval($m['id']) . 
                                          ($controller_id > 0 ? " AND con_id = $controller_id" : ""));
         $controller =  $db_select->result_array();
         $c_child =  array();
         $total_function   =  0;
         foreach ($controller as $k_2 => $c) {
            $c_child[$c['con_id']]  =  array('info' => array(), 'child' => array());
            $db_select  =  $this->db->query("SELECT *
                                             FROM sys_functions
                                             WHERE fun_controller_id = " . intval($c['con_id']) . "
                                             ORDER BY fun_id");
            $function   =  $db_select->result_array();
            $f_child    =  array();
            foreach ($function as $k_3 => $f) {
               $f_child[$f['fun_id']]  =  $f;
               $total_function++;
            }
            
            $c['total_function']  =  count($f_child);
            //if ($c['total_function'] <= 0) $c['total_function']  =  1;
            
            $c_child[$c['con_id']]['info']   =  $c;
            $c_child[$c['con_id']]['child']  =  $f_child;
         }
         
         $m['total_controller']  =  count($c_child);
         $m['total_function']    =  $total_function;
         //if ($m['total_controller'] <= 0) $m['total_controller']  =  1;
         
         $data[$m['id']]['info']    =  $m;
         $data[$m['id']]['child']   =  $c_child;
      }
      return $data;
   }
   
   /**
    * PermissionModel::countAllFunction() - NQH
    * count all function for permission
    * @param mixed $where
    * @return
    */
   function countAllFunction($where) {
		
      if(!empty($where)) {
		 foreach ($where as $w) {
		    foreach ($w as $k => $v) $this->db->where($k, $v);
       }
		}
		$this->db->from('sys_functions');
      $this->db->join('sys_controllers', 'fun_controller_id = con_id', 'straight');
      $this->db->join('sys_modules', 'con_module_id = id', 'straight');
      
		return $this->db->count_all_results();
	}
   
   /**
    * PermissionModel::getGroupPermission()
    * 
    * @param mixed $group_id
    * @return
    */
   function getGroupPermission($group_id) {
      $db_select  =  $this->db->query("SELECT grpe_function_id
                                       FROM sys_group_permission
                                       WHERE grpe_group_id = " . intval($group_id));
      $result  = $db_select->result_array();
      $data =  array();
      foreach ($result as $k => $row) $data[]   =  $row['grpe_function_id'];
      return $data;
   }
   
   /**
    * PermissionModel::getUserPermission()
    * 
    * @param mixed $uID
    * @return
    */
   function getUserPermission($uID) {
      $db_select  =  $this->db->query("SELECT uspe_function_id
                                       FROM sys_user_permission
                                       WHERE uspe_user_id = " . intval($uID));
      $result  = $db_select->result_array();
      $data =  array();
      foreach ($result as $k => $row) $data[]   =  $row['uspe_function_id'];
      return $data;
   }
   
   /**
    * PermissionModel::getFunction()
    * 
    * @param mixed $fID
    * @return
    */
   function getFunction($fID) {
      $db_check   =  $this->db->query("SELECT *
                                       FROM sys_functions
                                       STRAIGHT_JOIN sys_controllers ON(fun_controller_id = con_id)
                                       STRAIGHT_JOIN sys_modules ON(con_module_id = id)
                                       WHERE fun_id = $fID
                                       LIMIT 1");
      return $db_check->row();
   }
   
   /**
    * Permission::getCurrentFunction()
    * 
    * @param mixed $mCon
    * @return void
    */
   function getCurrentFunction($mCon) {
      $db_select  =  $this->db->query("SELECT fun_name
                                       FROM sys_functions
                                       WHERE fun_controller_id = " . intval($mCon));
      $result  =  $db_select->result_array();
      $list =  '';
      foreach ($result as $name) {
         $list .=  $name['fun_name'] . ', ';
      }
      return $list;
   }
   
   /**
    * PermissionModel::getAllModule()
    * 
    * @param string $field
    * @param string $where
    * @return
    */
   function getAllModule($field = "id,name", $where = '') {
      $db_select     =  $this->db->query("SELECT $field
                                          FROM sys_modules
                                          WHERE status = 1 $where");
      return $db_select->result_array();
   }
   
   /**
    * PermissionModel::getController() - NQH
    * 
    * @param integer $module
    * @param string $field
    * @return
    */
   function getController($module = 0, $field = 'con_id, con_name') {
      $db_sl   =  $this->db->query("SELECT $field
                                    FROM sys_controllers
                                    WHERE 1 AND con_module_id = $module");
      return $db_sl->result_array();
   }
   
}

