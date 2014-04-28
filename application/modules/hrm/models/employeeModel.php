<?php

class EmployeeModel extends CI_Model {

   protected $_name = 'mc_employee';

   function __construct() {
      parent::__construct();
   }

   function getAll() {
      $this->db->select(array('id', 'fullname', 'status', 'company_id', 'department_id', 'salary_per_hour', 'uid'));
      $this->db->order_by('id', 'DESC');
      $this->db->where('status', 1);
      $query = $this->db->get($this->_name);
      $data = $query->result('array');
      $query->free_result();
      return $data;
   }

   function getById($strId) {
      $sql = "SELECT id,fullname FROM $this->_name WHERE id IN($strId)";
      
      $query = $this->db->query($sql);
      $data = $query->result('array');
      $query->free_result();
      return $data;
   }

   function getByUid($strId) {
      $sql = "SELECT id,uid,fullname FROM $this->_name WHERE uid IN($strId)";
      $query = $this->db->query($sql);
      $data = $query->result('array');
      $query->free_result();
      return $data;
   }

   function get_employee($department=0) {
      $this->db->select(array('id', 'fullname', 'status', 'company_id', 'department_id', 'salary_per_hour', 'uid'));
      $this->db->order_by('id', 'DESC');
      if ($department > 0)
         $this->db->where('department_id', $department);
      $this->db->where('status', 1);
      $query = $this->db->get($this->_name);
      $data = $query->result('array');
      $query->free_result();
      return $data;
   }

   function get_employ_with_kpi($department=0, $month, $year) {
      $sql = "SELECT t1.id, t1.fullname
				FROM mc_employee t1
				WHERE 1 ";
      if ($department > 0)
         $sql .= ' AND t1.department_id = ' . $department;
      $result = $this->db->query($sql);
      return $result->result('array');
   }

   function get_kpi($department=0, $month, $year) {
      $data = array();
      $sql = "SELECT * FROM tbl_review WHERE month = $month AND year = $year";
      if ($department > 0)
         $sql .= " AND department_id = $department";
      $result = $this->db->query($sql);
      $numRows = $result->num_rows();
      if ($numRows > 0) {
         foreach ($result->result('array') as $item) {
            $data[$item['employee_id']] = $item;
         }
      }
      return $data;
   }

   function get_employ_by_depart() {
   	$data = array();
      $this->db->select(array('id', 'fullname', 'status', 'department_id', 'uid', 'position_id'));
      $this->db->order_by('id', 'DESC');
      $this->db->where('status', 1);
      $query = $this->db->get($this->_name);
      foreach ($query->result('array') as $row) {
         $data[$row['department_id']][] = $row;
      }
      $query->free_result();
      return $data;
   }

   function get_employ_work_time($month, $year) {
      $query = '	SELECT t1.id,t1.fullname,t1.uid,t1.department_id,t2.`1.0`,t2.`1.5`,t2.`2.0` 
					FROM mc_employee t1 
					LEFT JOIN sal_time_work t2 ON(t1.uid = t2.uid) 
					WHERE t1.status = 1 AND t2.month = ' . $month . ' AND t2.year = ' . $year;
      $db = $this->db->query($query);
      $data = $db->result('array');
      return $data;
   }

   function get_employ_info($uid) {
      if ($uid > 0) {
         $query = '	SELECT t1.fullname,t1.id,t1.uid,t1.company_id,t1.position_id,t1.department_id,t2.name AS depart_name,t3.name AS position_name,t4.name AS company_name
						FROM mc_employee t1
						LEFT JOIN mc_company t4 ON(t1.company_id = t4.id)
						LEFT JOIN mc_department t2 ON(t1.department_id = t2.id)
						LEFT JOIN mc_position t3 ON(t1.position_id = t3.id)
						WHERE uid = ' . $uid . '
						LIMIT 1';
         $db = $this->db->query($query);
         return (array) $db->row();
      }
   }

   function get_all_position() {
      $arrReturn = array();
      $sql = 'SELECT * FROM mc_position';
      $query = $this->db->query($sql);
      $data = $query->result_array();
      if ($data) {
         foreach ($data as $key => $value) {
            $arrReturn[$value['id']] = $value;
         }
      }
      return $arrReturn;
   }

   function get($limit, $start, $typeorder) {
      $this->db->select(array('id', 'fullname', 'status', 'uid', 'position_id'));
      $this->db->limit($limit, $start);
      $this->db->order_by('id', $typeorder);
      $query = $this->db->get($this->_name);
      $data = $query->result();
      $query->free_result();
      return $data;
   }

   function get_by_position($position_id) {
      $this->db->select(array('id'));
      $this->db->where(array('position_id' => $position_id));
      $query = $this->db->get($this->_name);
      $data = $query->result();
      $query->free_result();
      return $data;
   }

   function get_by_joblevel($position, $department) {
      $sql = 'SELECT * FROM mc_employee WHERE position_id = ' . $position . ' AND department_id = ' . $department;
      $db = $this->db->query($sql);
      $data = $db->result('array');
      $db->free_result();
      return $data;
   }

   function count_all($where) {
      if ($where)
         $this->db->where($where);
      $this->db->from($this->_name);
      return $this->db->count_all_results();
   }

   function count_like($where) {
      if ($where)
         $this->db->where($where);
      $this->db->from($this->_name);
      return $this->db->count_all_results();
   }

   function row($id) {
      $sql = "SELECT c.*, d.name, d.password
				FROM $this->_name c 
				LEFT JOIN perm_user d ON(c.uid = d.id)
				WHERE c.id = " . $id;

      $query = $this->db->query($sql);
      return $query->row();
   }

   function get_by_name($name) {
      $this->db->where(array('name' => $name));
      $query = $this->db->get($this->_name);
      return $query->row();
   }

   function get_one($employeeId) {
      if ($employeeId > 0) {
         $this->db->where('id', $employeeId);
         $result = $this->db->get($this->_name);
         return $result->row_array();
      }
   }

   public function get_nkl_by_month($month) {
      $sql = 'SELECT * FROM mc_dayoff WHERE month = ' . $month;
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   public function get_nkl_by_id($id) {
      $sql = 'SELECT * FROM mc_dayoff WHERE employ_id = ' . $id;
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   public function get_nkl_by_id_month_year($id, $month, $year) {
      $sql = 'SELECT * FROM mc_dayoff WHERE employ_id = ' . $id . ' AND month = ' . $month . ' AND year = ' . $year;
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   public function get_employee_id_by_uid($uid) {
      $sql = 'SELECT * FROM mc_employee WHERE uid = ' . $uid;
      $query = $this->db->query($sql);
      $arr = $query->result_array();
      return $arr[0]['id'];
   }

   public function get_employee_info_by_uid($uid) {
      $sql = 'SELECT * FROM mc_employee WHERE uid = ' . $uid;
      $query = $this->db->query($sql);
      $arr = $query->result_array();
      return ($arr[0]);
   }

   public function get_employee_info_by_id($id) {
      $sql = 'SELECT * FROM mc_employee WHERE id = ' . $id;
      $query = $this->db->query($sql);
      $arr = $query->result_array();
      return ($arr);
   }

   public function get_kpi_by_id($emId, $month = 0, $year = 0) {
      if ($year == 0) {
         $year = date('Y', time());
      }
      if ($month != 0) {
         $sql = 'SELECT * FROM tbl_model_month WHERE employee_id = ' . $emId . ' AND year = ' . $year . ' AND month = ' . $month;
      } else {

         $sql = 'SELECT * FROM tbl_model_month WHERE employee_id = ' . $emId . ' AND year = ' . $year;
      }
      $query = $this->db->query($sql);
      $arr = $query->result_array();
      return ($arr);
   }

   public function get_employee_degree($em_id) {
      $where = "employee_id = $em_id";
      if ($where)
         $this->db->where($where);
      $query = $this->db->get('mc_employee_degree');
      $data = $query->result();
      $query->free_result();
      return $data;
   }

}

