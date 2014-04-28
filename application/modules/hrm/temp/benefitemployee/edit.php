<script type="text/javascript"
	src="<?php print base_url() . 'public/template/iso/js/jshashtable-3.0.js' ?>"></script>
<script
	type="text/javascript"
	src="<?php print base_url() . 'public/template/iso/js/jquery.numberformatter-1.2.3.js' ?>"></script>
<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation">
		<ul>
		<?php print navigation($navi); ?>
		</ul>
	</div>

	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI();
	print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	<div>
	<?php
	if ($this->session->flashdata('error')):
	echo '<div id="display_error">
					  ' . $this->session->flashdata('error') . '
				  </div>';
	endif;
	if ($this->session->flashdata('success')):
	echo '<div id="success">
					  ' . $this->session->flashdata('success') . '
				  </div>';
	endif;
	?>
		<div id="md03">
			<div class="content">
				<form
					action="<?php print base_url() . 'hrm/benefitemployee/submit_update'; ?>"
					method="post" enctype="multipart/form-data" id="formAction">
					<input type="hidden" name="action" value="update_benefit"> <input
						type="hidden" name="list_benefit" value="<?php print $listId; ?>">
					<input type="hidden" name="uid" value="<?php print $uid; ?>"> <input
						type="hidden" name="emid" value="<?php echo $userInfo['id']?>" />
					<table width="80%" border="0" cellspacing="1" cellpadding="5"
						id="table" bgcolor="">
						<tr height="30" style="color: #000;">
							<td width="80%" colspan="3"><strong>Thông tin nhân viên</strong>
							</td>
						</tr>
						<tr height="30" style="color: #000;">
							<td width="40%"><font color="gray">Công ty:</font> <b
								style="color: #0e3c69;"><?php print $userInfo['company_name']; ?>
							</b>
							</td>
							<td align="30%"><font color="gray">Phòng ban:</font> <b
								style="color: #0e3c69;"><?php print $userInfo['depart_name']; ?>
							</b>
							</td>
							<td align="30%"><font color="gray">Chức vụ:</font> <b
								style="color: #0e3c69;"><?php print $userInfo['position_name']; ?>
							</b>
							</td>
						</tr>
						<tr height="30" style="color: #000;">
							<td width="100%" colspan="3"><strong>Thông số định mức</strong>
							</td>
						</tr>
						<tr height="30" style="color: #000;">
							<td width="100%" colspan="3"><select style="width: 40%"
								onclick="loadGroup(this);" name="group_id">
									<option value="0">Chọn nhóm định mức</option>
									<?php
									if (!empty($allGroupBenefit)) {
										foreach ($allGroupBenefit as $gb) {
											print '<option value="'.$gb['id'].'">'.$gb['name'].'</option>';
										}
									}
									?>
							</select>
							</td>
						</tr>
						<tr><td colspan="3" height="15"></td></tr>
						<tr>
							<td colspan="3"><a onclick="add_benefit()"
								style="cursor: pointer"><b>[+] Thêm định mức</b></a></td>
						</tr>
						
						<tr id="flag"></tr>
						<?php
						if (!empty($userBenefit)) {
							foreach ($userBenefit as $pBen) {
								?>
								<tr height="30" style="color: #000;">
									<td width="40%"><?php print $pBen['name']; ?>
									</td>
									<td width="20%">
										<input type="text" style="text-align: right;"
										class="jformat" name="limitation-<?php print $pBen['id']; ?>"
										value="<?php print $pBen['limitation']; ?>" />
									</td>
									<td width="15%" align="center"><?php
									if (!empty($unit)) {
										foreach ($unit as $u) {
											if ($u->id == $pBen['unit']) {
												print $u->unit;
											}
										}
									}
									?>
									</td>
									<td><input type="checkbox" onclick="active_benefit(this)"
										rel="<?php echo $pBen['active']?>"
										id="<?php print $pBen['id']; ?>"
										<?php print ($pBen['active'] == 1) ? 'checked="checked"' : ''; ?>>
									</td>
								</tr>
								<?php
							}
						} else {
							print '<tr><td colspan="4">Chưa thiết lập định mức cho vị trí này. <a target="_blank" href="' . base_url() . 'hrm/humanbenefit/add?com=' . $userInfo['company_id'] . '&dep=' . $userInfo['department_id'] . '&pos=' . $userInfo['position_id'] . '">Cập nhật?</a></td></tr>';
						}
						if (isset($benefit)) {
							$str_benefit = '<select name=benefit_new[]><option> Chọn định mức </option>';
							foreach ($benefit as $key => $value) {
								$str_benefit .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
							}
							$str_benefit .= '</select>';
						}
						if (isset($unit)) {
							$str_unit = '<select name=unit_new[]><option> Chọn đơn vị </option>';
							foreach ($unit as $key => $value) {
								$str_unit .= '<option value="' . $value->id . '">' . $value->unit . '</option>';
							}
							$str_unit .= '</select>';
						}
						?>
						<input id="str_benefit" type="hidden" name=""
							value="<?php echo htmlspecialchars($str_benefit) ?>" />
						<input id="str_unit" type="hidden" name=""
							value="<?php echo htmlspecialchars($str_unit) ?>" />
						<tr>
							<td colspan="3">
								<table id="table" width="100%" class="benefit_add"></table>
							</td>
						</tr>
						<tr height="50" style="color: #000; text-align: left;">
							<td width="100%" colspan="3" align="center">
								<button type="submit" name="submit" value="submit">Cập nhật</button>
							</td>
						</tr>
					</table>
					
				</form>
			</div>
			<div class="footer"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
    var doing = false;
    $("#cid").change(function(){
        if (doing) return;
        doing = true;
        $.post("/hrm/company/location",
        {id: $("#cid").val()},
        function(data) {
            data = "<option value = '0' selected='selected'>Quận/Huyện</option>"+data;
            $("#did").html(data);
            $("#did").val(0);
            doing = false;
        }
    );
    });

    function active_benefit(obj) {
        var id = parseInt($(obj).attr('id'));
        var active = $(obj).attr('rel');
        if (id > 0) {
            $.ajax({
                type: 'POST',
                url: '/hrm/benefitemployee/submit_active',
                data: {
                    id: id,
                    active:active
                },
                success: function(data) {
                    alert('Cập nhật thành công');
                }
            });
        }
    }
    
    function add_benefit(){
        var html = '';
        var str_benefit = $("#str_benefit").val();
        var str_unit = $('#str_unit').val();
        html += '<tr>'+
              '<td width="40%">'+str_benefit+'</td>'+
              '<td width="20%"><input type="text" name="number_new[]" style="text-align: right;" /></td>'+
              '<td width="15%" align="center">'+str_unit+'</td>';
          html +='</tr>';
          $('#flag').after(html);
    }
	
	function loadGroup(obj) {
		var groupId = parseInt($(obj).val());
		if (groupId > 0) {
			$.ajax({
				type: 'POST',
				url: '/hrm/groupbenefit/loadGroup/'+groupId,
				data: {
					groupId: groupId
				},
				success: function(html) {
					$('.group_benefit').remove();
					$('#flag').after(html);
				}
			});
		} else {
			$('.group_benefit').remove();
		}
	}
</script>



