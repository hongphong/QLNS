<?php
	if ($this->session->flashdata('error')){ 
		echo '<p style="text-align:center;">'.$this->session->flashdata('error').'</p>';
	}
?>

<form action="<?php echo base_url() . 'home/login' ?>" name="login" id="login" method="post">
	<input type="text" name="username"/>
	<input type="password" name="password" />
	
	<button name="submit" value="Đăng nhập">Đăng nhập</button>
	<input type="reset" value="Nhập lại" />
</form>
