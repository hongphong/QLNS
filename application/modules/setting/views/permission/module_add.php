<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- BOX FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
   <div id="md03">
    	<form action="<?php print base_url().'setting/permission/module_insert'; ?>" method="post" enctype="multipart/form-data">
       	<input type="hidden" name="action" value="insert_group">
       	<div>
           	<div class="lb-head">
            	<b class="gray">Thêm mới module, chức năng</b>
            </div>
            <div class="content">
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" class="table_2">
                  <tr height="30">
                     <td width="14%">
                        <select id="current_module" name="current_module" onchange="loadController(this.value);">
                           <option value="0">Chọn module</option>
                           <?
                           foreach ($module as $k => $v) {
                              echo  '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                           }
                           ?>
                        </select>
                     </td>
                     <td width="10%">
                        Hoặc thêm mới:
                     </td>
                     <td width="10%" align="right">Tên Module:</td>
                     <td width="14%"><input type="text" name="new_module" placeholder="Tên Module" title="Tên Module"/></td>
                     <td width="8%" align="right">Tên nhãn:</td>
                     <td width="14%"><input type="text" name="new_module_alias" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td colspan="2"></td>
                  </tr>
                  <tr height="30">
                     <td width="14%">
                        <select id="current_controller" name="current_controller">
                           <option value="0">Chọn mục</option>
                        </select>
                     </td>
                     <td width="10%">
                        Hoặc thêm mới:
                     </td>
                     <td width="10%" align="right">Tên mục:</td>
                     <td width="14%"><input type="text" name="new_controller" placeholder="Tên mục" title="Tên mục"/></td>
                     <td width="8%" align="right">Tên nhãn:</td>
                     <td width="14%"><input type="text" name="new_controller_alias" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td width="10%"><label title="Hiển thị trên menu"><input type="checkbox" name="new_controller_show[]" value="1" checked="checked" />Hiển thị</label></td>
                     <td></td>
                  </tr>
                  <tr height="30" style="display: none;" id="temp_more">
                     <td colspan="2"></td>
                     <td width="10%" align="right">
                        Tính năng mới:
                     </td>
                     <td width="14%">
                        <input type="text" name="new_function_xxx[]" placeholder="Tên tính năng" title="Tên tính năng" />
                     </td>
                     <td width="8%" align="right">Tên nhãn:</td>
                     <td width="14%"><input type="text" name="new_function_alias_xxx[]" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td width="10%"><label title="Hiển thị trên menu"><input type="checkbox" name="show[]" value="1" checked="checked" />Hiển thị</label></td>
                     <td><label class="remove_more">[-]</label></td>
                  </tr>
                  <tr height="30">
                     <td colspan="2"></td>
                     <td width="10%" align="right">
                        Tính năng mới:
                     </td>
                     <td width="14%">
                        <input type="text" name="new_function[]" placeholder="Tên tính năng" title="Tên tính năng" />
                     </td>
                     <td width="8%" align="right">Tên nhãn:</td>
                     <td width="14%"><input type="text" name="new_function_alias[]" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td width="10%"><label title="Hiển thị trên menu"><input type="checkbox" name="show[]" value="1" checked="checked" />Hiển thị</label></td>
                     <td><label class="add_more">[+]</label></td>
                  </tr>
            		<tr height="50" style="color:#000;" id="btn_form">
                     <td colspan="3"></td>
                     <td colspan="4">
                     	<button name="submit" value="submit">Thêm mới</button>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </form>
   </div>
</div>

<script>
   function loadController(module) {
      $.post(
         '/setting/permission/loadController/',
         {module: module},
         function (data) {
            $('#current_controller').html(data);
         }
      );
   }
   
   $('.add_more').click(function() {
      var html = $('#temp_more').html();
      html = html.replace(/_xxx/g, '');
      var html = '<tr height="30">' + html + '</tr>';
      $(html).insertBefore($('#btn_form'));
   });
   
   $('.remove_more').live('click', function () {
      $(this).parents('tr').eq(0).remove();
   });
</script>