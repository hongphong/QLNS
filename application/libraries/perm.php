<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perm {
	
	protected $_ci;
	protected $_uid;
	protected $_perm;
	protected $_listPerm = array(1=>'Employ', 2=>'');
	
	function __construct() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->load->library('session');
		$uid = $this->_ci->session->userdata('uid');
		if (intval($uid) > 0) {
			$this->_uid = $uid;
		} else {
			redirect('home', 'refresh');
		}
	}
	
	function get_perm($uid) {
		if (intval($uid) > 0) {
			$db = $this->_ci->db->query('SELECT perm FROM mc_employee WHERE id = '.$uid.' AND status = 1');
			return $db->row()->perm;
		}
		return 0;
	}
	
	function classify() {
		
	}
	
	function check_perm($functionName) {
		$uid = $this->_uid;
	}
	
	function get_perm_group() {
		$uid = $this->_uid;
		$db = $this->_ci->db->query("SELECT t2.type,t2.name FROM perm_user t1 LEFT JOIN perm_user_group t2 ON(t1.group_id = t2.id) WHERE t1.id = $uid LIMIT 1");
		if ($db->num_rows() > 0) {
			return $db->row_array();
		}
		return false;
	}
}


















