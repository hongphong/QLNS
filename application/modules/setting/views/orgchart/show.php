<style type="text/css">
.miz-fame-1 tr td:first-child { padding-left: 5px; }
td.m input { width: 75%; }
td.m .m-c { float: left;margin: 5px 4px 0px 0px; }
</style>


<div class="pro-info wrap-main">
<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

	<div>
		<input type="hidden" id="number_phase" name="number_phase" value="1">
		<input type="hidden" id="max_phase_order" value="0">
		<table class="miz-fame-1 tbl-template-2" width="90%" border="1" bordercolor="#f2f2f2" cellspacing="1" cellpadding="5">
			<tr class="title">
				<th width="35%" align="left">
					<a class="more_phase" href="javascript:void(0)">
						<strong>(+)</strong>
					</a> Bộ phận / Ban
				</th>
				<th width="10%" align="center">Chức vụ</th>
				<th width="10%" align="center">Phụ trách</th>
				<th width="5%" align="center">Bậc</th>
				<th width="5%" align="center">Lương</th>
				<th width="5%" align="center">User</th>
				<th width="5%" align="center">Password</th>
				<th width="5%" align="center">Email</th>
			</tr>
			<tr class="" index="1">
				<td class="m">
					<input id="number_step_1" type="hidden" name="number_step_1" value="0">
					<input id="max_step_order_1" type="hidden" value="0">
					<a class="m-c" onclick="add_more_step(this);" href="javascript:void(0)"><strong>(+) </strong></a>
					<input class="m" type="text" name="pname_1" placeholder="Tên giai đoạn">
				</td>
				<td align="center">
					<select>
						<option>Chức vụ</option>
						<?php
						if (isset($orgLevel) && !empty($orgLevel)) {
							foreach ($orgLevel as $l => $o) {
								print '<option value="'. $l .'">'. $o .'</option>';
							}
						}
						?>
					</select>
				</td>
				<td>
					<input type="text" name="" placeholder="Người phụ trách">
				</td>
				<td>
					<input type="text" name="" placeholder="Bậc">
				</td>
				<td>
					<input type="text" name="" placeholder="Lương">
				</td>
				<td>
					<input type="text" name="" placeholder="Username">
				</td>
				<td>
					<input type="text" name="" placeholder="Password">
				</td>
				<td>
					<input type="text" name="" placeholder="Email">
				</td>
			</tr>

			<!-- MODAL
			<tr class="phase_modal" index="[index]">
				<td colspan="4">
					<table class="sub-table" width="100%" border="0">
						<tr>
							<td width="35%" style="padding-left: 0px;"><input type="hidden"
								id="max_step_order_[index]" value="0"> <input type="hidden"
								id="number_step_[index]" name="number_step_[index]" value="0"> <input
								type="hidden" id="exist_phase_[index]"
								name="exist_phase_[index]" value="0"> <input type="text"
								name="pname_[index]" placeholder="Tên giai đoạn"
								style="width: 97%;"><br> <a onclick="add_more_step(this);"
								style="margin-top: 3px;" href="javascript:void(0)"><strong>(+)</strong>
							</a> Bước</td>
							<td width="10%" align="center"><input type="text"
								name="porder_[index]" value="[next_phase_order]"
								placeholder="Thứ tự"></td>
							<td width="25%"><input type="file" name="pattach_[index][]"
								multiple="multiple"></td>
							<td><textarea name="pdescription_[index]"
									style="border: 1px solid #D8D8D8; height: auto;"></textarea></td>
						</tr>
					</table></td>
			</tr>

			<tr class="step_modal" index="[sindex]">
				<td align="right"><input type="hidden"
					id="exist_step_[sindex]_[num]" name="exist_step_[sindex]_[num]"
					value="0"> <input type="text" name="sname_[sindex]_[num]"
					placeholder="Tên bước" style="width: 85%;"></td>
				<td align="center"><input type="text" name="sorder_[sindex]_[num]"
					value="[next_step_order]" placeholder="Thứ tự"></td>
				<td><input type="file" name="sattach_[sindex]_[num][]"
					multiple="multiple"></td>
				<td><textarea name="sdescription_[sindex]_[num]"
						style="border: 1px solid #D8D8D8; height: auto;"></textarea></td>
			</tr>
			<!-- MODAL -->

			<tr class="action">
				<td colspan="4" align="center">
					<button value="submit" name="submit" style="cursor: pointer;">Thêm
						mới</button></td>
			</tr>
		</table>
	</div>
</div>
