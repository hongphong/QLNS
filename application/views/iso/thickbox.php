<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Phần mềm ERP - Microbiz 2013</title>
<link href="<?php echo base_url() ?>public/template/iso/css/cpanel.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>public/template/iso/css/css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>public/template/iso/css/validate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>public/template/iso/css/vfog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>public/template/iso/css/customer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>public/template/iso/css/template.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>public/template/iso/js/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/validate.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/validate-vn.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/application.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/nice.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/jquery_iso.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/template/iso/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jshashtable-3.0.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/thickbox.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/customer.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jquery.numberformatter-1.2.3.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jquery.validate.js'; ?>"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.findEditor('richtext'); });
	$(document).ready(function() {
		$('#head li a[href|="<?php echo base_url() ?><?php echo $this->uri->segment(1) ?><?php echo ($this->uri->segment(2))?'/'.$this->uri->segment(2):'' ?><?php echo ($this->uri->segment(3))?'/'.$this->uri->segment(3):'' ?>"]').addClass('active');
	});
</script>
</head>
<body style="padding: 10px;">
   <div class="right main-thickbox">
      <?php $this->load->view($main_content); ?>
   </div>
</body>
</html>





