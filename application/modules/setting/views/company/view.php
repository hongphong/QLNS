<div class="pro-info wrap-main">
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
    <div>
    	<?php 
		if($this->session->flashdata('error')):
			echo '<div id="display_error">'. $this->session->flashdata('error') .'</div>';
		endif;
		if($this->session->flashdata('success')):
			echo '<div id="success">'. $this->session->flashdata('success') .'</div>';
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
                        <td align="left"><strong style="margin-left:10px">Tên công ty</strong></td>
                        <td width="50"><strong>Sửa</strong></td>
                        <td width="50"><strong>Xóa</strong></td>
                        <td width="60"><strong><input type="checkbox" size="1" id="selectall" value="0"></strong></td>
                    </tr> 
                </table>
                <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table">
                	<?php	
					$i=1;
					foreach ($query as $row):
						if ($i%2==0) {
							$bgcolor ='#F1F1F1';
						} else {
							$bgcolor ='#F3F3F3';
						}
						$id = $row->id;
						$title = $row->name;
						$linkEdit = base_url().'setting/company/edit/'.$id;
                    ?>
                    <tr align="center" height="30" bgcolor="<?php echo $bgcolor; ?>" id="ms">
                        <td width="50"><strong style="color:#f00;"><?= $i ?></strong></td>
                        <td align="left">
                            <strong style="margin-left:10px">
                                <?= $title ?>
                            </strong>
                        </td>
                        <td width="50"><a href="<?= $linkEdit ?>"><strong>Sửa</strong></a></td>
                        <td width="50">
                            <a href="javascript:;" onclick="cpanel.deleted($(this), <?php echo $id ?>, '<?= $actionDel ?>');" ><strong>Xóa</strong></a>
                        </td>
                        <td width="60"><input type="checkbox" name="selector[]" class="case" id="selector" value="<?php echo $id ?>" size="1"></td>
                    </tr>
                    	<?php
							$s=1;
							$query = $this->db->get_where('mc_company', array('parent_id'=>$id));
								foreach($query->result() as $irow):
									if($s%2==0){
										$bgcolor ='#F6F6F6';
									}else{
										$bgcolor ='#F9F9F9';
									} 
									$ids 	   = $irow->id;
									$ititle    = $irow->name;
									$ilinkEdit = base_url().'setting/company/edit/'.$ids;
						?>
                        <tr align="center" height="30" bgcolor="<?php echo $bgcolor; ?>" id="ms">
                            <td width="50"><strong style="color:#f00;"><?= $i ?>.<?= $s ?></strong></td>
                            <td align="left">
                                <strong style="margin-left:25px">
                                    <?= $ititle ?>
                                </strong>
                            </td>
                            <td width="50"><a href="<?= $ilinkEdit ?>"><strong>Sửa</strong></a></td>
                            <td width="50">
                                <a href="javascript:;" onclick="cpanel.deleted($(this), <?php echo $ids ?>, '<?= $actionDel ?>');" ><strong>Xóa</strong></a>
                            </td>
                            <td width="60"><input type="checkbox" name="selector[]" class="case" id="selector" value="<?php echo $ids ?>" size="1"></td>
                        </tr>
                    	<?php $s++; endforeach; ?>
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
				$.post("<?php echo base_url().'setting/company/deletemulti' ?>", { ids : val, table : TABLE } );	
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