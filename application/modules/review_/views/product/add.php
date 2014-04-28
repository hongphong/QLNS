<div class="right actions" style="width:80%">
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
        	<div class="head">
            	Thông tin chung
            </div>
            <div class="content">
            	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[name]" placeholder="Tên sản phẩm"/></td>
                        <td align="30%"><input type="text" name="input[const]" placeholder="Giá mặc định"/></td>
                        <td width="30%"><input type="text" name="input[result]" placeholder="Giá trị thực tế"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="input[weight]" placeholder="Trọng số"/></td>
                        <td align="30%"></td>
                        <td width="30%"></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%">
                        	<select name="input[gid]" id="select" class="validate[required]">
                            	<option value="0">Loại nhóm</option>
                                <?php 
									if(isset($group) && count($group) > 0 && is_array($group)):
										foreach($group as $row):
											echo '<option value="'.$row->id.'">'.$row->name.'</option>';
										endforeach;
									endif;
								?>
							</select>
                        </td>
                        <td align="30%">
                        	<select name="input[unit]" id="select" class="validate[required]">
                            	<option value="0">Loại đơn vị</option>
                                <?php 
									if(isset($unit) && count($unit) > 0 && is_array($unit)):
										foreach($unit as $row):
											echo '<option value="'.$row->id.'">'.$row->unit.'</option>';
										endforeach;
									endif;
								?>
							</select>	
                        </td>
                        <td width="30%"></td>
                    </tr>
                    <tr height="50" style="color:#000; ">
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