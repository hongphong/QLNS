<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- BOX FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
   <div id="md03">
    	<form action="<?php print base_url().'setting/permission/module_update'; ?>" method="post" enctype="multipart/form-data">
       	<input type="hidden" name="id" value="<?=$query->fun_id?>">
         <input type="hidden" name="url" value="<?=$url?>" />
       	<div>
           	<div class="lb-head">
            	<b class="gray">Sửa thông tin tính năng</b>
            </div>
            <div class="content">
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" class="table_2">
                  <tr height="30">
                     <td width="8%" align="right">Module:</td>
                     <td width="14%"><input type="text" name="module[name]" value="<?=isset($module['name']) ? $module['name'] : $query->name?>" placeholder="Tên Module" title="Tên Module"/></td>
                     <td width="8%" align="right">Nhãn:</td>
                     <td width="14%"><input type="text" name="module[alias]" value="<?=isset($module['alias']) ? $module['alias'] : $query->alias?>" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td></td>
                  </tr>
                  <tr height="30">
                     <td width="8%" align="right">Tên mục:</td>
                     <td width="14%"><input type="text" name="controller[con_name]" value="<?=isset($controller['con_name']) ? $controller['con_name'] : $query->con_name?>" placeholder="Tên mục" title="Tên mục"/></td>
                     <td width="8%" align="right">Nhãn:</td>
                     <td width="14%"><input type="text" name="controller[con_alias]" value="<?=isset($controller['con_alias']) ? $controller['con_alias'] : $query->con_alias?>" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td width="10%"><label title="Hiển thị trên menu"><input type="checkbox" name="controller[con_show]" value="1"<?=($query->con_show == 1 ? ' checked="checked"' : '')?> />Hiển thị</label></td>
                     <td></td>
                  </tr>
                  <tr height="30">
                     <td width="8%" align="right">Tính năng:</td>
                     <td width="14%">
                        <input type="text" name="function[fun_name]" value="<?=isset($function['fun_name']) ? $function['fun_name'] : $query->fun_name?>" placeholder="Tên tính năng" title="Tên tính năng" />
                     </td>
                     <td width="8%" align="right">Nhãn:</td>
                     <td width="14%"><input type="text" name="function[fun_alias]" value="<?=isset($function['fun_alias']) ? $function['fun_alias'] : $query->fun_alias?>" placeholder="Tên nhãn" title="Tên nhãn"/></td>
                     <td width="10%"><label title="Hiển thị trên menu"><input type="checkbox" name="function[fun_show]" value="1"<?=($query->fun_show == 1 ? ' checked="checked"' : '')?> />Hiển thị</label></td>
                     <td></td>
                  </tr>
            		<tr height="50" style="color:#000;">
                     <td></td>
                     <td colspan="4">
                     	<button name="submit" value="submit">Cập nhật</button>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </form>
   </div>
</div>