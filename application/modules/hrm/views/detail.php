<?php
$month_p = $this->input->post('m');
$year_p = $this->input->post('y');
?>
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/fancybox/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/public/template/iso/js/fancybox/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/public/template/iso/js/facility.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/public/template/iso/js/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<div class="pro-info wrap-main">
   <!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>

   <!-- MENU FUNCTION -->
   <?php $tmp = Box::boxFuncI();
   print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

   <input type="hidden" id="month" name="month" value="<?php print $month; ?>">
   <input type="hidden" id="year" name="year" value="<?php print $year; ?>">
   <input type="hidden" name="redirect" value="<?php print $_SERVER['REQUEST_URI']; ?>">
   <div style="margin: 10px 0px;" class="sel-box-wrap">
      <form method="post" action="/hrm/employee/detail/<?php echo $this->uri->segment(4) ?>">
         <table width="60%" cellspacing="5" cellpadding="5">
            <tbody><tr>
                  <td width="120">
                     <b>Tháng</b>
                     <select name="m" class="sel-box">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                           if ($i == $month) {
                              echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
                           } else {
                              echo '<option value="' . $i . '">' . $i . '</option>';
                           }
                        }
                        ?>
                     </select>
                  </td>
                  <td width="120">
                     <b>Năm</b>
                     <select name="y" class="sel-box">
                        <?php
                        for ($i = 2003; $i <= 2030; $i++) {
                           if ($i == $year) {
                              echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
                           } else {
                              echo '<option value="' . $i . '">' . $i . '</option>';
                           }
                        }
                        ?>
                     </select>
                  </td>
                  <td>
                     <input type="submit" style="padding: 0px 10px;" value="Chọn">
                  </td>
               </tr>
            </tbody></table>
      </form>
   </div>
   
   <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
      <tbody><tr>
            <td colspan="10" class="box-message">
               <a onclick="show_degree(this)" rel="true" id="a_degree" href="javascript:void(0)"><img src="/public/template/iso/images/c.png" id="img_degree"></a>
               <a class="p-name">Hồ sơ</a>
            </td>
         </tr>
      </tbody>
   </table>
   <table id="show_degree" class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
      <tr class="title">
         <th width="4%" class="stt">STT</th>
         <th align="left">Tên hồ sơ</th>
         <th align="left" width="20%">Tên nhân viên</th>
         <th width="10%">Ngày tạo</th>
         <th width="10%">Tải về</th>

      </tr>
      <?php
      $stt = 0;
      if (isset($degree) && is_array($degree) && count($degree) > 0) {
         foreach ($degree as $row) {
            $stt++;
            $id = $row->id;
            $title = $row->name;
            $name = $row->employee;
            $request = isset($_GET['name']) ? '/?name=' . $_GET['name'] : '';
            $linkEdit = base_url() . 'hrm/employeeDegree/edit/' . $id . $request;
            $date = $row->created;
            if (is_file('./public/uploads/' . $row->file_attachment)) {
               $down = base_url() . 'public/uploads/' . $row->file_attachment;
               $ok_down = 1;
            } else {
               $ok_down = 0;
            }
            ?>
            <tr id="ms">
               <td><b><?php print $stt; ?></b></td>
               <td align="left">
                  <span><?= $title ?></span>
               </td>
               <td align="left">
                  <?php print $row->employee; ?>
               </td>
               <td align="center"><?php print date(FORMAT_DATE, $row->created); ?></td>
               <td align="center">
                  <?php if ($ok_down == 1) { ?>
                     <a href="<?php print $down; ?>">
                        <img alt="" src="<?php print base_url() . 'public/template/iso/images/download.png'; ?>">
                     </a> 
                  <?php } else { ?>
                     <a href="javascript:void(0)" onclick="alert('File không tồn tại.Vui lòng upload lại file!')">
                        <img alt="" src="<?php print base_url() . 'public/template/iso/images/download.png'; ?>">
                     </a> 
                  <?php } ?>
               </td>
            </tr>
            <?php
         }
      }
      ?>
   </table>
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
   <table  width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
      <tr>
         <td>
            <a href="javascript:void(0)" id="a_info" rel="true" onclick="show_info()"><img id="img_info" src="<?php echo base_url() ?>public/template/iso/images/c.png" /></a>
            <a class="p-name">Thông tin chung</a>
         </td>
      </tr>
   </table>
   <div id="md03">
      <div class="content" id="show_info">
         <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="change_job" name="change_job" value="0">
            <input type="hidden" id="current_position" value="<?php print $query->position_id; ?>">
            <input type="hidden" id="current_department" value="<?php print $query->department_id; ?>">
            <input type="hidden" name="uid" value="<?php print $query->uid; ?>">
            <input type="hidden" name="id" value="<?php echo $query->id ?>"/>
            <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
               <tr height="30" style="color:#000;">
                  <?php if ($uid == 1) { ?>
                     <td width="40%"><input type="text" name="username" placeholder="Tên đăng nhập" value="<?= $query->name ?>" /></td>
                  <?php } else { ?>
                     <td width="40%"><input type="text" name="username" placeholder="Tên đăng nhập" value="<?= $query->name ?>" disabled="disabled" /></td>
                  <?php } ?>
                  <td align="30%"><input type="text" name="input[fullname]" placeholder="Tên đầy đủ của nhân viên" value="<?= $query->fullname ?>" /></td>
                  <td width="30%"><input type="text" name="input[email]" placeholder="Địa chỉ email" value="<?= $query->email ?>" /></td>
               </tr>
               <tr height="30" style="color:#000;">
                  <td width="40%"><input type="text" name="input[hometown]" placeholder="Quê quán" value="<?= $query->hometown ?>" /></td>
                  <td align="30%"><input type="text" name="input[mobile]" placeholder="Số điện thoại di động" value="<?= $query->mobile ?>" /></td>
                  <td width="30%"><input type="text" name="input[phone]" placeholder="Số điện thoại bàn" value="<?= $query->phone ?>" /></td>
               </tr>
               <tr height="30" style="color:#000;">
                  <td width="40%"><input type="text" name="input[fax]" placeholder="Số fax" value="<?= $query->fax ?>" /></td>
                  <td align="30%"><input type="text" name="input[yahoo]" placeholder="Yahoo" value="<?= $query->yahoo ?>" /></td>
                  <td width="30%"><input type="text" name="input[skype]" placeholder="Skype" value="<?= $query->skype ?>" /></td>
               </tr>
               <tr height="30" style="color:#000;">
                  <td width="40%"><input type="text" name="input[website]" placeholder="website" value="<?= $query->website ?>" /></td>
                  <td align="30%"><input type="text" name="input[google]" placeholder="Google+" value="<?= $query->google ?>" /></td>
                  <td width="30%">
                     <?php
                     $select = '
								<select name="input[sex]" id="sex">
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
                        if (!empty($allDepart)) {
                           foreach ($allDepart as $de) {
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
                     <input style="width: 260px;" type="password" name="password" placeholder="Mật khẩu đăng nhập" value="<?= $query->password ?>" disabled="disabled" id="password"/>
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
                     <input type="text" name="input[salary]" placeholder="Mức lương" value="<?= $query->salary ?>" style="width: 150px;"/>
                     <b><font color="gray">(VNĐ)</font></b>
                  </td>
               </tr>
               <tr height="30" style="color:#000;">
                  <td width="100%" colspan="3">
                     <strong>Mô tả kinh nghiệm làm việc:</strong>
                  </td>
               </tr>
               <tr height="30" style="color:#000;">
                  <td width="100%" colspan="3">
                     <textarea name="input[work_experience]"><?= $query->work_experience ?></textarea>
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

<script type="text/javascript">
   function change_time_work(obj) {   
      $('#'+employ+'-salary').formatNumber({format:"#,###", locale:"vn"});
        
   }
   function show_salary(obj){
      $('#show_salary').toggle();
      var val1 = $('#a_salary').attr('rel');
      if(val1 == 'true'){
         $('#icon_salary').attr('src','/public/template/iso/images/o.png');
         $('#a_salary').attr('rel','false');
      }else{
         $('#icon_salary').attr('src','/public/template/iso/images/c.png');
         $('#a_salary').attr('rel','true');
      }
   }
   function show_kpi(obj){
      $('#show_kpi').toggle();
      var val1 = $('#a_kpi').attr('rel');
      if(val1 == 'true'){
         $('#img_kpi').attr('src','/public/template/iso/images/o.png');
         $('#a_kpi').attr('rel','false');
      }else{
         $('#img_kpi').attr('src','/public/template/iso/images/c.png');
         $('#a_kpi').attr('rel','true');
      }
   }
   function show_degree(obj){
      $('#show_degree').toggle();
      var val1 = $('#a_degree').attr('rel');
      if(val1 == 'true'){
         $('#img_degree').attr('src','/public/template/iso/images/o.png');
         $('#a_degree').attr('rel','false');
      }else{
         $('#img_degree').attr('src','/public/template/iso/images/c.png');
         $('#a_degree').attr('rel','true');
      }
   }
   function show_info(obj){
      $('#show_info').toggle();
      var val1 = $('#a_info').attr('rel');
      if(val1 == 'true'){
         $('#img_info').attr('src','/public/template/iso/images/o.png');
         $('#a_info').attr('rel','false');
      }else{
         $('#img_info').attr('src','/public/template/iso/images/c.png');
         $('#a_info').attr('rel','true');
      }
   }
</script>


<script language="javascript">
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
   $(".fancybox_kpi").fancybox({
      'showNavArrows' : false,
      type:'ajax',
      ajax : {
         type : "GET",
         data : 'mydata=edit'
      }
   }); 
</script>







