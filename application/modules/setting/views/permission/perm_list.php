<div>
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- BOX FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
	<table class="tbl-template-2" width="100%" border="1" bordercolor="#f2f2f2" cellspacing="3">
		<tr class="action">
			<td class="box-message" colspan="7">
				<?php Box::showMessage(); ?>
			</td>
		</tr>
		<tr class="title">
			<th width="3%" class="stt">STT</th>
			<th align="left">Username</th>
			<th align="left">Nhóm</th>
			<th align="left">Tên nhân viên</th>
			<th>Ngày tạo</th>
			<th width="7%">Cập nhật</th>
			<th width="7%">Xóa</th>
		</tr>
		<?php
		if (!empty($query)) {
			$stt = 0;
			foreach ($query as $rec) {
				$stt++;
				?>
				<tr>
					<td align="center" class="bg"><b><?php print $stt; ?></b></td>
					<td>
						<a href="javascript:void(0)"><?php print $rec->name; ?></a>
					</td>
					<td>
						<span><?php print $rec->group_name; ?></span>
					</td>
					<td>
						<span><?php print $rec->fullname; ?></span>
					</td>
					<td align="center">
						<span><?php print ($rec->create_date > 0) ? date(FORMAT_DATE, $rec->create_date) : 'mm/dd/yyyy'; ?></span>
					</td>
					<td align="center">
						<a href="<?php print base_url() . 'setting/permission/editperm/' . $rec->id; ?>" class="edit-project"></a>
					</td>
					<td align="center">
						<a id="delete-project" onclick="deleteProject(this)" proid="<?php print $rec->id; ?>" href="javascript:void(0)" class="delete-project"></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
		<tr class="action">
			<td colspan="7">
				Tổng số: <b><font color="red"><?php print (isset($total)) ? $total : 0; ?></font></b> accounts
			</td>
		</tr>
		<tr class="action">
			<td colspan="7">
				<?php print (isset($pagination)) ? $pagination : ''; ?>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript">
function deleteProject(obj) {
	var id = $(obj).attr('proid');
	if (confirm("Bạn chắc chắn muốn bỏ phân quyền cho account này?")) {
		document.location.href = "/setting/permission/delete/" + id;
	} else {
		return false;
	}
}
</script>


