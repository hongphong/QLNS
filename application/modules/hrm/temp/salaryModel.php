<?php

class SalaryModel extends CI_Model {

    private $_tblWorkTime = 'sal_time_work';

    function __construct() {
        parent::__construct();
    }

    function get_time_work($month, $year, $department=0) {
        $data = array();
        if ($department == 0) {
            $query = "SELECT * FROM $this->_tblWorkTime WHERE month = $month AND year = $year";
        } else {
            $query = "	SELECT t1.*
						FROM $this->_tblWorkTime t1
						LEFT JOIN mc_employee t2 ON(t1.uid = t2.uid)
						WHERE t1.month = $month AND t1.year = $year AND t2.department_id = $department";
        }

        $db = $this->db->query($query);
        $numRows = $db->num_rows();
        if ($numRows > 0) {
            foreach ($db->result('array') as $row) {
                $data[$row['uid']] = $row;
            }
        } else {
            return false;
        }
        return $data;
    }

    function get_time_work_by_em_id($id) {
        $arrReturn = array();
        $query = "SELECT * FROM $this->_tblWorkTime WHERE uid = " . $id;
        $db = $this->db->query($query);
        $arr =  $db->result('array');
        if($arr){
            foreach($arr as $key=>$value){
                $arrReturn[$value['month']] =  $value;
            }
        }
        return $arrReturn;
    }
    function get_time_work_by_em_id_month_year($id,$month,$year) {
        $arrReturn = array();
        $query = "SELECT * FROM $this->_tblWorkTime WHERE uid = " . $id . " AND month = " . $month . " AND year = " . $year;;
        $db = $this->db->query($query);
        $arr =  $db->result('array');
        if($arr){
            foreach($arr as $key=>$value){
                $arrReturn[$value['month']] =  $value;
            }
        }
        return $arrReturn;
    }
    function get_base_salaries($month, $year, $department=0) {
        $data = array();
        if ($department > 0) {
            $query = "	SELECT t1.*,t2.department_id 
						FROM sal_base t1
						STRAIGHT_JOIN mc_employee t2 ON(t1.uid = t2.id)
						WHERE t1.month = $month AND t1.year = $year AND t2.department_id = $department";
        } else {
            $query = "SELECT * FROM sal_base WHERE month = $month AND year = $year";
        }
        $db = $this->db->query($query);
        $numRows = $db->num_rows();
        if ($numRows > 0) {
            foreach ($db->result('array') as $row) {
                $data[$row['uid']] = $row;
            }
        } else {
            return false;
        }
        return $data;
    }

    function get_costs($month, $year, $department=0) {
        $data = array();
        if ($department > 0) {
            $query = "	SELECT t1.* 
						FROM sal_cost t1
						LEFT JOIN mc_employee t2 ON(t1.uid = t2.uid)
						WHERE t1.month = $month AND t1.year = $year AND t2.department_id = $department";
        } else {
            $query = "SELECT * FROM sal_cost WHERE month = $month AND year = $year";
        }

        $db = $this->db->query($query);
        $numRows = $db->num_rows();
        if ($numRows > 0) {
            foreach ($db->result('array') as $row) {
                $data[$row['uid']][] = $row;
            }
        } else {
            return false;
        }
        return $data;
    }

    function get_base_salary($uid, $month, $year) {
        $query = "SELECT * FROM sal_base WHERE uid = $uid AND month = $month AND year = $year LIMIT 1";
        $db = $this->db->query($query);
        return $db->row();
    }

    function insert_work_time($record) {
        $last_id = $this->db->insert($this->_tblWorkTime, $record);
        return $this->db->insert_id();
    }

    function inserts_base($record) {
        $this->db->insert_batch('sal_base', $record);
    }

    function inserts_cost($record) {
        $this->db->insert_batch('sal_cost', $record);
    }

    function get_cost($uid, $month, $year) {
        $query = "SELECT * FROM sal_cost WHERE uid = $uid AND month = $month AND year = $year";
        $db = $this->db->query($query);
        return $db->result('array');
    }

    function empty_cost($uid, $month, $year) {
        $query = "DELETE FROM sal_cost WHERE uid = $uid AND month = $month AND year = $year";
        $db = $this->db->query($query);
    }

    function empty_salary_base($uid, $month, $year) {
        $query = "DELETE FROM sal_base WHERE uid = $uid AND month = $month AND year = $year";
        $db = $this->db->query($query);
    }

    function empty_salary_time_work($uid, $month, $year) {
        $query = "DELETE FROM sal_time_work WHERE uid = $uid AND month = $month AND year = $year";
        $db = $this->db->query($query);
    }

}

