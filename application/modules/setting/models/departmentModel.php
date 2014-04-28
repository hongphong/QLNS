<?php 
class DepartmentModel extends CI_Model{
	protected $_name = 'mc_department';
	
    function __construct() {
    	parent::__construct();
	}
	
	function get_depart($select='*', $where='', $limit='', $order='') {
		$data = array();
		$query = 'SELECT '. $select . ' FROM '. $this->_name;
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
	
	function getByIdCompany($id){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.status FROM $this->_name c WHERE c.company_id = ".$id);
		$data  = $query->result();
		$secho = '';
		foreach($data as $cat){	
			if($cat->parent_id==0){
				$secho.='<li id="'.$cat->id.'" level="1"><span>[+] </span> <a href="javascript:;" id="'.$cat->id.'">'.$cat->name.'</a></li>';
				foreach($data as $sub){
					if($sub->parent_id==$cat->id){
						$secho.='<li class="hidden parent li-lv1-'.$cat->id.'" id="'.$sub->id.'" level="2"><a href="javascript:;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>[+] </span> '.$sub->name.'</a></li>';
						foreach($data as $subx){
							if($subx->parent_id==$sub->id){
								$secho.='<li class="hidden parent li-lv2-'.$sub->id.'" id="'.$subx->id.'"><a href="javascript:;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;'.$subx->name.'</a></li>';	
							}
						}
					}
				}	
			}
		}
		
		$query->free_result();
		return $secho;			
	}
	
	function get(){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.status FROM $this->_name c");
		$data  = $query->result();
		
		$secho = '';
		foreach($data as $cat){	
			if($cat->parent_id==0){
				$secho.='<option value="'.$cat->id.'" id="'.$cat->parent_id.'">'.$cat->name.'</option>';
				foreach($data as $sub){
					if($sub->parent_id==$cat->id){
						$secho.='<option value="'.$sub->id.'" id="'.$sub->parent_id.'">&nbsp;&nbsp;&raquo;&nbsp;&nbsp;'.$cat->name.' > '.$sub->name.'</option>';
						foreach($data as $subx){
							if($subx->parent_id==$sub->id){
								$secho.='<option value="'.$subx->id.'" id="'.$subx->parent_id.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;&nbsp;'.$cat->name.' > '.$sub->name.' > '.$subx->name.'</option>';
							}
						}
					}
				}	
			}
		}
		
		$query->free_result();
		return $secho;			
	}
	
	function get_main_category(){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.sid, c.status FROM $this->_name c WHERE c.parent_id = 0");
		$data  = $query->result();
		
		$query->free_result();
		return $data;			
	}
	
	function get_depart_by_company($id){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.status FROM $this->_name c WHERE c.company_id = ".$id);
		$data  = $query->result();
		
		$secho = '';
		foreach($data as $cat){	
			if($cat->parent_id==0){
				$secho.='<option value="'.$cat->id.'">'.$cat->name.'</option>';
				foreach($data as $sub){
					if($sub->parent_id==$cat->id){
						$secho.='<option value="'.$sub->id.'">&nbsp;&nbsp;&raquo;&nbsp;&nbsp;'.$cat->name.' > '.$sub->name.'</option>';
						foreach($data as $subx){
							if($subx->parent_id==$sub->id){
								$secho.='<option value="'.$subx->id.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;&nbsp;'.$cat->name.' > '.$sub->name.' > '.$subx->name.'</option>';
							}
						}
					}
				}	
			}
		}
		
		$query->free_result();
		return $secho;	
	}
	
	function get_all_category(){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.sid, c.status FROM $this->_name c");
		$data  = $query->result();
		
		$query->free_result();
		return $data;			
	}
	
	function get_main_category_menu(){
		$query = $this->db->query("select c.name, c.id, c.parent_id, c.sid FROM $this->_name c WHERE c.parent_id = 0 OR c.sid = 0");
		$data  = $query->result();
		
		$secho = '';
		foreach($data as $cat){	
			if($cat->parent_id==0){
				$secho.='<option value="'.$cat->id.'" id="'.$cat->parent_id.'">'.$cat->name.'</option>';
				foreach($data as $sub){
					if($sub->parent_id==$cat->id){
						$secho.='<option value="'.$sub->id.'" id="'.$sub->parent_id.'">&nbsp;&nbsp;&raquo;&nbsp;&nbsp;'.$cat->name.' > '.$sub->name.'</option>';
					}
				}	
			}
		}
		
		$query->free_result();
		return $secho;			
	}
	
	function row($id){
		$query = $this->db->query("select * FROM $this->_name c WHERE c.id = ".$id);
		return $query->row();
	}
}