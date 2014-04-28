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
            	<table width="80%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                	<tr height="30" style="color:#000;">
                        <td width="40%">
                        	<select name="input[company_id]" id="select" class="validate[required]">
                            	<option value="0">Trực thuộc công ty</option>
                                <?php 
									if(isset($parent) && count($parent) > 0 && is_array($parent)):
										foreach($parent as $row):
											if($query->company_id == $row->id){
												$select = 'selected="selected"';
											}else{
												$select = '';
											}
											echo '<option value="'.$row->id.'" '.$select.'>'.$row->name.'</option>';
										endforeach;
									endif;
								?>
							</select>
						</td>
                        <td width="30%">
                        	<script type="text/javascript"> 
								$(document).ready(function() {
									$("#department option[value='<?php echo $query->department_id ?>']").attr('selected', 'selected');
								});
							</script>
                        	<select name="input[department_id]" id="department">
                            	<option value="0">Phòng ban chính</option>
                                <?php 
									if($depart):
										echo $depart;
									endif;
								?>
							</select>
                        </td>
                    	<td width="30%"><input type="text" name="input[name]" placeholder="Tên chức vụ" value="<?php print $query->name ?>" /></td>
                    </tr>
                    <tr>
                     <td colspan="3">
                     	<textarea name="input[description]" placeholder="Mô tả nghiệp vụ ..." style="margin-top: 5px;width: 97%;"><?php print $query->description; ?></textarea>
                     </td>
                    </tr>
                    <tr height="50" style="color:#000; text-align:left;">
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
	$("#select").change(function(){
		if (doing)
			return;
		doing=true;					
		//$("#loading_district").show();
		$.post("/hrm/position/location", 
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