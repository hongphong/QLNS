<script type="text/javascript"> $(function() { $( ".datepicker" ).datepicker({ dateFormat: <?php print FORMAT_DATE; ?> }); }); </script>

<div class="pro-info wrap-main">
   <!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>

    <?php $tmp = Box::boxFuncI();
    print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
    <div>
        <?php
        if (isset($messages) && count($messages) > 0 && is_array($messages)):
            foreach ($messages as $index => $row):
                echo '<div id="display_error">
						  ' . $row . '
					  </div>';
            endforeach;
        endif;
        ?>
        <div id="md03">
            <div class="head">
                Thông tin chung:
            </div>
            <div class="content">
                <p style="padding-bottom:5px;">
                    <strong style="color:#f00;">(+)</strong> Tên tài khoản đăng nhập không được trùng nhau.
                </p>
                <p style="padding-bottom:5px;">
                    <strong style="color:#f00;">(+)</strong> Tên tài khoản đăng nhập phải là chữ viết liền không dấu.
                </p>
                <p style="padding-bottom:5px;">
                    <strong style="color:#f00;">(+)</strong> Tên tài khoản đăng nhập không được có ký tự lạ (khoảng trắng, -, v..v..).
                </p>
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="formAction">
                    <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                                <input class="validate[required]" type="text" name="name" placeholder="Tên đăng nhập" value="<?= isset($data) ? $data['name'] : ''; ?>"/>
                            </td>
                            <td align="30%"><input type="text" name="input[fullname]" placeholder="Tên đầy đủ của nhân viên" value="<?= isset($data) ? $data['fullname'] : ''; ?>" /></td>
                            <td width="30%"><input type="text" name="input[email]" placeholder="Địa chỉ email" value="<?= isset($data) ? $data['email'] : ''; ?>" /></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <!-- <td width="40%"><input type="text" name="input[hometown]" placeholder="Quê quán" value="<?= isset($data) ? $data['hometown'] : ''; ?>" /></td> -->
                            <td align="40%"><input type="text" name="input[mobile]" placeholder="Số điện thoại di động" value="<?= isset($data) ? $data['mobile'] : ''; ?>" /></td>
                            <td width="30%"><input type="text" name="input[phone]" placeholder="Số điện thoại bàn" value="<?= isset($data) ? $data['phone'] : ''; ?>" /></td>
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
                            <td width="40%"><input type="text" name="input[hometown]" placeholder="Quê quán" value="<?= isset($data) ? $data['hometown'] : ''; ?>" /></td>
                            <td align="30%"><input type="text" name="input[mobile]" placeholder="Số điện thoại di động" value="<?= isset($data) ? $data['mobile'] : ''; ?>" /></td>
                            <td width="30%"><input type="text" name="input[phone]" placeholder="Số điện thoại bàn" value="<?= isset($data) ? $data['phone'] : ''; ?>" /></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%"><input type="text" name="input[fax]" placeholder="Số fax" value="<?= isset($data) ? $data['fax'] : ''; ?>" /></td>
                            <td align="30%"><input type="text" name="input[yahoo]" placeholder="Yahoo" value="<?= isset($data) ? $data['yahoo'] : ''; ?>" /></td>
                            <td width="30%"><input type="text" name="input[skype]" placeholder="Skype" value="<?= isset($data) ? $data['skype'] : ''; ?>" /></td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%"><input type="text" name="input[website]" placeholder="website" value="<?= isset($data) ? $data['website'] : ''; ?>" /></td>
                            <td align="30%"><input type="text" name="input[google]" placeholder="Google+" value="<?= isset($data) ? $data['google'] : ''; ?>" /></td>
                            <td width="30%">
                                <?php
                                $select = '
											<select name="input[sex]" id="sex">
												<option value="0">Giới tính nam</option>
												<option value="1">Giới tính nữ</option>
												<option value="2">Giới tính khác</option>
											</select>';
                                print $select;
                                ?>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="40%">
                                <select style="width: 30% !important;" name="input[birth_day]" id="birth_day" class="validate[required] ss">
                                    <option value="0" style="text-align: center;">Ngày sinh</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        $sel = '';
                                        if (isset($data['birth_day'])) {
                                            if ($data['birth_day'] == $i) {
                                                $sel = 'selected="selected"';
                                            }
                                        }
                                        print '<option class="so" ' . $sel . ' value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select style="width: 30% !important;" name="input[birth_month]" id="birth_month" class="ss">
                                    <option value="0" style="text-align: center;">Tháng sinh</option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        $sel = '';
                                        if (isset($data['birth_month'])) {
                                            if ($data['birth_month'] == $i) {
                                                $sel = 'selected="selected"';
                                            }
                                        }
                                        print '<option class="so" ' . $sel . ' value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select style="width: 31% !important;" name="input[birth_year]" id="birth_year" class="ss">
                                    <option value="0" style="text-align: center;">Năm sinh</option>
                                    <?php
                                    $year_current = date("Y");
                                    for ($i = $year_current; $i >= 1950; $i--) {
                                        $sel = '';
                                        if (isset($data['birth_year'])) {
                                            if ($data['birth_year'] == $i) {
                                                $sel = 'selected="selected"';
                                            }
                                        }
                                        echo '<option class="so" ' . $sel . ' value="' . $i . '">' . $i . '</option>';
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
                                    if (isset($company) && count($company) > 0 && is_array($company)) {
                                        foreach ($company as $row) {
                                            $sel = '';
                                            if (isset($data['company_id']) && $data['company_id'] > 0) {
                                                if ($row->id == $data['company_id']) {
                                                    $sel = 'selected="selected"';
                                                }
                                            }
                                            print '<option value="' . $row->id . '" ' . $sel . '>' . $row->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td align="30%">
                                <select name="input[department_id]" id="department">
                                    <option value="0">Trực thuộc phòng ban</option>
                                </select>
                            </td>
                            <td width="30%">
                                <select name="input[position_id]" id="position">
                                    <option value="0">Chức vụ</option>
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
                                <input type="password" name="password" placeholder="Mật khẩu đăng nhập" value="<?php print (isset($password)) ? $password : ''; ?>" />	
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
                            <td width="40%">
                                <input type="text" name="input[salary]" placeholder="Mức lương" value="<?= isset($data) ? $data['salary'] : ''; ?>" />	
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <strong>Quá trình học tập và công tác:</strong>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <textarea name="input[work_experience]"><?= isset($data) ? $data['work_experience'] : ''; ?></textarea>
                            </td>
                        </tr> 
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <strong>Mô tả công việc:</strong>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td width="100%" colspan="3">
                                <textarea style="height: 150px;" name="input[job_description]"></textarea>
                            </td>
                        </tr>
                        <tr height="50" style="color:#000; text-align:center;">
                            <td width="100%" colspan="3">
                                <button name="submit" value="submit">Thêm mới</button>
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

    $(document).ready(function() {
        var company_id = '<?php print (isset($data['company_id'])) ? $data['company_id'] : 0; ?>';
        if (company_id > 0) {
            load_department(company_id);
        }
    });
	
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
        var company_id = $("#company").val();
        load_department(company_id);
	
    });

    $("#department").change(function(){
        if (doing)
            return;
        doing=true;
        var department = $('#department').val();			
        load_position(department);
    });

    function load_department(company_id) {
        $.post("/setting/position/location", 
        {id: company_id},
        function(data){ 
            data = "<option value='0'>Trực thuộc phòng ban</option>"+data;
            $("#department").html(data);
            doing=false;
        }
    );
    }
    function load_position(department_id) {
        $.post("/hrm/employee/location",
        {id: department_id},
        function(data) {
            data = "<option value='0'>Chức vụ</option>"+data;
            $("#position").html(data);
            doing=false;
        }
    	);
    }
</script>




