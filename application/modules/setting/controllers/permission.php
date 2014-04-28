<?php
class Permission extends MX_Controller {
	
	private $_uid = 0;
	private $_model = '';
	private $_redirect = 'setting/permission';
	private $_template = 'iso/template';
	
	function __construct() {
		parent::__construct();
		$uid = (int)$this->session->userdata('uid');
		if ($uid > 0) {
			$this->_uid = $uid;
		} else {
			redirect(base_url().'home', 'refresh');
		}
		
		// Load helper and library
		$this->load->helper('base_helper');
		$this->load->model('PermissionModel', 'permission');
		$this->_model = $this->permission;
	}
	
	public function index() {
		// Pagination
		$where = array();
		$config['base_url'] = base_url() . $this->_redirect . '/index';
		$config['total_rows'] = $this->_model->count_all($where);
		$config['per_page'] = PER_PAGE_PERMISSION;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		$data['query'] = $this->_model->get($where, $config['per_page'], (int)$this->uri->segment(4), 'DESC');
		$data['total'] = $config['total_rows'];
		
		// Get all group
		$arGroup = $this->_model->get_group();
		if (!empty($arGroup)) {
			if (!empty($data['query'])) {
				if (!is_object($data['query'])) {
					foreach ($data['query'] as $key=>$que) {
						$data['query'][$key]->group_name = '';
						if (isset($arGroup[$que->group_id])) {
							$data['query'][$key]->group_name = $arGroup[$que->group_id]['name'];
						}
					}
				} else {
					if (isset($arGroup[$que->group_id])) $data['query']->group_name = $arGroup[$que->group_id]['name'];
				}
			}
		}
		
		// Get all employee
		$this->load->model('hrm/EmployeeModel', 'employee');
		$arEmployee = $this->_model->get_employee('id,fullname');
		if (!empty($arEmployee)) {
			if (!is_object($data['query'])) {
				foreach ($data['query'] as $key=>$que) {
					$data['query'][$key]->fullname = '';
					if (isset($arEmployee[$que->employ_id])) {
						$data['query'][$key]->fullname = $arEmployee[$que->employ_id]['fullname'];
					}
				}
			} else {
				if (isset($arEmployee[$que->employ_id])) $data['query']->fullname = $arEmployee[$que->employ_id]['fullname'];
			}
		}
		
		// Navigation
		$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
								array('name' => 'Account', 'href' => base_url() . 'setting/permission/index'));
		
		// Main view
		$data['main_content'] = 'permission/perm_list';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}

	public function delete() {
		$id = (int)$this->uri->segment(4);
		if ($id <= 0) redirect(base_url('setting/permisson/'));
		$this->db->where('id', $id);
		$this->db->delete('perm_user');
		redirect('setting/permission');
	}
	
	public function submit() {
		$action = $this->input->post('action');
		switch ($action) {
			case 'insert_group': $this->insert_group(); break;
			case 'update_group': $this->update_group(); break;
			case 'update_perm': $this->update_perm(); break;
			default: redirect($this->_redirect);
		}
	}
	
	public function insert_group() {
		$data['name'] = $this->input->post('name');
		$data['time_create'] = time();
		$data['time_update'] = time();
		if ($data['name'] != '') {
			$this->db->insert('perm_user_group', $data);
			$newid = $this->db->insert_id();
			
         $this->addPermGroup($newid);
         
			redirect(base_url().'setting/permission/group', 'refresh');
			
		} else {
			redirect(base_url().'setting/permission/addgroup', 'refresh');
		}
	}
	
	public function update_group() {
		$groupId = (int)$this->input->post('groupid');
		if ($groupId > 0) {
			$data['name'] = $this->input->post('name');
			$data['time_update'] = time();
			
			if ($data['name'] != '') {
				$this->db->where('id', $groupId);
				$this->db->update('perm_user_group', $data);
				
            $this->addPermGroup($groupId);
            
				redirect(base_url().'setting/permission/group', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Có lỗi xảy ra');
				redirect(base_url().'setting/permission/group/', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'Có lỗi xảy ra');
			redirect(base_url().'setting/permission/group', 'refresh');
		}
	}
	
	public function update_perm() {
		$uid = (int)$this->input->post('uid');
      
		if ($uid > 0) {
		 
			$data['group_id'] = $this->input->post('group');
			$data['last_update'] = time();
			if ($data['group_id'] > 0) {
				$this->db->where('id', $uid);
				$this->db->update('perm_user', $data);
				
            $this->addPermUser($uid);
            
				redirect(base_url().'setting/permission/index', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Có lỗi xảy ra');
				redirect(base_url().'setting/permission/index', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'Có lỗi xảy ra');
			redirect(base_url().'setting/permission/index', 'refresh');
		}
	}
	
	public function group() {
		// Pagination
		$where = array();
		$config['base_url'] = base_url() . $this->_redirect . '/index';
		$config['total_rows'] = $this->_model->count_all_group($where);
		$config['per_page'] = PER_PAGE_PERMISSION;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		$data['query'] = $this->_model->get_group_pg($where, $config['per_page'], (int)$this->uri->segment(4), 'DESC');
		$data['total'] = $config['total_rows'];
		
		// Navigation
		$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
								array('name' => 'Nhóm', 'href' => base_url() . 'setting/permission/group'));
		
		// Main view
		$data['main_content'] = 'permission/group_list';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}
	
	public function addgroup() {
		// Navigation
		$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
								array('name' => 'Nhóm', 'href' => base_url() . 'setting/permission/group'),
								array('name' => 'Thêm nhóm', 'href' => base_url() . 'setting/permission/addgroup'));
		
		// Main view
		$data['main_content'] = 'permission/group_add';
      
		// Get group permission
		$data['groupPerm'] = $this->_model->getAllFunction();
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}
	
	public function editgroup() {
		$groupId = (int)$this->uri->segment(4);
		if ($groupId > 0) {
			
			// Get group info
			$temp = $this->_model->get_group('*', 'id = '.$groupId, '1');
			$data['groupInfo'] = $temp[$groupId];
			
			// Get group permission
			$data['groupPerm'] = $this->_model->getAllFunction();
         
         // Get current permission
         $data['currentPerm'] =  $this->_model->getGroupPermission($groupId);
			
			// Navigation
			$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
									array('name' => 'Nhóm', 'href' => base_url() . 'setting/permission/group'),
									array('name' => $data['groupInfo']['name'], 'href' => base_url() . 'setting/permission/editgroup/'.$data['groupInfo']['id']));
			
			// Main view
			$data['main_content'] = 'permission/group_edit';
			
			$this->load->vars($data);
			$this->load->view($this->_template);
		} else {
			redirect(base_url().'setting/permission/group', 'refresh');
		}
	}
	
	public function editperm() {
		$userId = (int)$this->uri->segment(4);
		if ($userId > 0) {
			// User info
			$temp = $this->_model->gett('perm_user', '*', "id = $userId", '1');
			$data['userInfo'] = $temp[0];
			
			// Get all group
			$data['allGroup'] = $this->_model->gett('perm_user_group', '*');
			
			// Get all permission of user
         $perm_user        =  $this->_model->getUserPermission($userId);
         
         //If user haven't any permission, show all permission of group
         if (count($perm_user) <= 0) $perm_user =  $this->_model->getGroupPermission($temp[0]['group_id']);
         
         $data['userPerm'] = $perm_user;
         
         // Get all funtion
			$data['allPerm'] = $this->_model->getAllFunction();
			
			// Navigation
			$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
									array('name' => 'Account', 'href' => base_url() . 'setting/permission/account'),
									array('name' => $data['userInfo']['name'], 'href' => base_url() . 'setting/permission/editperm/'.$data['userInfo']['id']));
			
			// Main view
			$data['main_content'] = 'permission/perm_edit';
			
			$this->load->vars($data);
			$this->load->view($this->_template);
		} else {
			redirect($this->_redirect, 'refresh');
		}
	}
	
	public function loadperm() {
		if ($this->input->is_ajax_request()) {
			
			$groupId = (int)$this->input->post('group_id');
			if ($groupId > 0) {
				$data = $this->_model->getGroupPermission($groupId);
				
				if (!empty($data)) print implode(',', $data);
			} else {
				redirect($this->_redirect, 'refresh');
			}
		} else {
			redirect($this->_redirect, 'refresh');
		}
	}
   
   /**
    * Permission::module_add() - NQH
    * 
    * @return void
    */
   function module_add() {
      // Navigation
		$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
								array('name' => 'Module', 'href' => base_url() . 'setting/permission/module_list'),
								array('name' => 'Thêm module', 'href' => base_url() . 'setting/permission/module_add'));
      $this->load->library('iso');
		
      $data['module']   =  $this->iso->get_system_modules();
      
		// Main view
		$data['main_content'] = 'permission/module_add';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
   }
   
   /**
    * Permission::module_insert() - NQH
    * 
    * @return void
    */
   function module_insert() {
   	
      $messages   =  array();
      
      $module    =  getValue('current_module', 'int', 'POST');
      //If add new module
      if ($module <= 0) {
         $new_module       =  getValue('new_module', 'str', 'POST', '', 1);
         $new_module_alias =  getValue('new_module_alias', 'str', 'POST', '', 1);
         
         if ($new_module != '' && $new_module_alias != '') {
            $db_exe  =  $this->db->query("INSERT INTO sys_modules (name, alias, href, controller_segment) VALUES
                                          ('$new_module', '$new_module_alias', '$href', $segment)");
            $module =  $this->db->insert_id();
         }
         
         if ($module <= 0) {
            $this->session->set_flashdata('error', 'Không có module nào được chọn hoặc thông tin nhập mới module không đầy đủ. Vui lòng thử lại!');
            redirect(base_url().'setting/permission/module_list', 'refresh');
         }
      }
      
      if ($module > 0) {
         $controller   =  getValue('current_controller', 'int', 'POST');
         //If add new controller
         if ($controller <= 0) {
            $new_controller         =  getValue('new_controller', 'str', 'POST', '', 1);
            $new_controller_alias   =  getValue('new_controller_alias', 'str', 'POST', '', 1);
            $new_controller_show    =  getValue('new_controller_show', 'int', 'POST', '', 1);
            
            if ($new_controller != '' && $new_controller_alias != '') {
               $db_exe  =  $this->db->query("INSERT INTO sys_controllers(con_name, con_alias, con_module_id, con_show)
                                             VALUES('$new_controller', '$new_controller_alias', $module, $new_controller_show)");
               $controller   =  $this->db->insert_id();
            }
            
            if ($controller <= 0) {
               $this->session->set_flashdata('error', 'Không có mục nào được chọn hoặc thông tin nhập Mục mới không đầy đủ. Vui lòng thử lại!');
               redirect(base_url().'setting/permission/module_list', 'refresh');
            }
         }
         //If isset controller select
         if ($controller > 0) {
            $new_function        =  getValue('new_function', 'arr', 'POST', array());
            $new_function_alias  =  getValue('new_function_alias', 'arr', 'POST', array());
            $new_function_show   =  getValue('show', 'arr', 'POST', array());
            
            if (!empty($new_function) && !empty($new_function_alias) && count($new_function) == count($new_function_alias)) {
               foreach ($new_function as $k => $function) {
                  if ($function != '' && isset($new_function_alias[$k]) && $new_function_alias[$k] != '') {
                     $show =  isset($new_function_show[$k]) ? intval($new_function_show[$k]) : 0;
                     $db_exe  =  $this->db->query("INSERT INTO sys_functions(fun_name, fun_alias, fun_controller_id, fun_show)
                                                   VALUES('$function', '$new_function_alias[$k]', $controller, $show)");
                  }  //end if
               }  //end foreach
            }  //end if
         }  //end if
      }  //end if
      
      redirect(base_url().'setting/permission/module_add', 'refresh');
   }
   
   /**
    * Permission::loadController() - NQH
    * 
    * @return void
    */
   function loadController() {
      $str  =  '<option value="0">Chọn mục</option>';
      $module  =  getValue('module', 'int', 'POST', getValue('module'));
      
      $db_select  =  $this->db->query("SELECT *
                                       FROM sys_controllers
                                       WHERE con_module_id = $module
                                       ORDER BY con_name");
      $result  =  $db_select->result_array();
      
      foreach ($result as $k => $v) {
         $str  .= '<option value="' . $v['con_id'] . '">' . $v['con_name'] . '</option>';
      }
      
      echo  $str;
   }
   
   
	/**
	 * Permission::module_list() - NQH
	 * 
	 * @return void
	 */
	public function module_list() {
      
      //If search
      $module        =  getValue('module');
      $controller    =  getValue('controller');
      $arr_where  =  array();
      if ($module > 0) $arr_where[] =  array('id' => $module);
      if ($controller > 0) $arr_where[]   =  array('con_id' => $controller);
		// Pagination
		$where = array();
		$config['base_url'] = base_url() . $this->_redirect . '/module_list/';
		$config['total_rows'] = $this->_model->countAllFunction($arr_where);
		$config['per_page'] = PER_PAGE_PERMISSION;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$data['pagination']      = $this->pagination->create_links();
		$data['allPerm']         = $this->_model->getAllFunction($module, $controller);
      $data['allModule']       = $this->_model->getAllModule();
      $data['allController']   = $this->_model->getController($module);
      $data['module']          = $module;
      $data['controller']      = $controller;
		$data['total'] = $config['total_rows'];
		
		// Navigation
		$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
								array('name' => 'Module', 'href' => base_url() . 'setting/permission/module_list'));
		
		// Main view
		$data['main_content'] = 'permission/module_list';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}
   
   /**
    * Permission::editmodule() - NQH
    * 
    * @return void
    */
   function module_edit() {
      $data = array();
		$id   = (int)$this->uri->segment(4);
      
      $data['url']   =  getValue('url', 'str', 'GET', '', 1);
      
		if($id <= 0){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect( $this->_redirect, 'refresh');
		}
		$data['query']		  = $this->_model->getFunction($id);
		if(!$data['query']){
			$this->session->set_flashdata('error','Lỗi không tồn tại !');
			redirect( $this->_redirect, 'refresh');
		}
      
		// Navigation
		$data['navi'] = array(	array('name' => 'Phân quyền', 'href' => base_url() . 'setting/permission'),
								array('name' => 'Module', 'href' => base_url() . 'setting/permission/group'));
		
		// Main view
		$data['main_content'] = 'permission/module_edit';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
   }
   
   function module_update() {
      $id   = (int)$this->input->post('id');
      $url  =  $this->input->post('url');
      
      if ($url != '') {
         $url =  base64_decode($url);
      } else {
         $url  =  $this->_redirect;
      }
		
		if($id <= 0){
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác !');	
			redirect( $url, 'refresh');	
		}
      
      $info    =  $this->_model->getFunction($id);
      $post_m  =  $_POST['module'];
      $post_c  =  $_POST['controller'];
      $post_f  =  $_POST['function'];
      if (!isset($post_c['con_show'])) $post_c['con_show']  =  0;
      if (!isset($post_f['fun_show'])) $post_f['fun_show']  =  0;
      
		if($this->db->update('sys_modules', $post_m, array('id' => $info->id))
         && $this->db->update('sys_controllers', $post_c, array('con_id' => $info->con_id))
         && $this->db->update('sys_functions', $post_f, array('fun_id' => $info->fun_id))
         ){
			$this->session->set_flashdata('success','Bạn đã cập nhật thành công !');		
		} else {
			$this->session->set_flashdata('error','Có lỗi mời bạn thử lại lúc khác!');	
		}	
		redirect( $url, 'refresh');
   }
   
   /**
    * Permission::addPermGroup()
    * 
    * @param mixed $iGroup
    * @return void
    */
   function addPermGroup($iGroup) {
      $iGroup  =  intval($iGroup);
      $perm    =  getValue('perm', 'arr', 'POST', array());
      
      //Current permission
      $db_select  =  $this->db->query("SELECT grpe_function_id
                                       FROM sys_group_permission
                                       WHERE grpe_group_id = $iGroup");
      $result =  $db_select->result_array();
      $cur_perm =  array();
      foreach ($result as $k => $v) $cur_perm[]  =  $v['grpe_function_id'];
      //Remove permission not select
      $del_perm   =  array_diff($cur_perm, $perm);
      $list_del   =  implode(',', $del_perm);
      if ((string)$list_del != '')   $db_exe     =  $this->db->query("DELETE FROM sys_group_permission 
                                                                     WHERE grpe_group_id = $iGroup AND grpe_function_id IN($list_del)");
      //Add more permission
      $add_perm =  array_diff($perm, $cur_perm);
      
      $sql  =  "REPLACE INTO sys_group_permission(grpe_group_id, grpe_function_id) VALUES";
      $i =  0;
      foreach ($add_perm as $key => $value) {
         $i++;
         $sql  .= "(" . $iGroup . "," . $value . "),";
      }
      if ($i > 0) {
         $sql  =  substr($sql, 0, -1);
         $db_exe  =  $this->db->query($sql);
      }
      
   }
   
   /**
    * Permission::addPermUser()
    * 
    * @param mixed $uID
    * @return void
    */
   function addPermUser($uID) {
      $uID     =  intval($uID);
      $perm    =  getValue('perm', 'arr', 'POST', array());
      
      //Current permission
      $db_select  =  $this->db->query("SELECT uspe_function_id
                                       FROM sys_user_permission
                                       WHERE uspe_user_id = $uID");
      $result =  $db_select->result_array();
      $cur_perm =  array();
      foreach ($result as $k => $v) $cur_perm[]  =  $v['uspe_function_id'];
      //Remove permission not select
      $del_perm   =  array_diff($cur_perm, $perm);
      $list_del   =  implode(',', $del_perm);
      
      if ((string)$list_del != '')   $db_exe     =  $this->db->query("DELETE FROM sys_user_permission 
                                                                     WHERE uspe_user_id = $uID AND uspe_function_id IN($list_del)");
      //Add more permission
      $add_perm =  array_diff($perm, $cur_perm);
      
      $sql  =  "REPLACE INTO sys_user_permission(uspe_user_id, uspe_function_id) VALUES";
      $i =  0;
      foreach ($add_perm as $key => $value) {
         $i++;
         $sql  .= "(" . $uID . "," . $value . "),";
      }
      if ($i > 0) {
         $sql  =  substr($sql, 0, -1);
         $db_exe  =  $this->db->query($sql);
      }
      
   }
   
   /**
    * Permission::loadCurrentFunction()
    * 
    * @return void
    */
   function loadCurrentFunction() {
      $mCon  =  getValue('mCon', 'int', 'POST');
      $db_select  =  $this->db->query("SELECT fun_name
                                       FROM sys_functions
                                       WHERE fun_controller_id = " . intval($mCon));
      $result  =  $db_select->result_array();
      foreach ($result as $name) {
         echo  $name['fun_name'] . ', ';
      }
   }
   
}




