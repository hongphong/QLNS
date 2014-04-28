<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jquery_permission.js'; ?>"></script>
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
       	<input type="hidden" name="action" value="update_perm">
       	<input type="hidden" name="username" value="<?php print $userInfo['name']; ?>">
       	<input type="hidden" name="uid" value="<?php print $this->uri->segment(4); ?>">
       	<div>
           	<div class="lb-head">
            	<b class="gray">Thông tin chung</b>
            </div>
            <div class="content">
            	<table width="80%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="30%">
                        	<label class="gray">Account:</label> <span><?php print $userInfo['name']; ?></span>
                        </td>
                        <td width="30%">
                        	<label class="gray">Họ tên:</label> <span><?php print $userInfo['fullname']; ?></span>
                        </td>
                        <td>
                        	<label class="gray">Cập nhật lần cuối: <?php print '('.(($userInfo['last_update'] > 0) ? date(FORMAT_DATE, $userInfo['last_update']) : 'mm/dd/yyyy') . ')'; ?></label>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="lb-head">
            	<b class="gray">Phân quyền module</b>
            </div>
            <div class="content">
            	<table class="tbl-template-2 tbl_perm" width="100%">
            		<tr>
            			<td colspan="6" style="padding-left: 3px;">
            				<label class="gray">Nhóm:</label>
            				<select id="group" name="group" style="width: 25%;padding: 2px 4px;">
            					<?php 
            					if (!empty($allGroup)) {
            						foreach ($allGroup as $group) {
            							$sel = '';
            							if ($group['id'] == $userInfo['group_id']) $sel = 'selected="selected"';
            							print '<option '.$sel.' value="'. $group['id'] .'">'. $group['name'] .'</option>';
            						}
            					} else {
            						print '<option value="0">- Chưa có nhóm phân quyền nào -</option>';
            					}
            					?>
            				</select>
            			</td>
            		</tr>
                  <tr height="10"><td colspan="6"></td></tr>
                  <tr class="title">
            			<th width="2%" class="stt"></th>
            			<th align="left">Module</th>
            		</tr>
                  <tr height="10"><td colspan="6"></td></tr>
            		<?php
            		if (!empty($allPerm)) {
            			$stt = 0;
                     
            			foreach ($allPerm as $mID => $module) {
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
                                          <?
                                          foreach ($controller['child'] as $fID => $function) {
                                             ?>
                                             <p><label><input type="checkbox" name="perm[]" value="<?=$fID?>" <?=(in_array($fID, $userPerm) ? 'checked' : '')?> class="c_child" /><?=$function['fun_name']?></label></p>
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
         $(this).parents('tr').eq(1).find('input[type=checkbox]').attr('checked', 'checked');
      } else {
         $(this).parents('tr').eq(1).find('input[type=checkbox]').removeAttr('checked');
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