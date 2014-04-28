<?php

class CreateUrl extends MX_Controller {

   public function createUrl($segment = 1, $deny='', $new = '') {
      $base_url = '';
      for ($i = 1; $i <= $segment; $i++) {
         $base_url .= $this->uri->segment($i) . '/';
      }
      $get = $_GET;
      $i = 0;
      if ($get) {
         foreach ($get as $key => $value) {
            if (strpos($base_url, '?') === false) {//lan dau thi them dau ?
               if ($key != $deny) {
                  $base_url .= '?' . $key . '=' . $value;
               }
            } else {
               if ($key != $deny) {
                  $base_url .= '&' . $key . '=' . $value;
               }
            }
         }
      }
      if (strpos($base_url, '?') === false) {
         $url = base_url() . $base_url . '?' . $new ;
      } else {
         $url = base_url() . $base_url . '&' . $new ;
      }
      return $url;
   }

}

?>
