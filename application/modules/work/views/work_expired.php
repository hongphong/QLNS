<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
	<!-- WORK LIST OF MINE -->
	<div class="wrap-work-list">
		<table class="tbl-work-list" width="100%" border="0">
			<tr>
				<th width="30%"></th>
				<th width="20%" align="left"><span class="bold col-pro-name">Dự án</span></th>
				<th width="15%"><span class="bold col-rate-important">Mức độ</span></th>
				<th width="15%"><span class="bold col-dealine">Hạn cuối</span></th>
				<th width="10%"><span class="bold col-percent">Tỷ lệ</span></th>
				<th width="140px"><span class="bold col-time-delays">Quá hạn</span></th>
			</tr>
			<tr>
				<td>
					<b class="title-work">Việc tôi xử lý <font color="red">(<?php print (isset($workList[1])) ? count($workList[1]) : 0; ?>)</font></b>
				</td>
				<td colspan="4"></td>
			</tr>
			<?php
			if (!empty($workList[1])) {
				foreach ($workList[1] as $wn) {
					?>
					<tr>
						<td width="30%">
							<a href="<?php print base_url() . 'iso/step/detail/' . $wn['id']; ?>">
								<span><?php print $wn['name']; ?></span>
							</a>
						</td>
						<td width="20%">
							<a href="<?php print base_url() . 'iso/project/detail/' . $wn['project_id']; ?>">
								<span><?php print $wn['project_name']; ?></span>
							</a>
						</td>
						<td class="rate-im" width="15%">
							<?php
							$curClass = '';
							if ($wn['rate_important'] == 1) {
								$curClass = 'im-low';
							} else if ($wn['rate_important'] == 2) {
								$curClass = 'im-hight';
							} else if ($wn['rate_important'] == 3) {
								$curClass = 'im-hightest';
							} else {
								$curClass = 'im-low';
							}
							?>
							<select wid="<?php print $wn['id']; ?>" class="<?php print $curClass; ?>" onchange="change_important(this);">
								<option id="im-1" value="1" <?php print ($wn['rate_important'] == 1) ? 'selected="selected"' : ''; ?> class="im-low">Bình thường</option>
								<option id="im-2" value="2" <?php print ($wn['rate_important'] == 2) ? 'selected="selected"' : ''; ?> class="im-hight">Quan trọng</option>
								<option id="im-3" value="3" <?php print ($wn['rate_important'] == 3) ? 'selected="selected"' : ''; ?> class="im-hightest">Khẩn cấp</option>
							</select>
						</td>
						<td width="15%" align="center">
							<span><?php print ($wn['time_complete'] > 0) ? date('d/m/Y', $wn['time_complete']) : 'dd/mm/yyyy'; ?></span>
						</td>
						<td width="10%" align="center">
							<input class="update-progress" wid="<?php print $wn['id']; ?>" onblur="update_progress(this);" type="text" value="<?php print $wn['progress']; ?>"> <span>%</span>
						</td>
						<td width="" align="center">
							<b><font color="<?php print $wn['times_delay_color']; ?>"><?php print $wn['times_delay']; ?></font></b>
						</td>
					</tr>
					<?php
					
				}
			} else {
				?>
				<tr>
					<td colspan="5">Không có việc quá hạn</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	<!-- WORK LIST OF MINE -->
	
	<div class="end-line"><div></div></div>
	
	<!-- WORK LIST MORNITOR -->
	<div class="wrap-work-list">
		<table class="tbl-work-list" width="100%" border="0">
			<tr>
				<td>
					<b class="title-work">Việc tôi theo dõi <font color="red">(<?php print (isset($workList[3])) ? count($workList[3]) : 0; ?>)</font></b>
				</td>
				<td colspan="4"></td>
			</tr>
			<?php
			if (!empty($workList[3])) {
				foreach ($workList[3] as $wn) {
					?>
					<tr>
						<td width="30%">
							<a href="<?php print base_url() . 'iso/step/detail/' . $wn['id']; ?>">
								<span><?php print $wn['name']; ?></span>
							</a>
						</td>
						<td width="20%">
							<a href="<?php print base_url() . 'iso/project/detail/' . $wn['project_id']; ?>">
								<span><?php print $wn['project_name']; ?></span>
							</a>
						</td>
						<td width="15%" class="rate-im">
							<?php
							$curClass = '';
							if ($wn['rate_important'] == 1) {
								$curClass = 'im-low';
							} else if ($wn['rate_important'] == 2) {
								$curClass = 'im-hight';
							} else if ($wn['rate_important'] == 3) {
								$curClass = 'im-hightest';
							} else {
								$curClass = 'im-low';
							}
							?>
							<select wid="<?php print $wn['id']; ?>" class="<?php print $curClass; ?>" onchange="change_important(this);">
								<option id="im-1" value="1" <?php print ($wn['rate_important'] == 1) ? 'selected="selected"' : ''; ?> class="im-low">Bình thường</option>
								<option id="im-2" value="2" <?php print ($wn['rate_important'] == 2) ? 'selected="selected"' : ''; ?> class="im-hight">Quan trọng</option>
								<option id="im-3" value="3" <?php print ($wn['rate_important'] == 3) ? 'selected="selected"' : ''; ?> class="im-hightest">Khẩn cấp</option>
							</select>
						</td>
						<td width="15%" align="center">
							<span><?php print ($wn['time_complete'] > 0) ? date('d/m/Y', $wn['time_complete']) : 'dd/mm/yyyy'; ?></span>
						</td>
						<td width="10%" align="center">
							<input class="update-progress" wid="<?php print $wn['id']; ?>" onblur="update_progress(this);" type="text" value="<?php print $wn['progress']; ?>"> <span>%</span>
						</td>
						<td align="center">
							<b><font color="<?php print $wn['times_delay_color']; ?>"><?php print $wn['times_delay']; ?></font></b>
						</td>
					</tr>
					<?php
					
				}
			} else {
				?>
				<tr>
					<td colspan="5">Không có việc quá hạn</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	<!-- WORK LIST MORNITOR -->
	
<script type="text/javascript">
function update_progress(obj) {
	var step_id = $(obj).attr('wid');
	var progress = $(obj).val();
	if (step_id > 0) {
		$.ajax({
			type: 'POST',
			url: '/iso/step/progress',
			data: {
				step_id: step_id,
				progress: progress
			},
			success: function() {
				if (parseInt(progress) > 100) {
					progress = 100;
					$(obj).val(progress);
				}
				alert('Cập nhật thành công');
			}
		});
	}
}

function change_important(obj) {
	var selected = $(obj).val();
	var wid = $(obj).attr('wid');
	var selected_class = $('#im-'+selected).attr('class');
	$(obj).attr('class', selected_class);
	if (selected > 0) {
		$.ajax({
			type: 'POST',
			url: '/iso/step/important',
			data: {
				step_id: wid,
				rate: selected
			},
			success: function() {
				alert('Cập nhật thành công');
			}
		});
	}
}
</script>




