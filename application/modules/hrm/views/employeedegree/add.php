<div class="pro-info wrap-main">
   <!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
   
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
        	<div class="head">
            	Thông tin chung
            </div>
            <div class="content">
                <div><span style="color:red"><?php echo $this->session->flashdata('error_em_up');?></span></div>
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="fullname" value="">
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
					<tr height="30" style="color:#000;">
						<td width="25%">
							<select name="department_id" id="department">
								<option value="">- Chọn phòng ban -</option>
								<?php 
								if (!empty($depart)) {
									foreach ($depart as $dep) {
										?>
										<option value="<?php print $dep['id']; ?>"><?php print '- '. $dep['name']; ?></option>
										<?php
									}
								}
								?>
							</select>
						</td>
                        <td width="25%">
                       		<select name="employ_id" id="employee">
                       			<option value="">- Chọn nhân viên -</option>
                       		</select> 	
                        </td>
                        <td align="25%">
                        	<input type="text" name="input[name]" placeholder="Tên tài liệu" />	
                        </td>
                        <td width="25%">
                        	<input style="padding: 0px 4px;" type="file" name="img[]" />	
                        </td>
                    </tr>
                    <tr height="50" style="color:#000;">
                        <td width="100%" colspan="4">
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
	
	$('#department').change(function() {
		var department = parseInt($(this).val());
		if (department > 0) {
			$.ajax({
				type: 'POST',
				url: '/hrm/employee/ajax_employee',
				data: {
					department: department
				},
				success: function(data) {
					$('#employee').html(data);
				}
			});
		}
	});

	$('#employee').change(function() {
		var emid = $(this).val();
		var emname = $('#em_'+emid).text();
		$('input[name=fullname]').val(emname);
	});
</script>
