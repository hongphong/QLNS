<!-- CSS & JS -->
<script type="text/javascript" src="<?php print base_url('public/template/iso/js/jquery_benefit.js'); ?>"></script>

<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<?php if (isset($navi)) { ?>
	<div class="navigation">
		<ul>
			<?php print navigation($navi); ?>
		</ul>
	</div>
	<?php } ?>

	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

	<div id="md03">
		<div class="content">
			<form action="<?php print base_url('hrm/groupbenefit/update'); ?>" method="post" enctype="multipart/form-data" id="formAction">
				<input type="hidden" name="group_id" value="<?php print $this->uri->segment(4); ?>">
				<input type="hidden" id="num_benefit" name="num_benefit" value="<?php print $numBenefit; ?>">
				<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
					<tr height="30" style="color: #000;">
						<td width="100%" colspan="4"><strong>Thông tin phòng ban - Chức vụ</strong></td>
					</tr>
					<tr height="30" style="color: #000;">
						<td width="40%">
							<input type="text" name="input[name]" value="<?php print $query->name; ?>" style="width: 90%;" placeholder="Tên nhóm định mức">
						</td>
						<td width="20%">
							<select style="width: 90%;" name="input[company_id]" id="company" class="validate[required]">
								<option value="0">Trực thuộc công ty</option>
								<?php
								if (isset($company) && count($company) > 0 && is_array($company)) {
									foreach ($company as $row) {
										$sel = '';
										if (isset($query->company_id)) {
											if ($query->company_id == $row->id) {
												$sel = 'selected="selected"';
											}
										}
										print '<option '. $sel .' value="'.$row->id.'">'.$row->name.'</option>';
									}
								}
								?>
							</select>
						</td>
						<td width="20%">
							<select style="width: 90%;" name="input[department_id]" id="department" class="validate[required]">
								<option value="">Trực thuộc phòng ban</option>
								<?php
								$sel = 'selected="selected"';
								if (!empty($depart)) {
									foreach ($depart as $ed) {
										$sel = '';
										if (isset($query->department_id)) {
											if ($query->department_id == $ed['id']) {
												$sel = 'selected="selected"';
											}
										}
										print '<option '. $sel .' value="'.$ed['id'].'">'.$ed['name'].'</option>';
									}
								}
								?>
						</select>
						</td>
						<td width="20%">
							<select style="width: 90%;" name="input[position_id]" id="position" class="validate[required]">
								<option value="">Chức vụ</option>
								<?php
								if (!empty($position)) {
									foreach ($position as $ep) {
										$sel = '';
										if (isset($query->position_id)) {
											if ($query->position_id == $ep->id) {
												$sel = 'selected="selected"';
											}
										}
										print '<option '. $sel .' value="'.$ep->id.'">'.$ep->name.'</option>';
									}
								}
								?>
						</select>
						</td>
					</tr>
					<tr height="30" style="color: #000;">
						<td width="100%" colspan="4"><strong>Thông số định mức</strong>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<a onclick="addMoreBenefit(this);">[+] Thêm định mức</a>
						</td>
               </tr>
               <tr style="color: #000;" class="benefit_modal"></tr>
					<?php for($i=0; $i<$numBenefit; $i++) { ?>
					<tr height="30" style="color: #000;" class="benefit_modal">
						<td>
							<select name="benefit_id[]" id="benefit">
								<option value="">Quyền lợi</option>
								<?php
								if (isset($benefit) && count($benefit) > 0 && is_array($benefit)) {
									foreach ($benefit as $row) {
										$sel = '';
										if ($groupBenefit[$i]['benefit_id'] == $row->id) $sel = 'selected="selected"';
										echo '<option '.$sel.' id="ben-'. $row->id .'" value="'.$row->id.'">'.$row->name.'</option>';
									}
								}
								?>
							</select>
						</td>
						<td>
							<input type="text" name="limitation[]" class="jformat" value="<?php print $groupBenefit[$i]['limitation']; ?>" id="limitation" placeholder="Quyền lợi định mức tối đa" />
						</td>
						<td>
							<select name="unit[]" id="unit" class="">
								<option value="">Đơn vị tiền tệ</option>
								<?php
								if (isset($unit) && count($unit) > 0 && is_array($unit)) {
									foreach($unit as $row) {
										$sel = '';
										if ($groupBenefit[$i]['unit_id'] == $row->id) $sel = 'selected="selected"';
										echo '<option '.$sel.' value="'.$row->id.'">'.$row->unit.'</option>';
									}
								}
								?>
							</select>
						</td>
						<td></td>
					</tr>
					<?php } ?>
					
					<!-- MODAL -->
					<tr height="30" style="color: #000;display: none;" id="benefit_modal">
						<td>
							<select name="benefit_id[]" id="benefit">
								<option value="">Quyền lợi</option>
								<?php
								if (isset($benefit) && count($benefit) > 0 && is_array($benefit)) {
									foreach ($benefit as $row) {
										echo '<option id="ben-'. $row->id .'" value="'.$row->id.'">'.$row->name.'</option>';
									}
								}
								?>
							</select>
						</td>
						<td>
							<input type="text" name="limitation[]" class="jformat" id="limitation" placeholder="Quyền lợi định mức tối đa" />
						</td>
						<td>
							<select name="unit[]" id="unit" class="">
								<option value="">Đơn vị tiền tệ</option>
								<?php
								if (isset($unit) && count($unit) > 0 && is_array($unit)) {
									foreach($unit as $row) {
										echo '<option value="'.$row->id.'">'.$row->unit.'</option>';
									}
								}
								?>
							</select>
						</td>
						<td></td>
					</tr>
					<tr height="50" style="color: #000; text-align: left;">
						<td width="100%" colspan="3" align="center">
							<button name="submit" value="submit">Cập nhật</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="footer"></div>
	</div>
</div>


