<?php 
$message = $this->session->flashdata('errac');
?>
<div>
	<font color="red"><?php print ($message) ? $message : ''; ?></font>
</div>


