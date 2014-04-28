<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jquery_hrm.js'; ?>"></script>

<div class="pro-info wrap-main">
   <!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
   <!-- MENU FUNCTION -->
   <?php $tmp = Box::boxFuncI();
   print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
   <!-- SELECT BOX -->
   <?php $this->load->view('select_box'); ?>
	
   <form action="<?php print base_url() . 'hrm/reportlog/update_dayoff'; ?>" method="post">
      <input type="hidden" name="action" value="update_dayoff">
      <input type="hidden" name="month" value="<?php print $month; ?>">
      <input type="hidden" name="year" value="<?php print $year; ?>">
      <input type="hidden" name="numday" value="<?php print $numday; ?>">
      <input type="hidden" name="total_em" value="<?php print (!empty($total_em)) ? implode(',', $total_em) : ''; ?>">
      <input type="hidden" name="json_data" value="<?php print base64_encode(json_encode($rec)); ?>">
      <table id="logon-time" width="100%" bordercolor="#d8d8d8" border="1" style="border-collapse: collapse;">
         <?php
         if (!empty($employ)) {
            $i = 0;
            $stt = 0;
            foreach ($employ as $dep => $emp) {
               foreach ($emp as $em) {
                  $i++;
                  $totalNCL = (isset($rec['total-ncl-' . $em['id']])) ? $rec['total-ncl-' . $em['id']] : 0;
                  $totalNKL = (isset($rec['total-nkl-' . $em['id']])) ? $rec['total-nkl-' . $em['id']] : 0;
                  if ($i == 1) {
                     ?>
                     <tr>
                        <td width="200" align="center"><b>Nhân viên</b></td>
                        <td align="center" style="border: none;">
                           <table id="" width="100%">
                              <tr>
                                 <?php
                                 $d = 0;
                                 for ($d = 1; $d <= $numday; $d++) {
                                    print '<td style="padding: 0px;border: 0px;" align="center"><b style="width: 20px;display: block;font-size: 11px;">' . $d . '</b></td>';
                                 }
                                 ?>
                              </tr>
                           </table>
                        </td>
                        <td align="center" style="border: none;"><b>NKL</b></td>
                        <td align="center" style="border: none;"><b>NCL</b></td>
                     </tr>
                     <?php
                  } else {
                     ?>
                     <tr>
                        <td align="left"><?php print $em['fullname']; ?></td>
                        <td align="center" style="border: none;">
                           <table id="" width="100%" bordercolor="#d8d8d8" border="1" style="border-collapse: collapse;">
                              <tr>
                                 <?php
                                 $class = '';
                                 for ($h = 1; $h <= $numday; $h++) {
                                    $stt ++;
                                    $name = 'rec-' . $em['id'] . '-' . $h . '-' . $month . '-' . $year;
                                    if (isset($rec[$name])) {
                                       $record = $rec[$name];
                                    } else {
                                       $record = 0;
                                    }
                                    $label = '';
                                    $status = '';
                                    if ($record == 1) {
                                       $label = '<span>P</span>';
                                       $status = 'ncl';
                                    }
                                    if ($record == 2) {
                                       $label = '<span>L</span>';
                                       $status = 'ncl';
                                    }
                                    if ($record == 3) {
                                       $label = '<span>NKL</span>';
                                       $status = 'nkl';
                                    }
                                    ?>
                                    <td class="dayoff-wrap" align="center">
                                       <input type="hidden" name="<?php print $name; ?>" value="<?php print $record; ?>">
                                       <div class="dayoff-item <?php print 'd' . $record; ?>" onclick="choose_dayoff(this);">
                                          <?php print $label; ?>
                                       </div>
                                       <ul class="dayoff-list hid_show_<?php echo $stt?>" rel="0" stt="<?php echo $stt?>" >
                                          <li current="<?php print $status; ?>" class="p" day="<?php print $h; ?>" month="<?php print $month; ?>" year="<?php print $year; ?>" em="<?php print $em['id']; ?>" onclick="pick_dayoff(this, 'p');">P</li>
                                          <li current="<?php print $status; ?>" class="l" day="<?php print $h; ?>" month="<?php print $month; ?>" year="<?php print $year; ?>" em="<?php print $em['id']; ?>" onclick="pick_dayoff(this, 'l');">L</li>
                                          <li current="<?php print $status; ?>" class="nkl" day="<?php print $h; ?>" month="<?php print $month; ?>" year="<?php print $year; ?>" em="<?php print $em['id']; ?>" onclick="pick_dayoff(this, 'nkl');">NKL</li>
                                       </ul>
                                    </td>
                                    <?php
                                 }
                                 ?>
                              </tr>
                           </table>
                        </td>
                        <td align="center" style="border: none;">
                           <input class="total-nl" id="total-nkl-<?php print $em['id']; ?>" type="text" name="total-kl-<?php print $em['id']; ?>" value="<?php print $totalNKL; ?>">
                        </td>
                        <td align="center" style="border: none;">
                           <input class="total-nl" id="total-ncl-<?php print $em['id']; ?>" type="text" name="total-cl-<?php print $em['id']; ?>" value="<?php print $totalNCL; ?>">
                        </td>
                     </tr>
                     <?php
                  }
               }
            }
         }
         ?>
         <tr>
            <td colspan="4" align="center">
               <input class="button" type="submit" name="submit" value="Cập nhật">
            </td>
         </tr>
      </table>
   </form>
</div>



<!-- 
<script type="text/javascript">
   function choose_dayoff(obj) {
      $('.dayoff-list').css('display','none'); 
      var value_1 =  $(obj).parent().find('.dayoff-list').attr('rel');
      if(value_1 == 0){
         $(obj).parent().find('.dayoff-list').css('display', 'block');
         $('.dayoff-list').attr('rel','0');
         $(obj).parent().find('.dayoff-list').attr('rel','1');
           
      }else{
         $(obj).parent().find('.dayoff-list').css('display', 'none');
         $('.dayoff-list').attr('rel','0');
         $(obj).parent().find('.dayoff-list').attr('rel','0');
         //$('.dayoff-list').attr('rel','0');
      }
      //return false;
   }
   
   function pick_dayoff(obj, item) {
      var grandparent = $(obj).parent().parent();
      var em = $(obj).attr('em');
      var total_cl = parseInt($('#total-ncl-'+em).val());
      var total_kl = parseInt($('#total-nkl-'+em).val());
      var day = $(obj).attr('day');
      var month = $(obj).attr('month');
      var year = $(obj).attr('year');
      var val = 0;
      var current = $(obj).attr('current');
      var flag = '';
      $(obj).parent().css('display', 'none');
      if (item == 'p') {
         $(grandparent).find('.dayoff-item').html('<span>P</span>');
         $(grandparent).find('.dayoff-item').css('background', '#00b050');
         flag = 'ncl';
         val = 1;
      } else if (item == 'l') {
         $(grandparent).find('.dayoff-item').html('<span>L</span>');
         $(grandparent).find('.dayoff-item').css('background', '#2f2fff');
         flag = 'ncl';
         val = 2;
      } else if (item == 'nkl') {
         $(grandparent).find('.dayoff-item').html('<span>NKL</span>');
         $(grandparent).find('.dayoff-item').css('background', '#ff0000');
         flag = 'nkl';
         val = 3;
      }
      if (current != '') {
         if (flag != current) {
            if (flag == 'ncl') {
               $('#total-ncl-'+em).val(total_cl+1);
               $('#total-nkl-'+em).val(total_kl-1);
            } else {
               $('#total-ncl-'+em).val(total_cl-1);
               $('#total-nkl-'+em).val(total_kl+1);
            }
         }
      } else {
         if (flag == 'ncl') {
            $('#total-ncl-'+em).val(total_cl+1);
         } else {
            $('#total-nkl-'+em).val(total_kl+1);
         }
      }
      $(obj).parent().find('li').each(function() {
         $(this).attr('current', flag);
      });
      $('input[name=rec-'+em+'-'+day+'-'+month+'-'+year+']').val(val);
   }
</script>
 -->

