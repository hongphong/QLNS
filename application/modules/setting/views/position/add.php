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
            	<table width="80%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                    	<td width="40%">
                        	<select name="input[company_id]" id="select" class="validate[required]">
                            	<option value="0">Trực thuộc công ty</option>
                                <?php 
									if(isset($company) && count($company) > 0 && is_array($company)):
										foreach($company as $row):
											echo '<option value="'.$row->id.'">'.$row->name.'</option>';
										endforeach;
									endif;
								?>
							</select>		
                        </td>
                        <td width="30%">
                        	<select name="input[department_id]" id="department">
                            	<option value="0">Trực thuộc phòng ban</option>
							</select>
                        </td>
                        
                    	<td width="30%"><input type="text" name="input[name]" placeholder="Tên chức vụ" /></td>
                    </tr>
                    <tr>
                    	<td colspan="3">
                    		<textarea name="input[description]" placeholder="Mô tả nghiệp vụ ..." style="margin-top: 5px;width: 97%;"></textarea>
                    	</td>
                    </tr>
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
	var doing=false;
	
	$("#select").change(function(){
		if (doing)
			return;
		doing=true;					
		//$("#loading_district").show();
		$.post("/setting/position/location", 
			{id: $("#select").val()}, 
			function(data){ 
				data = "<option value = '' selected='selected'>Trực thuộc phòng ban</option>"+data;
				$("#department").html(data);
				$("#department").val(0);
				doing=false;
			}
		);
	});
	
	jQuery(document).ready(function(){
		jQuery("#formAction").validationEngine('attach', {promptPosition : "topLeft", autoPositionUpdate : true});
	});
</script>