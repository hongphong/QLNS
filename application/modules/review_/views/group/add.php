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
                        <td width="40%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td align="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td width="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td align="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td width="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td align="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td width="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                    </tr>
                    <tr height="30" style="color:#000;">
                        <td width="40%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td align="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
                        <td width="30%"><input type="text" name="name[]" placeholder="Tên nhóm"/></td>
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