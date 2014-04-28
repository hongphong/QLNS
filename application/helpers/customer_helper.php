<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('business_type'))
{
   /**
    * business_type()
    * Loai hinh doanh nghiep: TNHH, co phan, nha nuoc...
    * @return void
    */
   function business_type() {
      $arr  =  array(
                     1 => 'TNHH',
                     2 => 'Cổ phần',
                     3 => 'Nhà nước',
                     4 => 'Nước ngoài'
                     );
      return $arr;
   }
   
   /**
    * customer_group()
    * Nhom KH: Cty minh, KH, doi tac...
    * @return void
    */
   function customer_group() {
      $arr  =  array(
                     1 => 'Khách hàng',
                     2 => 'Đối tác',
                     3 => 'Khách hàng + Đối tác'
                     );
      return $arr;
   }
   
   /**
    * customer_country()
    * Quoc gia
    * @return void
    */
   function customer_country() {
      $arr  =  array(
                     1 => 'Việt Nam',
                     2 => 'Mỹ',
                     3 => 'Anh'
                     );
      return $arr;
   }
   
   /**
    * payment_method()
    * 
    * @return
    */
   function payment_method() {
      $arr  =  array(
                     1 => 'Thanh toán tiền mặt',
                     2 => 'Chuyển khoản ngân hàng'
                     );
      return $arr;
   }
}