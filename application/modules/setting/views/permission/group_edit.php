<style>
   table.tbl-template-2 tr:hover { background: none; }
   table.tbl-template-2 td {
      vertical-align: top;
      padding: 0 !important;
   }
   
</style>
<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- BOX FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
    <div>
    	<form action="<?php print base_url().'setting/permission/submit'; ?>" method="post" enctype="multipart/form-data">
       	<input type="hidden" name="action" value="update_group">
       	<input type="hidden" name="groupid" value="<?php print $this->uri->segment(4); ?>">
       	<div>
           	<div class="lb-head">
            	<b class="gray">Thông tin chung</b>
            </div>
            <div class="content">
            	<table width="80%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="50%">
                        	<input style="width: 90%;" type="text" name="name" value="<?php print $groupInfo['name']; ?>" placeholder="Tên nhóm"/>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="lb-head">
            	<b class="gray">Phân quyền module</b>
            </div>
            <div class="content">
            	<table class="tbl-template-2 tbl_perm" width="100%">
            		<tr class="title">
            			<th width="2%" class="stt">STT</th>
            			<th align="left">Tên module</th>
                     <td></td>
            		</tr>
                  <tr height="10"><td colspan="6"></td></tr>
            		<?php
            		if (!empty($groupPerm)) {
            			$stt = 0;
            			foreach ($groupPerm as $mID => $module) {
            				$stt++;
                        $m_info           =  $module['info'];
                        $arr_controller   =  $module['child'];
                        
                        //Tong so controller va tong so funtion
                        $total_c   =  $m_info['total_controller'];
            				$total_f   =  $m_info['total_function'];
                        
            				?>
                        <tr>
		                    	<td align="center" class=""><a class="tstt">[+]</a></td>
                           <td>
                              <p class="mod"><?=$m_info['name']?></p>
                              <table class="ul_checkbox" width="99%" border="1" style="border-collapse: collapse;" bordercolor="#bbb">
                                 <tr>
                                    <?
                                    $i =  0;
                                    foreach ($arr_controller as $cID => $controller) {
                                       ?>
                                       <td width="20%">
                                          <label class="th"><?=$controller['info']['con_name']?></label>
                                          <p><label><input type="checkbox" class="checkall" />Chọn tất cả</label></p>
                                          <?
                                          foreach ($controller['child'] as $fID => $function) {
                                             ?>
                                             <p><label><input type="checkbox" name="perm[]" value="<?=$fID?>" <?=(in_array($fID, $currentPerm) ? 'checked' : '')?> class="c_child" /><?=$function['fun_name']?></label></p>
                                             <?
                                          }
                                          ?>
                                       </td>
                                       <?
                                       $i++;
                                       if ($i % 5 == 0) echo '</tr><tr>';
                                    }
                                    ?>
                                 </tr>
                              </table>
                           </td>
                        </tr>
            				<?php
                        
            			}
            		}
            		?>
            		<tr class="action">
            			<td colspan="6">
	            			<div class="btt-submit">
   								<div class="btt-submit-wrap">
   									<input id="dlall" class="btt-submit" type="submit" value="Cập nhật">
   								</div>
   							</div>
						   </td>
            		</tr>
                </table>
            </div>
        </div>	
        </form>
    </div>
</div>
<script>
   $('.checkall').click(function() {
      if ($(this).is(':checked')) {
         $(this).parents('td').eq(0).find('input[type=checkbox]').attr('checked', 'checked');
      } else {
         $(this).parents('td').eq(0).find('input[type=checkbox]').removeAttr('checked');
      }
   });
   
   $('.tstt').click(function() {
      var table = $(this).parent().next().find('.ul_checkbox');
      if (table.is(':visible')) {
         table.hide();
         $(this).html('[+]');
      } else {
         table.show();
         $(this).html('[-]');
      }
   });
</script>