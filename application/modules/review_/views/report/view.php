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
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#e3e3e3">
                    <tr align="center" height="30" style="color:#000;">
                        <td width="50"><strong>STT</strong></td>
                        <td align="left"><strong style="margin-left:10px">Tên mẫu</strong></td>
                        <td width="200"><strong>Đánh giá</strong></td>
                    </tr> 
                </table>
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
                	<?php	
						$i=1;
						foreach ($query as $row):
							if($i%2==0){
								$bgcolor ='#F1F1F1';
							}else{
								$bgcolor ='#F3F3F3';
							}
							
							$id 	  = $row->id;
							$title    = $row->name;
							$linkEdit = base_url().'review/report/rep/'.$id;
							$isReport = $row->isReport;
                    ?>
                    <tr align="center" height="30" bgcolor="<?php echo $bgcolor; ?>" id="ms">
                        <td width="50"><strong style="color:#f00;"><?= $i ?></strong></td>
                        <td align="left">
                            <strong style="margin-left:10px">
                                <?= $title ?>
                            </strong>
                        </td>
                        <td width="200">
							<?php 
								if(!$isReport):
									echo '<a href="'.$linkEdit.'"><strong>Đánh giá</strong></a>';
								else: 
									echo '<strong>Mẫu này đã đánh giá</strong>'; 
								endif;
							?>
						</td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </table>
                <?php echo $pagination ?>
                <?php else: ?>
                	<p style="text-align:center; color:#f00;">Dữ liệu đang được cập nhật.</p>
                <?php endif; ?>
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>
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