<div class="right actions" style="width:80%;">
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
		<script type="text/javascript"> 
            $(document).ready(function() {
                $("#gid option[value='<?php echo $query->gid  ?>']").attr('selected', 'selected');
                $("#unit option[value='<?php echo $query->unit ?>']").attr('selected', 'selected');
            });
        </script>
    	<div id="md03">
        	<div class="head">
            	Thông tin chung
            </div>
            <div class="content">
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="id"  value="<?php echo $query->id ?>"/>
                    <?php 
						foreach($listgroup_bymodel as $row): 
							if($row->status == 1)
								echo '<input type="hidden" name="id_pr1"  value="'.$row->id.'"/>';
							else
								echo '<input type="hidden" name="id_pr2"  value="'.$row->id.'"/>';
						endforeach;
						$data = json_decode($query->datagid);
					?>
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="model_name" placeholder="Tên mẫu"  value="<?= $query->name ?>"/></td>
                        <td align="30%"></td>
                        <td width="30%"></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<strong>Nhóm sản phẩm chính</strong>
                        </td>
                    </tr>
                    
                    <?php 
						if(isset($group) && is_array($group) && count($group) > 0):
							$i = 0;
							foreach($group as $row):
								echo '<tr height="30" style="color:#000;">
										<td width="100%" colspan="3" style="text-indent:20px;"><a href="javascript:;" onclick="review.loadProductByid($(this),'.$row->id.', \'gr1_'.$i.'\', \'gr1\', '.$query->id.')" id="gr1_'.$i.'" style="border-bottom: 2px solid #d1d1d1; padding-bottom: 3px;">[+] '.$row->name.'</a><span class="gr1_'.$i.'"></span></td></tr>';
								if(in_array($row->id, $data->gr1))
									echo '<script>$(document).ready(function() {review.loadProductByid($(this),'.$row->id.', \'gr1_'.$i.'\', \'gr1\', '.$query->id.');});</script>';
								$i++;
							endforeach;
						endif;
					?>
                    
                    <tr height="30" style="color:#000;">
                        <td width="100%" colspan="3">
                        	<strong>Nhóm sản phẩm phụ</strong>
                        </td>
                    </tr>
                    
                    <?php 
						if(isset($group) && is_array($group) && count($group) > 0):
							$i = 0;
							foreach($group as $row):
								echo '<tr height="30" style="color:#000;">
										<td width="100%" colspan="3" style="text-indent:20px;"><a href="javascript:;" onclick="review.loadProductByid($(this),'.$row->id.', \'gr2_'.$i.'\', \'gr2\', '.$query->id.')" id="gr1_'.$i.'" style="border-bottom: 2px solid #d1d1d1; padding-bottom: 3px;">[+] '.$row->name.'</a><span class="gr2_'.$i.'"></span></td></tr>';
										
								if(in_array($row->id, $data->gr2))
									echo '<script>$(document).ready(function() {review.loadProductByid($(this),'.$row->id.', \'gr2_'.$i.'\', \'gr2\', '.$query->id.');});</script>';
								$i++;
							endforeach;
						endif;
					?>
                    
                    <tr height="50" style="color:#000;">
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