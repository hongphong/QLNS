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
         	<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
             	<input type="hidden" name="id"  value="<?php echo $query->id ?>"/>
         	<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
             	<tr height="30" style="color:#000;">
                  <td width="40%">
                 		<input type="text" name="employee" placeholder="Tên nhân viên" value="<?= $query->employee ?>" disabled="disabled"/> 	
                  </td>
                  <td align="30%">
                  	<input type="text" name="input[name]" placeholder="Tên tài liệu" value="<?= $query->name ?>"  />	
                  </td>
                  <td width="30%">
                  	<input type="file" name="img[]" />
                     <?php print show_attachment($document); ?>
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
