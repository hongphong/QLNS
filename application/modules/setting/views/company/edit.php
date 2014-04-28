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
                	<input type="hidden" name="id"  value="<?php echo $query->id ?>"/>
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[name]" placeholder="Tên công ty" value="<?= $query->name ?>"/></td>
                        <td align="30%"><input type="text" name="input[tax_code]" placeholder="Mã số thuế" value="<?= $query->tax_code ?>"/></td>
                        <td width="30%"><input type="text" name="input[day_working]" placeholder="Số ngày làm việc"  value="<?= $query->day_working ?>"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[address_bussiness]" placeholder="Địa chỉ đăng ký kinh doanh"  value="<?= $query->address_bussiness ?>"/></td>
                        <td align="30%"><input type="text" name="input[address_office]" placeholder="Địa chỉ văn phòng đại diện"  value="<?= $query->address_office ?>"/></td>
                        <td width="30%"><input type="text" name="input[phone]" placeholder="Số điện thoại"  value="<?= $query->phone ?>"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%">
                       		<input type="text" name="input[hotline]" placeholder="Số hotline" value="<?= $query->hotline ?>"/> 	
                        </td>
                        <td align="30%">
                        	<select name="input[city_id]" id="cid">
                            	<option value="0">Thành phố</option>
                                <?php
									$city = city();
                                	foreach($city as $index => $row):
										if($query->city_id == $index){
											$select = 'selected="selected"';
										}else{
											$select = '';
										}
										echo '<option value="'.$index.'" '.$select.'>'.$row.'</option>';
									endforeach;
                                ?>
							</select>
                        </td>
                        <td width="30%">
                        	<select name="input[district_id]" id="did">
                            	<option value="0">Quận/Huyện</option>
                                <?php
									$districts = districts();
                                	foreach($districts[$query->city_id] as $index => $row){
										if($query->district_id == $index){
											$select = 'selected="selected"';
										}else{
											$select = '';
										}
										
										echo '<option value="'.$index.'" '.$select.' >'.$row.'</option>';	
									}
                                ?>
							</select>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[fax]" placeholder="Số fax" value="<?= $query->fax ?>" /></td>
                        <td align="30%"><input type="text" name="input[yahoo]" placeholder="Yahoo" value="<?= $query->yahoo ?>" /></td>
                        <td width="30%"><input type="text" name="input[skype]" placeholder="Skype" value="<?= $query->skype ?>" /></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[facebook]" placeholder="Facebook" value="<?= $query->facebook ?>" /></td>
                        <td align="30%"><input type="text" name="input[google]" placeholder="Google+" value="<?= $query->google ?>" /></td>
                        <td width="30%"><input type="text" name="input[website]" placeholder="Website" value="<?= $query->website ?>" /></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[short_name]" placeholder="Tên viết tắt" value="<?= $query->short_name ?>" title="Tên viết tắt" /></td>
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
                        <td width="30%">
                           Logo: <input type="file" name="file_attachment[]" style="width: 248px" />
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="2" style="vertical-align: bottom;">
                        	<strong>Lời chào báo giá</strong>
                        </td>
                        <td>
                           <?php if ($query->logo) { ?>
                              <img width="100" height="100" src="/public/uploads/<?php print $query->logo; ?>" />
                           <?php } ?>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<textarea name="input[intro_offer]" style="height: 55px;"><?= $query->intro_offer ?></textarea>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<strong>Mô tả chung</strong>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<textarea name="input[description]"><?= $query->description ?></textarea>
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