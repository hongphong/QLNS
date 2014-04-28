<?php

class ReportLogModel extends CI_Model {

    private $_table = 'log_activity';

    function get($select='*', $where='', $limit='', $order='') {
        $data = array();
        $query = 'SELECT ' . $select . ' FROM ' . $this->_table;
        if ($where != '') {
            $query .= ' WHERE ' . $where;
        }
        if ($order != '') {
            $query .= ' ORDER BY ' . $order;
        }
        if ($limit != '') {
            $query .= ' LIMIT ' . $limit;
        }
        $db = $this->db->query($query);
        $numRows = $db->num_rows();
        if ($numRows > 0) {
            if ($numRows == 1) {
                return $db->result('array');
            } else {
                foreach ($db->result('array') as $row) {
                    $data[$row['day']][] = $row;
                }
            }
        } else {
            return false;
        }
        return $data;
    }

    function get_dayoff($month, $year) {
        $data = array();
        $sql = "SELECT * FROM mc_dayoff WHERE month = $month AND year = $year";
        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {

            foreach ($db->result('array') as $rec) {

                $data['rec-' . $rec['employ_id'] . '-' . $rec['day'] . '-' . $rec['month'] . '-' . $rec['year']] = $rec['reason'];
                if ($rec['reason'] == 1 || $rec['reason'] == 2) {
                    if (!isset($data['total-ncl-' . $rec['employ_id']])) {
                        $data['total-ncl-' . $rec['employ_id']] = 1;
                    } else {
                        $data['total-ncl-' . $rec['employ_id']]++;
                    }
                } else if ($rec['reason'] == 3) {
                    if (!isset($data['total-nkl-' . $rec['employ_id']])) {
                        $data['total-nkl-' . $rec['employ_id']] = 1;
                    } else {
                        $data['total-nkl-' . $rec['employ_id']]++;
                    }
                }
            }
        }
        return $data;
    }

    function get_dayoff_year($year) {
        $sql = "SELECT * FROM mc_dayoff WHERE year = $year";
        $db = $this->db->query($sql);
        return $db->result_array();
    }

    function put($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

}

