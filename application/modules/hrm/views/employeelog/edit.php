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
    	<script type="text/javascript"> 
			$(document).ready(function() {
				$("#isactive option[value='<?php echo $query->status ?>']").attr('selected', 'selected');
				$("#unit option[value='<?php echo $query->unit ?>']").attr('selected', 'selected');
				$("#benefit option[value='<?php echo $query->benefit_id ?>']").attr('selected', 'selected');
			});
		</script>
    	<div id="md03">
        	<div class="head">
            	Thông tin chung
            </div>
            <div class="content">
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="id"  value="<?php echo $query->id ?>"/>
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="40%">
                       		<input type="text" name="employee" placeholder="Tên nhân viên" value="<?= $query->employee ?>" disabled="disabled"/> 	
                        </td>
                        <td align="30%"></td>
                        <td width="30%"></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<strong>Đánh giá chung</strong>
                        </td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<textarea name="input[comment]"><?= $query->comment ?></textarea>
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