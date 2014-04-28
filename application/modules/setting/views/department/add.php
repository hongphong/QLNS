<div class="pro-info wrap-main">
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
    	<script type="text/javascript">
			$(document).ready(function() {
				$("#select").change(function() {
					$('#sid').val($("#select option:selected").attr("id"));
				});
			});
		</script>
    	
    	<div id="md03">
        	<div class="head">
            	Thông tin chung
            </div>
            <div class="content">
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[name]" placeholder="Tên phòng ban"/></td>
                        <td align="30%">
                        	<input type="hidden" name="input[sid]" id="sid" value="0"/>
                        	<select name="input[parent_id]" id="select">
                            	<option value="0">Trực thuộc phòng ban</option>
                                <?php 
									if($depart):
										echo $depart;
									endif;
								?>
							</select>
                        </td>
                        <td width="30%">
                        	<select name="input[company_id]">
                            	<option value="0">Trực thuộc công ty</option>
                                <?php 
									if(isset($parent) && count($parent) > 0 && is_array($parent)):
										foreach($parent as $row):
											echo '<option value="'.$row->id.'">'.$row->name.'</option>';
										endforeach;
									endif;
								?>
							</select>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[address]" placeholder="Địa chỉ phòng ban"/></td>
                        <td align="30%"><input type="text" name="input[phone]" placeholder="Số điện thoại"/></td>
                        <td width="30%"><input type="text" name="input[hotline]" placeholder="Số hotline"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"> 
                        	<select name="input[city_id]" id="cid">
                            	<option value="0">Thành phố</option>
                                <?php
									$city = city();
                                	foreach($city as $index => $row):
										echo '<option value="'.$index.'">'.$row.'</option>';
									endforeach;
                                ?>
							</select>	
                        </td>
                        <td align="30%">
                       		<select name="input[district_id]" id="did">
                            	<option value="0">Quận/Huyện</option>
							</select> 	
                        </td>
                        <td width="30%">
                        	<?php
							$select='
							<select name="input[status]">
								<option value="1">Đang hoạt động</option>
								<option value="2">Đang không hoạt động</option>
							</select>';
							echo $select;
							?>	
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[fax]" placeholder="Số fax"/></td>
                        <td align="30%"><input type="text" name="input[yahoo]" placeholder="Yahoo"/></td>
                        <td width="30%"><input type="text" name="input[skype]" placeholder="Skype"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[facebook]" placeholder="Facebook"/></td>
                        <td align="30%"><input type="text" name="input[google]" placeholder="Google+"/></td>
                        <td width="30%"><input type="text" name="input[website]" placeholder="website"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<strong>Mô tả chung</strong>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<textarea name="input[description]"></textarea>
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
</script>