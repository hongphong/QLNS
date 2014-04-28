<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
      	
	    //Check permisstion
	    $uid = (int)$this->session->userdata('uid');
	    if ($uid > 0) $this->checkPermission();
	}
	
	public function __get($class) {
		return CI::$APP->$class;
	}
   
   /**
    * MX_Controller::checkPermission()
    * 
    * @return void
    */
   function checkPermission() {
      /* check login */
      $uid = (int) $this->session->userdata('uid');
      
      //Get current Module, Controller and Function accessing
      $module      =  $this->uri->segment(1);
      $controller  =  $this->router->class;
      $function    =  $this->router->method;
      //echo  $module . '<br>';
//      echo  $controller . '<br>';
//      echo  $function . '<br>';
      if (!$module) $this->accessDeny();
      
      if ($controller == '') $controller  =  $module;
      if ($function == '') $function      =  'index';
      
      //echo  $module . '<br>' . $controller . '<br>' . $function;
      
      //If user is root admin
      if ($uid == 1) return true;
      
      //Do not check permission of notification module
      if ($module == 'home') return true;
      if ($module == 'work') return true;
      if ($module == 'notification') return true;
      if ($module == 'iso') {
      	if ($controller == 'project' || $controller == 'step' || $controller == 'phase') return true;
      }
      
      $db_check   =  $this->db->query("SELECT fun_id
                                       FROM sys_functions
                                       STRAIGHT_JOIN sys_controllers ON(fun_controller_id = con_id)
                                       STRAIGHT_JOIN sys_modules ON(con_module_id = id)
                                       WHERE alias = '$module' AND con_alias = '$controller' AND fun_alias = '$function'
                                       LIMIT 1");
      $result  =  $db_check->result_array();
      
      if (isset($result[0]['fun_id'])) {
         $iFun =  intval($result[0]['fun_id']);
         
         $db_perm =  $this->db->query("SELECT uspe_function_id
                                       FROM sys_user_permission
                                       WHERE uspe_user_id = $uid AND uspe_function_id = $iFun");
         
         $perm_result   =  $db_perm->result_array();
         
         if (count($perm_result) <= 0) $this->accessDeny();
      }
      
      return true;
   }
   
   function accessDeny() {
      redirect(base_url().'notification/deny/?url=' . base64_encode($_SERVER['REQUEST_URI']), 'refresh');
   }
}



