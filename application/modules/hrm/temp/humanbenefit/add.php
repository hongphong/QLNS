<script type="text/javascript" src="<?php print base_url().''; ?>"></script>
<div class="pro-info wrap-main">
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
    
    <div>
    	<?php
		if($this->session->flashdata('error')):
		echo '<div id="display_error">
				  '. $this->session->flashdata('error') .'
			  </div>';
		endif;
		if($this->session->flashdata('success')):
		echo '<div id="success">
				  '. $this->session->flashdata('success') .'
			  </div>';
		endif;
		?>
    	<div id="md03">
            <div class="content">
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="formAction">
	            	<table width="80%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
	                	<tr height="30" style="color:#000;">
	                        <td width="100%" colspan="3">
	                        	<strong>Thông tin phòng ban - Chức vụ</strong>
	                        </td>
	                    </tr>
	                    <tr height="30" style="color:#000;">
	                        <td width="40%">
	                       		<select name="input[company_id]" id="company" class="validate[required]">
	                            	<option value="0">Trực thuộc công ty</option>
	                                <?php
									if (isset($company) && count($company) > 0 && is_array($company)) {
										foreach ($company as $row) {
											$sel = '';
											if (isset($_GET['com'])) {
												if ($_GET['com'] == $row->id) {
													$sel = 'selected="selected"';
												}
											}
											print '<option '. $sel .' value="'.$row->id.'">'.$row->name.'</option>';
										}
									}
									?>
								</select>
	                        </td>
	                        <td align="30%">
	                        	<select name="input[department_id]" id="department" class="validate[required]">
	                            	<option value="">Trực thuộc phòng ban</option>
	                            	<?php
	                            	$sel = 'selected="selected"';
	                            	if (!empty($eDepart)) {
	                            		foreach ($eDepart as $ed) {
	                            			$sel = '';
	                            			if (isset($_GET['dep'])) {
	                            				if ($_GET['dep'] == $ed['id']) {
	                            					$sel = 'selected="selected"';
	                            				}
	                            			}
	                            			print '<option '. $sel .' value="'.$ed['id'].'">'.$ed['name'].'</option>';
	                            		}
	                            	}
	                            	?>
								</select>		 	
	                        </td>
	                        <td align="30%">
	                        	<select name="input[position_id]" id="position" class="validate[required]">
	                            	<option value="">Chức vụ</option>
	                            	<?php
	                            	if (!empty($ePosition)) {
	                            		foreach ($ePosition as $ep) {
	                            			$sel = '';
	                            			if (isset($_GET['pos'])) {
	                            				if ($_GET['pos'] == $ep->id) {
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
						<tr height="30" style="color:#000;">
	                        <td width="100%" colspan="3">
	                        	<strong>Thông số định mức</strong>
	                        </td>
	                    </tr>
	                    <?php for($i=1; $i <= 10; $i++): ?>
						<tr height="30" style="color:#000;">
							 <td align="30%">
	                        	<select name="benefit_id[]" id="benefit">
	                            	<option value="">Quyền lợi</option>
	                                <?php
									if(isset($benefit) && count($benefit) > 0 && is_array($benefit)):
										foreach($benefit as $row):
											echo '<option id="ben-'. $row->id .'" value="'.$row->id.'">'.$row->name.'</option>';
										endforeach;
									endif;
									?>
								</select>
	                        </td>
	                        <td width="40%">
	                        	<input type="text" name="limitation[]" class="jformat" id="limitation" placeholder="Quyền lợi định mức tối đa"/>	 	
	                        </td>
	                        <td align="30%">
	                        	<select name="unit[]" id="unit" class="">
	                            	<option value="">Đơn vị tiền tệ</option>
	                                <?php
									if(isset($unit) && count($unit) > 0 && is_array($unit)):
										foreach($unit as $row):
											echo '<option value="'.$row->id.'">'.$row->unit.'</option>';
										endforeach;
									endif;
	                                ?>
								</select>
	                        </td>
	                    </tr>
	                    <?php endfor; ?>
	                    <tr height="50" style="color:#000; text-align:left;">
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
	var doing = false;
	$("#cid").change(function(){
		if (doing)
			return;
		doing=true;
		$.post("/hrm/company/location", 
			{id: $("#cid").val()}, 
			function(data){ 
				data = "<option value = '0' selected='selected'>Quận/Huyện</option>"+data;
				$("#did").html(data);
				$("#did").val(0);
				doing=false;
			}
		);
	});
	
	$("#company").change(function(){
		if (doing)
			return;
		doing=true;
		$.post("/setting/position/location", 
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
		$.post("/hrm/employee/location", 
			{id: $("#department").val()}, 
			function(data){ 
				data = "<option value = '0' selected='selected'>Chức vụ</option>"+data;
				$("#position").html(data);
				$("#position").val(0);
				doing=false;
			}
		);
	});
	
	$('#position').change(function() {
		var department = $("#department").val();
		var position = $(this).val();
		$.post("/hrm/humanbenefit/bexist",
			{department: department, position: position},
			function(data) {
				if (data != '') {
					var arrBenefit = data.split(',');
					if (arrBenefit.length > 0) {
						for (i=0; i<arrBenefit.length; i++) {
							var benId = arrBenefit[i];
							$('#ben-'+benId).remove();
						}
					}
				}
				doing=false;
			}
		);
	});
	
	jQuery(document).ready(function(){
		jQuery("#formAction").validationEngine('attach', {promptPosition : "topLeft", autoPositionUpdate : true});
	});
</script>



