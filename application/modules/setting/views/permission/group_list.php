<div>
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- BOX FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
	<table class="tbl-template-2" width="100%" border="1" bordercolor="#f2f2f2" cellspacing="3">
		<tr class="action">
			<td class="box-message" colspan="6">
				<?php Box::showMessage(); ?>
			</td>
		</tr>
		<tr class="title">
			<th width="3%" class="stt">STT</th>
			<th align="left">Tên nhóm</th>
			<th width="12%">Ngày tạo</th>
			<th width="12%">Ngày cập nhật</th>
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
					<td align="center">
						<span><?php print ($rec->time_create > 0) ? date(FORMAT_DATE, $rec->time_create) : 'mm/dd/yyyy'; ?></span>
					</td>
					<td align="center">
						<span><?php print ($rec->time_update > 0) ? date(FORMAT_DATE, $rec->time_update) : 'mm/dd/yyyy'; ?></span>
					</td>
					<td align="center">
						<a href="<?php print base_url() . 'setting/permission/editgroup/' . $rec->id; ?>" class="edit-project"></a>
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
				Tổng số: <b><font color="red"><?php print (isset($total)) ? $total : 0; ?></font></b> nhóm
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
	if (confirm("Bạn chắc chắn muốn hủy dự án này?")) {
		document.location.href = "/setting/permission/delete/" + id;
	} else {
		return false;
	}
}
</script>


