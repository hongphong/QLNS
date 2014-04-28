<div>
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- BOX FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	<div class="search_listing">
      <form method="GET" action="">
         <table class="tbl_search">
            <tr>
               <td>
                  <select id="module" name="module">
                     <option value="0">Chọn module</option>
                     <?
                     foreach ($allModule as $rMod) {
                        echo  '<option value="' . $rMod['id'] . '"' . ($rMod['id'] == $module ? ' selected' : '') . '>' . $rMod['name'] . '</option>';
                     }
                     ?>
                  </select>
               </td>
               <td>
                  <select id="controller" name="controller">
                     <option value="0">Chọn mục</option>
                     <?
                     foreach ($allController as $rCon) {
                        echo  '<option value="' . $rCon['con_id'] . '"' . ($rCon['con_id'] == $controller ? ' selected' : '') . '>' . $rCon['con_name'] . '</option>';
                     }
                     ?>
                  </select>
               </td>
               <td>
                  <input type="submit" value="Tìm kiếm" class="btn" />
               </td>
            </tr>
         </table>
      </form>
   </div>
	<table class="tbl-template-2" width="100%" border="1" bordercolor="#f2f2f2" cellspacing="3">
		<tr class="action">
			<td class="box-message" colspan="6">
				<?php Box::showMessage(); ?>
			</td>
		</tr>
		<tr class="title">
			<th width="3%" class="stt">STT</th>
			<th width="12%">Module</th>
			<th width="12%">Mục</th>
			<th>Tính năng</th>
			<th width="8%">Nhãn</th>
			<th width="8%">Hiển thị</th>
			<th width="7%">Cập nhật</th>
		</tr>
		<?php
		if (!empty($allPerm)) {
			$stt = 0;
			foreach ($allPerm as $mID => $module) {
			   $m_info           =  $module['info'];
            $arr_controller   =  $module['child'];
            foreach ($arr_controller as $cID => $controller) {
               
               foreach ($controller['child'] as $fID => $function) {
      				$stt++;
                  $actionDel  =  base_url() . 'setting/permission/module_delete/' . $fID;
      				?>
      				<tr>
      					<td align="center" class="bg"><b><?php print $stt; ?></b></td>
      					<td>
      						<?=$m_info['name']?>
      					</td>
      					<td>
      						<?=$controller['info']['con_name']?>
      					</td>
      					<td align="center">
      						<?=$function['fun_name']?>
      					</td>
      					<td align="center">
      						<?=$function['fun_alias']?>
      					</td>
      					<td align="center">
      						<?=$function['fun_show'] == 1 ? 'Có' : 'Không'?>
      					</td>
                     <td align="center">
                     	<p><a href="<?=base_url() . 'setting/permission/module_edit/' . $fID . '/?url=' . base64_encode($_SERVER['REQUEST_URI'])?>"><img src="<?=PATH_THEME?>images/edit.png" title="Sửa thông tin" /></a></p>
                     </td>
      				</tr>
      				<?php
               }
            }
			}
		}
		?>
		<tr class="action">
			<td colspan="7">
				Tổng số: <b><font color="red"><?php print (isset($total)) ? $total : 0; ?></font></b> 
			</td>
		</tr>
		<tr class="action">
			<td colspan="7">
				<?php print (isset($pagination)) ? $pagination : ''; ?>
			</td>
		</tr>
	</table>
</div>
<script>
   $('#module').change(function() {
      $('#controller').load('/setting/permission/loadController/?module=' + $(this).val());
   });
</script>
