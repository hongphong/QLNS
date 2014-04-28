<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trang đăng nhập</title>
<link href="<?php echo base_url() ?>public/template/login/css/vfog-login.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<!-- Top -->
	<div class="header"></div>
    <div class="main" align="center">
    	<div class="login-block">
    		<div class="lb-top">
    			<span>Đăng nhập</span>
    		</div>
    		<div class="lb-mid">
    			<form action="<?php print base_url() . 'home/login' ?>" name="login" id="login" method="post">
	    			<table>
	    				<tr>
	    					<td></td>
	    					<td colspan="1">
	    						<p style="font-size: 11px;color: red;height: 15px;">
	    							<?php
									if ($this->session->flashdata('error')){ 
										echo $this->session->flashdata('error');
									}
									?>
								</p>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td class="f_name" width="85" align="right">Tên đăng nhập</td>
	    					<td>
	    						<input style="width: 220px;" class="f_control" type="text" name="username">
	    					</td>
	    				</tr>
	    				<tr>
	    					<td class="f_name" align="right">Mật khẩu</td>
	    					<td>
	    						<input style="width: 220px;" class="f_control" type="password" name="password">
	    					</td>
	    				</tr>
	    				<tr>
	    					<td></td>
	    					<td>
	    						<p style="font-size: 11px;color: #151515;">Dùng tên đăng nhập và mật khẩu chính xác để đăng nhập vào hệ thống</p>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td></td>
	    					<td>
	    						<div style="float: right;" class="btt-submit">
									<div class="btt-submit-wrap">
										<input type="submit" name="submit" class="btt-submit" value="Đăng nhập">
									</div>
								</div>
	    					</td>
	    				</tr>
	    			</table>
    			</form>
    		</div>
    		<div class="lb-bot"></div>
    	</div>
    </div>
    <div id="footer" class="left">
		<div class="left">
        	<a href=""><img src="<?= base_url() ?>public/template/iso/images/logo_footer.jpg" style="border:0;" /></a>
        </div>  
        
        <div class="right">
        	<div class="cd02 right">
            	<p><strong>Contact</strong></p>
                <p>e-Customer, e-Human, e-Purschase, e-Facility</p>
                <p>e-Warehouse, e-Iso, e-Bussiness Intelligence</p>
            </div>
            
            <div class="cd02 right">
            	<p><strong>Microbiz e-Business</strong></p>
                <p>e-Customer, e-Human, e-Purschase, e-Facility</p>
                <p>e-Sale, e-Human, e-Purschase, e-Facility</p>
                <p>e-Warehouse, e-Iso, e-Bussiness Intelligence</p>
            </div>
        </div>
    </div>
</body>
</html>




