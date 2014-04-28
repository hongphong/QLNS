<div class="right actions" style="width:100%">
    <div class="left" style="width:100%;">
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
        	<!--<a style="cursor:pointer;" href="javascripts:;" class="deletemulti" value="">[ <strong>Xóa đã chọn</strong> ]</a>-->
            <div class="content">
            	<p style="text-align:center; color:#000; font-weight:bold; text-transform:uppercase; margin:10px 0;">Hệ thống xếp hạng mức độ quan trọng của sản phẩm</p>
            	<div style="height:3px; background:#ff0000; margin:10px 0;"></div>
                
                 <?php
					$data = new stdClass;
					$idata = new stdClass;
                	foreach($listgroup_bymodel as $row):
						if($row->status == 1)
							$data = $row;
						else
							$idata = $row;
					endforeach;
					
					$product1 = json_decode($data->data);
					$product2 = json_decode($idata->data);
				?>
                
        		<!-- List --> 
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#d8d8d8">
                    <tr align="center" height="30" style="color:#000;">
                        <td width="50"><strong>STT</strong></td>
                        <td align="left"><strong style="margin-left:10px">Tên điều kiện</strong></td>
                        <td width="150"><strong>Đơn vị</strong></td>
                        <td width="150"><strong>Hệ số</strong></td>
                        <td width="150"><strong>Giá trị mặc định</strong></td>
                        <td width="150"><strong>Giá trị thực tế</strong></td>
                        <td width="150"><strong>Tỷ lệ chênh</strong></td>
                    </tr> 
                </table>
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="fm-form" name="frm">
                	<input type="hidden" name="id" value="<?= $query->id ?>" />
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#f2f2f2" style="margin:10px 0;">
                	<tr align="center" height="30" style="color:#000;">
                        <td colspan="6" align="left"><strong style="margin-left:20px;">Nhóm sản phẩm chính</strong></td>
                        <td width="150"><input type="hidden" name="pr1_result_total" id="pr1_result_total"/><strong style="color:#f00;" class="pr1_result">0%</strong></td>
					</tr>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
                	<?php
                    	if(count($product1) > 0):
							$unitT = '';
							foreach($unit as $row):
								$unitT .= '<option value="'.$row->id.'">'.$row->unit.'</option>';
							endforeach;
							$unitT .= '</select>';
							
							//--
							$i = 0;
							foreach($product1 as $row):
								echo '
									<tr align="center" height="30" style="color:#000;">
									<td width="50"><strong>'.($i+1).'</strong></td>
									<td align="left"><input type="hidden" name="pr1_name[]" value="'.$row->name.'"><strong style="margin-left:10px">'.$row->name.'</strong></td>
									<td width="150">'.str_replace('value="'.$row->unit.'"', 'value="'.$row->unit.'" selected="selected" ', '<select name="pr1_unit[]">'.$unitT).'</td>
									<td width="150"><input type="text" name="pr1_weight[]" value="'.$row->weight.'" class="count validate[required,custom[number]]" id="weight_'.$i.'" data-id="'.$i.'" style="margin:0 5px; width:50px; height:15px;"><strong>%</strong></td>
									<td width="150"><input type="text" name="pr1_const[]" value="'.$row->const.'" class="count" id="const_'.$i.'" data-id="'.$i.'" style="margin:0 5px; width:50px; height:15px;"></td>
									<td width="150"><input type="text" name="pr1_result[]" class="count" id="result_'.$i.'" data-id="'.$i.'" style="margin:0 5px; width:50px; height:15px;"></td>
									<td width="150"><input type="hidden" name="pr1_req[]" class="req"  id="req_'.$i.'"  style="margin:0 5px; width:50px; height:15px;"><strong id="req_show_'.$i.'">...</strong></td></tr>
								';
								$i++;
							endforeach;
						endif;
					?>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#f2f2f2" style="margin:10px 0;">
                	<tr align="center" height="30" style="color:#000;">
                        <td colspan="6" align="left"><strong style="margin-left:20px;">Nhóm sản phẩm phụ</strong></td>
                        <td width="150"><input type="hidden" name="pr2_result_total" id="pr2_result_total"/><strong style="color:#f00;" class="pr2_result">0%</strong></td>
					</tr>	
                </table> 
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
                	<?php
                    	if(count($product2) > 0):
							$i = 0;
							foreach($product2 as $row):
								echo '
									<tr align="center" height="30" style="color:#000;">
									<td width="50"><strong>'.($i+1).'</strong></td>
									<td align="left"><input type="hidden" name="pr2_name[]" value="'.$row->name.'"><strong style="margin-left:10px">'.$row->name.'</strong></td>
									<td width="150">'.str_replace('value="'.$row->unit.'"', 'value="'.$row->unit.'" selected="selected" ', '<select name="pr2_unit[]">'.$unitT).'</td>
									<td width="150"><input type="text" name="pr2_weight[]" value="'.$row->weight.'" class="count2" id="iweight_'.$i.'" data-id="'.$i.'" style="margin:0 5px; width:50px; height:15px;"><strong>%</strong></td>
									<td width="150"><input type="text" name="pr2_const[]" value="'.$row->const.'" class="count2" id="iconst_'.$i.'" data-id="'.$i.'" style="margin:0 5px; width:50px; height:15px;"></td>
									<td width="150"><input type="text" name="pr2_result[]" class="count2" id="iresult_'.$i.'" data-id="'.$i.'" style="margin:0 5px; width:50px; height:15px;"></td>
									<td width="150"><input type="hidden" name="pr2_req[]" class="ireq"  id="ireq_'.$i.'"  style="margin:0 5px; width:50px; height:15px;"><strong id="ireq_show_'.$i.'">...</strong></td></tr>
								';
								$i++;
							endforeach;
						endif;
					?>
				</table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#f2f2f2" style="margin:10px 0;">
                	<tr align="center" height="30" style="color:#000;">
                        <td colspan="6" align="left"><input type="hidden" name="pr3_result_total" id="pr3_result_total"/><strong style="margin-left:20px;">Kết quả sản phẩm</strong></td>
                        <td width="150"><strong style="color:#f00;" class="pr3_result">0%</strong></td>
					</tr>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="" style="text-align:center;">
                	<tr height="50" style="color:#000; ">
                        <td width="100%" colspan="3">
                        	<button name="submit" value="submit" onclick="return confirm('Bạn đã chắc chắn hoàn thành đánh giá chưa?');">Lưu đánh giá</button>
                        </td>
                    </tr>	
                </table>  
                </form>
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>
<style>
input {
  font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif;
  font-size: 12px !important;
}
select {
  margin: 5px;
  padding: 0 1px;
  width: 100px !important;
  height: 30px;
  color: #404040;
  background: white;
  border: 1px solid;
  border-color: #c4c4c4 #d1d1d1 #d4d4d4;
  border-radius: 2px;
  outline: 2px solid #eff4f7;
  -moz-outline-radius: 3px;
  -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
}
input[type=text], input[type=password] {
  margin: 5px;
  padding: 0 10px;
  width: 200px;
  height: 34px;
  color: #404040;
  background: white;
  border: 1px solid;
  border-color: #c4c4c4 #d1d1d1 #d4d4d4;
  border-radius: 2px;
  outline: 2px solid #eff4f7;
  -moz-outline-radius: 3px;
  -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
}
input[type=text]:focus, input[type=password]:focus {
  border-color: #7dc9e2;
  outline-color: #dceefc;
  outline-offset: 0;
}
</style>
<script>
	$(document).ready(function() {
		$('.count').on('input keyup keydown focus', function () {				
			var id = $(this).attr("data-id");
			var weight = parseInt($('#weight_'+id).val());
			var constance = parseInt($('#const_'+id).val());
			var result = parseInt($('#result_'+id).val());
			var req = parseFloat(result/constance)*100;
			if(isNaN(req))
				req = 0;
			$('#req_'+id).val(Math.round(req)); 
			$('#req_show_'+id).html(Math.round(req) + " %"); 
			
			var value = 0;
			var i = 0;
			$('.req').each(function(i){
				var valRq = $(this).val();
				if(isNaN(valRq))
					valRq = 0;
					
				if(valRq == '')
					valRq = 0;
	
				valRq = parseInt(valRq);
				value += Math.round((valRq*parseInt($('#weight_'+i).val()))/100);
				i++;
			})
			$('.pr1_result').html(value+"%");
			$('#pr1_result_total').val(value);
			var pr2 = $('.pr2_result').html();
			$('.pr3_result').html( Math.round((value * parseInt(pr2))/100) + "%");
			$('#pr3_result_total').val(Math.round((value * parseInt(pr2))/100));
		});
		
		$('.count2').on('input keyup keydown focus', function () {				
			var id = $(this).attr("data-id");
			var weight = parseInt($('#iweight_'+id).val());
			var constance = parseInt($('#iconst_'+id).val());
			var result = parseInt($('#iresult_'+id).val());
			var req = parseFloat(result/constance)*100;
			if(isNaN(req))
				req = 0;
			$('#ireq_'+id).val(Math.round(req)); 
			$('#ireq_show_'+id).html(Math.round(req) + " %"); 
			
			var value = 0;
			var i = 0;
			$('.ireq').each(function(i){
				var valRq = $(this).val();
				if(isNaN(valRq))
					valRq = 0;
					
				if(valRq == '')
					valRq = 0;
	
				valRq = parseInt(valRq);
				value += Math.round((valRq*parseInt($('#iweight_'+i).val()))/100);
				i++;
			})
			$('.pr2_result').html(value+"%");
			$('#pr2_result_total').val(value);
			var pr1 = $('.pr1_result').html();
			$('.pr3_result').html( Math.round((value * parseInt(pr1))/100) + "%");
			$('#pr3_result_total').val(Math.round((value * parseInt(pr1))/100));
		});
	});
</script>