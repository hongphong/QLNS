<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<?php if (isset($navi)) { ?><div class="navigation"><ul><?php print navigation($navi); ?></ul></div><?php } ?>
	
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

	<div>
		<div>
			<div>
				<table class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
					<tr>
						<td class="box-message" colspan="6"><?php print Box::showMessage(); ?>
							<?php print Box::showMessage(); ?>
						</td>
					</tr>
					<tr class="title">
						<th width="3%" class="stt">STT</th>
						<th>Tên nhóm</th>
						<th>Phòng ban</th>
						<th>Chức vụ</th>
						<th width="7%">Sửa</th>
						<th width="7%">Xóa</th>
					</tr>
					<?php
					if (isset($query) && is_array($query) && count($query) > 0) {
						$stt = 0;
						foreach ($query as $row) {
							$stt++;
							$id = $row->id;
							$name = $row->name;
							$depart = $row->department;
							$position = $row->position;
							$linkEdit = base_url('hrm/groupbenefit/edit/'.$id);
							$linkDetail = base_url('hrm/groupbenefit/edit/'.$id);
							?>
							<tr>
								<td align="center"><b><?php print $stt; ?> </b></td>
								<td align="left">
									<a href="<?php print $linkDetail; ?>"><?php print $name; ?></a>
								</td>
								<td><?php print $depart; ?></td>
								<td><?php print $position; ?></td>
								<td align="center"><a href="<?php print $linkEdit; ?>" class="edit-project"></a></td>
								<td align="center"><a href="javascript:;"
									onclick="cpanel.deleted($(this), <?php print $id; ?>, '<?php print $actionDel ?>');"
									class="delete-project"></a>
								</td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr>
							<td align="left" colspan="6">
								<p style="color: #f00; padding-left: 10px;">Dữ liệu đang được cập nhật.</p>
							</td>
						</tr>
						<?php
					}
					?>
					<tr class="action">
						<td colspan="6"><?php print $pagination; ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
