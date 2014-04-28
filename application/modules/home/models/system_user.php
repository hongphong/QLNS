<?php 
class System_user extends CI_Model {
	
    function __construct() {
    	parent::__construct();
	}
	
	function checkUser($uname, $upass) {
		$sql = "SELECT t1.id,t1.employ_id,t1.name AS uname,e.fullname,t2.type as gtype,t2.name AS gname 
				FROM perm_user t1
				LEFT JOIN perm_user_group t2 ON(t1.group_id = t2.id) 
            LEFT JOIN mc_employee e ON(e.uid = t1.id)
				WHERE t1.status = 1 AND t1.name = '$uname' AND t1.password = '". md5($upass) ."'";
		
		$db = $this->db->query($sql);
		if ($db->num_rows() > 0) {
			$row = $db->row_array();
			$user = array(
			   	'uid' => $row['id'],
				'employ_id' => $row['employ_id'],
			   	'user_name' => $row['uname'],
			   	'fullname' => $row['fullname'],
				'group_type' => $row['gtype'],
				'group_name' => $row['gname']
			);
			$this->session->set_userdata($user);
			return TRUE;
		}
		return FALSE;		
	}
	
	function getUserInfo($uid) {
		$sql = "SELECT * FROM perm_user WHERE id = $uid";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
}




