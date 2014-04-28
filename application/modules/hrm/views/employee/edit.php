<div class="pro-info wrap-main">
   <!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
   
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
        <script type="text/javascript"> 
            $(document).ready(function() {
                $("#company option[value='<?php echo $query->company_id ?>']").attr('selected', 'selected');
                $("#department option[value='<?php echo $query->department_id ?>']").attr('selected', 'selected');
                $("#position option[value='<?php echo $query->position_id ?>']").attr('selected', 'selected');
                $("#isactive option[value='<?php echo $query->status ?>']").attr('selected', 'selected');
                $("#sex option[value='<?php echo $query->sex ?>']").attr('selected', 'selected');
                $("#birth_day option[value='<?php echo $query->birth_day ?>']").attr('selected', 'selected');
                $("#birth_month option[value='<?php echo $query->birth_month ?>']").attr('selected', 'selected');
                $("#birth_year option[value='<?php echo $query->birth_year ?>']").attr('selected', 'selected');
                $(".changepass").click(function() {
                    document.getElementById('password').disabled = false;
                });
            });
        </script>
        <div id="md03">
            <div class="head">
                Thông tin chung
            </div>
            <div class="content">
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="change_job" name="change_job" value="0">
                    <input type="hidden" id="current_position" value="<?php print $query->position_id; ?>">
                    <input type="hidden" id="current_department" value="<?php print $query->department_id; ?>">
                    <input type="hidden" name="uid" value="<?php print $query->uid; ?>">
                    <input type="hidden" name="id" value="<?php echo $query->id ?>"/>
                    <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                        <tr height="30" style="color:#000;">
                            <?php  if ($uid == 1) { ?>
                                <td width="40%"><input type="text" name="username" title="Tên đăng nhập" placeholder="Tên đăng nhập" value="<?= $query->name ?>" /></td>
                            <?php } else { ?>
                                <td width="40%"><input type="text" name="username" title="Tên đăng nhập" placeholder="Tên đăng nhập" value="<?= $query->name ?>" disabled="disabled" /></td>
                            <?php } ?>
                            <td align="30%"><input type="text" name="input[fullname]" title="Tên đầy đủ của nhân viên" placeholder="Tên đầy đủ của nhân viên" value="<?= $query->fullname ?>" /></td>
                            <td width="30%"><input type="text" name="input[email]" title="Địa chỉ email" placeholder="Địa chỉ email" value="<?= $query->email ?>" /></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <!-- <td width="40%"><input type="text" name="input[hometown]" title="Quê quán" placeholder="Quê quán" value="<?= $query->hometown ?>" /></td> -->
                            <td align="40%"><input type="text" name="input[mobile]" title="Số điện thoại di động" placeholder="Số điện thoại di động" value="<?= $query->mobile ?>" /></td>
                            <td width="30%"><input type="text" name="input[phone]" title="Số điện thoại bàn" placeholder="Số điện thoại bàn" value="<?= $query->phone ?>" /></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%"><input type="text" name="input[current_place]" title="Nơi ở hiện tại" placeholder="Nơi ở hiện tại" value="<?= isset($query->current_place) ? $query->current_place : ''; ?>" /></td>
                            <td align="30%"><input type="text" name="input[cmnd]" title="Số chứng minh nhân dân" placeholder="Số chứng minh nhân dân" value="<?= isset($query->cmnd) ? $query->cmnd : ''; ?>" /></td>
                            <td width="30%">
                            	<input type="text" name="input[cmnd_create]" style="width: 35%;" title="Ngày cấp CMND" placeholder="Ngày cấp CMND" value="<?= isset($query->cmnd_create) ? $query->cmnd_create : ''; ?>" />
                            	<input type="text" name="input[cmnd_location]" style="width: 50%;" title="Nơi cấp CMND" placeholder="Nơi cấp CMND" value="<?= isset($query->cmnd_location) ? $query->cmnd_location : ''; ?>" />
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                            	<input type="text" name="input[root_place]" title="Hộ khẩu thường trú" placeholder="Hộ khẩu thường trú" value="<?= isset($query->root_place) ? $query->root_place : ''; ?>" />
                            </td>
                            <td align="30%">
                            	<select title="Tình trạng hôn nhân" name="input[married]">
                            		<option value="0">Tình trạng hôn nhân</option>
                            		<option <?php print (isset($query) && $query->married == 1) ? 'selected="selected"' : ''; ?> value="1">Chưa có gia đình</option>
                            		<option <?php print (isset($query) && $query->married == 2) ? 'selected="selected"' : ''; ?> value="2">Đã có gia đình</option>
                            	</select>
                            </td>
                            <td width="30%">
                            	<input type="text" style="width: 55%;margin-right: 5px;" name="input[married_name]" title="Họ tên vợ (chồng)" placeholder="Họ tên vợ (chồng)" value="<?= isset($query->married_name) ? $query->married_name : ''; ?>" />
                            	<input type="text" style="width: 30%;" name="input[married_age]" title="Tuổi vợ (chồng)" placeholder="Tuổi vợ (chồng)" value="<?= isset($query->married_age) ? $query->married_age : ''; ?>" />
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                            	<a id="addChild" href="javascript:void(0)" onclick="addChild(this)">(+) Con</a>
                            	<?php 
                            	if (isset($query->child_name) && ($query->child_name != '')) {
                            		$listChildName = explode('|', $query->child_name);
                            		$listChildAge = explode('|', $query->child_age);
                            		foreach ($listChildName as $key => $cn) {
                            			print '<div class="child-block">';
                            			print '<input type="text" class="child_name" value="'.$cn.'" name="child_name[]" title="Họ và tên con" placeholder="Họ và tên con" style="margin-bottom: 3px; width: 50%;margin-right: 5px;">';
                            			print '<input type="text" class="child_age" value="'.$listChildAge[$key].'" name="child_age[]" title="Tuổi của con" placeholder="Tuổi của con" style="margin-bottom: 3px; width: 20%;">';
                            			print '</div>';
                            		}
                            	} else {
                            		print '<div class="child-block">';
                            		print '<input type="text" class="child_name" name="child_name[]" title="Họ và tên con" placeholder="Họ và tên con" style="margin-bottom: 3px; width: 50%;margin-right: 5px;">';
                            		print '<input type="text" class="child_age" name="child_age[]" title="Tuổi của con" placeholder="Tuổi của con" style="margin-bottom: 3px; width: 20%;">';
                            		print '</div>';
                            	}
                            	?>
                            </td>
                            <td align="30%">
                            	<?php 
                            	$dateStartWork = DATE_FORMAT;
                            	if (isset($query->date_start_work) && $query->date_start_work > 0) {
                            		$dateStartWork = date(FORMAT_DATE, $query->date_start_work);
                            	}
                            	?>
                            	<label>Ngày bắt đầu làm việc: </label><input type="text" name="date_start_work" value="<?php print $dateStartWork; ?>" class="f_control datepicker" style="width: 80px;" placeholder="<?php print DATE_FORMAT; ?>">
                            </td>
                            <td width="30%"></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%"><input type="text" name="input[fax]" title="Số fax" placeholder="Số fax" value="<?= $query->fax ?>" /></td>
                            <td align="30%"><input type="text" name="input[yahoo]" title="Nick Yahoo" placeholder="Yahoo" value="<?= $query->yahoo ?>" /></td>
                            <td width="30%"><input type="text" name="input[skype]" title="Nick Skype" placeholder="Skype" value="<?= $query->skype ?>" /></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%"><input type="text" name="input[website]" title="website" placeholder="website" value="<?= $query->website ?>" /></td>
                            <td align="30%"><input type="text" name="input[google]" title="Google+" placeholder="Google+" value="<?= $query->google ?>" /></td>
                            <td width="30%">
                                <?php
                                $select = '
											<select title="Giới tính" name="input[sex]" id="sex">
												<option value="0">Giới tính nam</option>
												<option value="1">Giới tính nữ</option>
												<option value="2">Giới tính khác</option>
											</select>';
                                echo $select;
                                ?>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                                <b>Ngày sinh: </b>
                                <select name="input[birth_day]" id="birth_day" class="ss">
                                    <option value="0">Ngày sinh</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo '<option class="so" value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select name="input[birth_month]" id="birth_month" class="ss">
                                    <option value="0">Tháng sinh</option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<option class="so" value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select name="input[birth_year]" id="birth_year" class="ss">
                                    <option value="0">Năm sinh</option>
                                    <?php
                                    $year_current = date("Y");
                                    for ($i = $year_current; $i >= 1950; $i--) {
                                        echo '<option class="so" value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td align="30%"></td>
                            <td width="30%"></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                                <select name="input[company_id]" id="company" class="validate[required]">
                                    <option value="0">Trực thuộc công ty</option>
                                    <?php
                                    if (isset($company) && count($company) > 0 && is_array($company)):
                                        foreach ($company as $row):
                                            echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                        endforeach;
                                    endif;
                                    ?>
                                </select>	 	
                            </td>
                            <td align="30%">
                                <select name="input[department_id]" id="department">
                                    <option value="0">Trực thuộc phòng ban</option>
                                    <?php
                                    if (!empty($depart)) {
                                        foreach ($depart as $de) {
                                            print '<option value="' . $de['id'] . '">' . $de['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>	
                            </td>
                            <td width="30%">
                                <select name="input[position_id]" id="position">
                                    <option value="0">Chức vụ</option>
                                    <?php
                                    if (isset($position) && count($position) > 0 && is_array($position)):
                                        foreach ($position as $row):
                                            echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <strong>Mật khẩu:</strong>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                                <input style="width: 260px;" type="password" title="Mật khẩu đăng nhập" name="password" placeholder="Mật khẩu đăng nhập" value="<?php print $query->password; ?>" disabled="disabled" id="password"/>
                                <a href="javascript:;" class="changepass"><strong>Sửa mật khẩu</strong></a>	
                            </td>
                            <td align="30%">
                                <?php
                                $select = '
								<select name="input[status]" id="isactive">
									<option value="0">Chưa active</option>
									<option value="1">Đã active</option>
									<option value="2">Đã block</option>
								</select>';
                                echo $select;
                                ?>
                            </td>
                            <td width="30%"></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <strong>Mức lương:</strong>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="42%">
                                <input type="text" name="input[salary]" title="Mức lương" placeholder="Mức lương" value="<?= $query->salary ?>" style="width: 150px;"/>
                                <b><font color="gray">(VNĐ)</font></b>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <strong>Quá trình học tập và công tác:</strong>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <textarea name="input[work_experience]"><?= $query->work_experience ?></textarea>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <strong>Mô tả công việc:</strong>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <textarea style="height: 150px;" name="input[job_description]"><?= $query->job_description; ?></textarea>
                            </td>
                        </tr>
                        <tr height="50" style="color:#000; text-align:center;">
                            <td width="100%" colspan="3">
                                <button name="submit" value="submit">Cập nhật</button>
                            </td>
                        </tr>  
                    </table>
                </form>	
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>

<script language="javascript">
	function addChild(obj) {
		var target = $('.child-block').last();
		var html = '';
		html = '<div class="child-block">';
		html += '<input type="text" class="child_name" name="child_name[]" placeholder="Họ và tên con" style="margin-bottom: 3px; width: 50%; margin-right: 5px;">';
		html += '<input type="text" class="child_age" name="child_age[]" title="Tuổi của con" placeholder="Tuổi của con" style="margin-bottom: 3px; width: 20%;">';
		html += '</div>';
		target.after(html);
	}

    var doing=false;
    $("#cid").change(function(){
        if (doing)
            return;
        doing=true;					
        //$("#loading_district").show();
        $.post("/hrm/company/location", 
        {id: $("#cid").val()}, 
        function(data){ 
            data = "<option value = '0' selected='selected'>Quận/Huyện</option>"+data;
            $("#did").html(data);
            $("#did").val(0);
            //$("#loading_district").hide();
            doing=false;
        }
    );
    });
	
    $("#company").change(function(){
        if (doing)
            return;
        doing=true;					
        //$("#loading_district").show();
        $.post("/hrm/position/location", 
        {id: $("#company").val()}, 
        function(data){ 
            data = "<option value = '' selected='selected'>Trực thuộc phòng ban</option>"+data;
            $("#department").html(data);
            $("#department").val(0);
            doing=false;
        }
    );
    });
	
    $("#department").change(function(){
        if (doing)
            return;
        doing=true;

        // Change job
        var current_department = parseInt($('#current_department').val());
        var new_department = parseInt($(this).val());
        if (new_department != current_department) {
            $('#change_job').val('1');
        } else {
            $('#change_job').val('0');
        }
		
        $.post("/hrm/employee/location", 
        {id: $("#department").val()}, 
        function(data){ 
            data = "<option value = '0' selected='selected'>Chức vụ</option>"+data;
            $("#position").html(data);
            $("#position").val(0);
            //$("#loading_district").hide();
            doing=false;
        }
    );
    });

    $('#position').change(function() {
        var current_position = parseInt($('#current_position').val());
        var new_position = parseInt($(this).val());
        if (new_position != current_position) {
            $('#change_job').val('1');
        } else {
            $('#change_job').val('0');
        }
    });
</script>





