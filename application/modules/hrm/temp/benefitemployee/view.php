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
    	
    	<div id="md03">
        	<!--<a style="cursor:pointer;" href="javascripts:;" class="deletemulti" value="">[ <strong>Xóa đã chọn</strong> ]</a>-->
            <div class="content">
            	<?php if (isset($query) && is_array($query) && count($query) > 0) : ?>
        		<!-- List --> 
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="#e3e3e3">
                    <tr align="center" height="30" style="color:#000;">
                        <td width="50"><strong>STT</strong></td>
                        <td align="left"><strong style="margin-left:10px">Tên quyền lợi</strong></td>
                        <td width="150"><strong>Giá trị</strong></td>
                        <td width="50"><strong>Sửa</strong></td>
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
							$linkEdit = base_url().'hrm/benefitemployee/edit/'.$id.'/?uid='.$uid;
							$value    = $row->limitation. ' <span style="color:#f00"><strong>'. $row->unit.'</strong></span>';
                    ?>
                    <tr align="center" height="30" bgcolor="<?php echo $bgcolor; ?>" id="ms">
                        <td width="50"><strong style="color:#f00;"><?= $i ?></strong></td>
                        <td align="left">
                            <strong style="margin-left:10px">
                                <?= $title ?>
                            </strong>
                        </td>
                        <td width="150"><?= $value ?></td>
                        <td width="50"><a href="<?= $linkEdit ?>"><strong>Sửa</strong></a></td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </table>
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
		
		$(".deletemulti").click(function(){
			var TABLE = $(this).attr("value");							 
			if(confirm("Bạn muốn xóa những mục đã chọn này không ?")){	
				var val = [];
				$('input:checkbox:checked').each(function(i){
					val[i] = $(this).val();
					$(this).parent().parent().remove();	
				})
				$.post("<?php echo base_url().'hrm/benefit/deletemulti' ?>", { ids : val, table : TABLE } );	
			}
		});
	});
</script>
<script type="text/javascript">
	$(function(){
		$("#selectall").click(function () {
			  $('.case').attr('checked', this.checked);
		});
		$(".case").click(function(){
			if($(".case").length == $(".case:checked").length) {
				$("#selectall").attr("checked", "checked");
		} else {
				$("#selectall").removeAttr("checked");
			}
		});
	});
</script>