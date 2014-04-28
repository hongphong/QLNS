<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class CustomerManager extends MX_Controller{
	
   public function __construct()
	{
		parent::__construct();
	}
	
   public function validateCompany($post, $update = false)
   {
      $msg = array();
      
      /** Validate company name **/
      $name  =  isset($post['com_name']) ? $post['com_name'] : '';
      
      //check the length of the username
      if (iconv_strlen($name) < MIN_COMPANY_LENGTH)
         $msg[] = "Tên công ty phải có ít nhất " . MIN_COMPANY_LENGTH . " ký tự.";
      
        //check if the username existed	
      $this->db->where(array('com_name' => $name));
      $query = $this->db->from("cus_company");
      $existed_user = $query->count_all_results();
        
      if (!$update && $existed_user) $msg[] = "Tên công ty đã tồn tại, vui lòng chọn tên khác.";
      
      /** Validate country, city, district, street... **/
      $country    =  isset($post['com_country']) ? intval($post['com_country']) : 0;
      $city       =  isset($post['com_city']) ? intval($post['com_city']) : 0;
      $district   =  isset($post['com_district']) ? intval($post['com_district']) : 0;
      $street     =  isset($post['com_street']) ? trim($post['com_street']) : '';
      $phone      =  isset($post['com_phone']) ? trim($post['com_phone']) : '';
      
      if ($country <= 0) $msg[] = "Bạn vui lòng chọn Quốc gia.";
      if ($city <= 0) $msg[] = "Bạn vui lòng chọn Tỉnh/TP.";
      if ($district <= 0) $msg[] = "Bạn vui lòng chọn Quận huyện.";
      if ($street == '') $msg[] = "Bạn vui lòng nhập Tên đường/Số nhà.";
      if ($phone == '') $msg[] = "Bạn vui lòng nhập Số điện thoại.";
      
      /** Validate type, group, career **/
      $group   =  isset($post['com_group']) ? intval($post['com_group']) : 0;
      $type    =  getValue('type', 'arr', 'POST', array());
      $career  =  getValue('career', 'arr', 'POST', array());
      
      if ($group <= 0) $msg[] = "Bạn vui lòng chọn Nhóm khách hàng.";
      if (empty($type)) $msg[] = "Bạn vui lòng chọn Loại hình doanh nghiệp.";
      if (empty($career)) $msg[] = "Bạn vui lòng chọn Ngành nghề/Lĩnh vực.";
      
      return $msg;
   }
   
   
   /**
    * getLoggedID()
    * 
    * @param integer $uid: Field uid in table employee
    * @return Real employee ID
    */
   function getLoggedID($uid = 0) {
      if ($uid == 0) $uid  =  $this->session->userdata('uid');
      if ($uid == 0) $uid  =  56;
      
      $db_select  =  $this->db->query("SELECT id
                                       FROM mc_employee
                                       WHERE uid = $uid");
      $result  =  $db_select->result_array();
      if (isset($result[0]['id'])) return intval($result[0]['id']);
      return 0;
   }
}