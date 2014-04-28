<!-- POPUP MODAL -->
<meta content="text/html" charset="utf-8">
<link href="<?php print base_url() ?>public/template/iso/css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php print base_url() . 'public/template/iso/js/jquery-1.8.3.js'; ?>"></script>
<script type="text/javascript" src="<?php print base_url() . 'public/template/iso/js/jquery.reveal.js'; ?>"></script>
<link rel="stylesheet" href="<?php print base_url() . 'public/template/iso/css/reveal.css'; ?>" />
<link rel="stylesheet" href="<?php print base_url() . 'public/template/iso/css/vfog.css'; ?>" />

<style>
body a { font-size: 12px !important; }
</style>

<?php if (!empty($allTask[1]) || !empty($allTask['newUpdate']) || !empty($allTask['important'])) { ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#modalListWork').reveal({
            animation: 'fade',
            animationspeed: 200,
            closeonbackgroundclick: true,
            dismissmodalclass: 'close-reveal-modal'
        });
	});
</script>
<?php  } ?>

<div id="modalListWork" class="reveal-modal" style="visibility: hidden;width: 600px;">
	<?php $this->load->view('home/task/task_new'); ?>
	
	<?php $this->load->view('home/task/task_executive'); ?>
	
	<?php $this->load->view('home/task/task_important'); ?>
</div>
