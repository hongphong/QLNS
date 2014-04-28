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
    
    	<div id="md03">
        	<div class="head">
            	Thông tin chung
            </div>
            <div class="content">
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[name]" placeholder="Tên công ty"/></td>
                        <td align="30%"><input type="text" name="input[tax_code]" placeholder="Mã số thuế"/></td>
                        <td width="30%"><input type="text" name="input[day_working]" placeholder="Số ngày làm việc"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[address_bussiness]" placeholder="Địa chỉ đăng ký kinh doanh"/></td>
                        <td align="30%"><input type="text" name="input[address_office]" placeholder="Địa chỉ văn phòng đại diện"/></td>
                        <td width="30%"><input type="text" name="input[phone]" placeholder="Số điện thoại"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%">
                       		<input type="text" name="input[hotline]" placeholder="Số hotline"/> 	
                        </td>
                        <td align="30%">
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
                        <td width="30%">
                        	<select name="input[district_id]" id="did">
                            	<option value="0">Quận/Huyện</option>
							</select>
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
                        <td width="30%"><input type="text" name="input[website]" placeholder="Website"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[short_name]" placeholder="Tên viết tắt" title="Tên viết tắt" /></td>
                        <td align="30%">
                           <select name="input[parent_id]" >
                            	<option value="0">Công ty mẹ</option>
                                <?php 
      									if(isset($parent) && count($parent) > 0 && is_array($parent)):
      										foreach($parent as $row):
      											echo '<option value="'.$row->id.'">'.$row->name.'</option>';
      										endforeach;
      									endif;
      								?>
      							</select>
                        </td>
                        <td width="30%"></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<strong>Lời chào báo giá</strong>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<textarea name="input[intro_offer]" style="height: 55px;"></textarea>
                        </td>
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