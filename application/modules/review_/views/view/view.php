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
            	<?php if (isset($query) && is_array($query) && count($query) > 0) : ?>
        		<!-- List -->
                <?php	
					$i=1;
					foreach ($query as $row):
						$data_pr1 = json_decode($row->review_data_first);
						$result_pr1 = $data_pr1->result;
						$product_pr1 = $data_pr1->data;
						
						$data_pr2 = json_decode($row->review_data_second);
						$result_pr2 = $data_pr2->result;
						$product_pr2 = $data_pr2->data;
						
						$result_pr3 = $row->result;
				?>
				<p style="text-align:center; color:#000; font-weight:bold; text-transform:uppercase; margin:20px 0;">Đánh giá sản phẩm của <strong style="color:#F00;">[ <?= $row->fullname ?> :: <?php echo $row->day .'/ '. $row->month .'/ '.$row->year ?> ]</strong></p>
            	<div style="height:3px; background:#ff0000; margin:10px 0;"></div>
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
                
                 <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#f2f2f2" style="margin:10px 0;">
                	<tr align="center" height="30" style="color:#000;">
                        <td colspan="6" align="left"><strong style="margin-left:20px;">Nhóm sản phẩm chính</strong></td>
                        <td width="150"><input type="hidden" name="pr1_result_total" id="pr1_result_total"/><strong style="color:#f00;" class="pr1_result"><?= $result_pr1 ?>%</strong></td>
					</tr>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
					<?php
                        if(count($product_pr1) > 0):
                            $unitT = '';
							foreach($unit as $srow):
								$unitT .= '<option value="'.$srow->id.'">'.$srow->unit.'</option>';
							endforeach;
							$unitT .= '</select>';
							
                            $j = 0;
                            foreach($product_pr1 as $krow):
								
                                echo '
                                    <tr align="center" height="30" style="color:#000;">
                                    <td width="50"><strong>'.($j+1).'</strong></td>
                                    <td align="left"><strong style="margin-left:10px">'.$krow->name.'</strong></td>
                                    <td width="150">'.str_replace('value="'.$krow->unit.'"', 'value="'.$krow->unit.'" selected="selected" ', '<select name="pr1_unit[]">'.$unitT).'</td>
                                    <td width="150"><input type="text" name="pr1_weight[]" value="'.$krow->weight.'" class="count" id="weight_'.$j.'" data-id="'.$j.'" style="margin:0 5px; width:50px; height:15px;"><strong>%</strong></td>
                                    <td width="150"><input type="text" name="pr1_const[]" value="'.$krow->const.'" class="count" id="const_'.$j.'" data-id="'.$j.'" style="margin:0 5px; width:50px; height:15px;"></td>
                                    <td width="150"><input type="text" name="pr1_result[]" value="'.$krow->result.'" class="count" id="result_'.$j.'" data-id="'.$j.'" style="margin:0 5px; width:50px; height:15px;"></td>
                                    <td width="150"><strong id="req_show_'.$j.'">'.$krow->req.'%</strong></td></tr>
                                ';
                                $j++;
                            endforeach;
                        endif;
                    ?>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#f2f2f2" style="margin:10px 0;">
                    <tr align="center" height="30" style="color:#000;">
                        <td colspan="6" align="left"><strong style="margin-left:20px;">Nhóm sản phẩm phụ</strong></td>
                        <td width="150"><input type="hidden" name="pr2_result_total" id="pr2_result_total"/><strong style="color:#f00;" class="pr2_result"><?= $result_pr2 ?>%</strong></td>
                    </tr>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
					<?php
                        if(count($product_pr2) > 0):
                            $unitT = '';
							foreach($unit as $srow):
								$unitT .= '<option value="'.$srow->id.'">'.$srow->unit.'</option>';
							endforeach;
							$unitT .= '</select>';
							
                            $k = 0;
                            foreach($product_pr2 as $mrow):
								
                                echo '
                                    <tr align="center" height="30" style="color:#000;">
                                    <td width="50"><strong>'.($k+1).'</strong></td>
                                    <td align="left"><strong style="margin-left:10px">'.$mrow->name.'</strong></td>
                                    <td width="150">'.str_replace('value="'.$mrow->unit.'"', 'value="'.$mrow->unit.'" selected="selected" ', '<select name="pr1_unit[]">'.$unitT).'</td>
                                    <td width="150"><input type="text" name="pr2_weight[]" value="'.$mrow->weight.'" class="count" id="weight_'.$k.'" data-id="'.$k.'" style="margin:0 5px; width:50px; height:15px;"><strong>%</strong></td>
                                    <td width="150"><input type="text" name="pr2_const[]" value="'.$mrow->const.'" class="count" id="const_'.$k.'" data-id="'.$k.'" style="margin:0 5px; width:50px; height:15px;"></td>
                                    <td width="150"><input type="text" name="pr2_result[]" value="'.$mrow->result.'" class="count" id="result_'.$k.'" data-id="'.$k.'" style="margin:0 5px; width:50px; height:15px;"></td>
                                    <td width="150"><strong id="req_show_'.$k.'">'.$mrow->req.'%</strong></td></tr>
                                ';
                                $k++;
                            endforeach;
                        endif;
                    ?>	
                </table>
                
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#f2f2f2" style="margin:10px 0;">
                	<tr align="center" height="30" style="color:#000;">
                        <td colspan="6" align="left"><input type="hidden" name="pr3_result_total" id="pr3_result_total"/><strong style="margin-left:20px;">Kết quả sản phẩm</strong></td>
                        <td width="150"><strong style="color:#f00;" class="pr3_result"><?= $result_pr3 ?>%</strong></td>
					</tr>	
                </table>
                
				<?php $i++; endforeach; ?>
                <?php echo $pagination ?>
                <?php else: ?>
                	<p style="text-align:center; color:#f00;">Dữ liệu đang được cập nhật.</p>
                <?php endif; ?>
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
  margin:5px;
  padding: 0 1px;
  width: 100px !important;
  height: 25px;
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
button {
  padding: 0 18px;
  height: 29px;
  font-size: 12px;
  font-weight: bold;
  color: #527881;
  text-shadow: 0 1px #e3f1f1;
  background: #cde5ef;
  border: 1px solid;
  border-color: #b4ccce #b3c0c8 #9eb9c2;
  border-radius: 16px;
  outline: 0;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  background-image: -webkit-linear-gradient(top, #edf5f8, #cde5ef);
  background-image: -moz-linear-gradient(top, #edf5f8, #cde5ef);
  background-image: -o-linear-gradient(top, #edf5f8, #cde5ef);
  background-image: linear-gradient(to bottom, #edf5f8, #cde5ef);
  -webkit-box-shadow: inset 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.15);
  box-shadow: inset 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.15);
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
			$('#table tr').hover(function() {
				$(this).css('background-color', '#FFFFC6');
			},
			function() {
				$(this).css('background-color', '');
			});
		});
	});
</script>