<div class="left" style="width:20%;">
	<div id="md01" class="boxLeft">
    	<div class="head">
        	<img src="<?= base_url() ?>public/template/hrm/images/md01_head.png" /> Danh s&aacute;ch ph&ograve;ng ban
		</div>
        <div class="content">
            <ul class="menuleft">
            	<?php
            	if (!empty($depart)) {
            		foreach ($depart as $dep) {
            			?>
            			<li>
            				<a class="p-icon" onclick="oc(this);" href="javascript:void(0)">
                           <img src="<?php print base_url().'public/template/iso/images/c.png'; ?>"/>
                        </a>
		                	<a class="p-name"><?php print $dep['name']; ?></a>
		                	<?php
		                	if (!empty($employ[$dep['id']])) {
			                	?>
			                	<ul class="appear">
			                		<?php
			                		foreach ($employ[$dep['id']] as $em) {
				                		?>
				                		<li>
											<div>
												<a href="<?php print base_url().'hrm/employee/detail/'. $em['id']; ?>"><?php print $em['fullname']; ?></a>
											</div>
										</li>
										<?php
			                		}
									?>
			                	</ul>
			                	<?php
		                	}
		                	?>
		                </li>
            			<?php
            		}
            	}
            	?>
            </ul>
        </div>
        <div class="footer">
        	<img src="<?= base_url() ?>public/template/hrm/images/md01_footer.png" />
        </div>
    </div>
</div>

<script type="text/javascript">
function oc(obj) {
	var obb = $(obj);
	var ul = obb.parent().find('ul');
	var display = ul.attr('class');
	if (display == 'appear') {
		obb.html('<img src="/public/template/iso/images/o.png">');
		ul.attr('class', 'disappear');
	} else if (display == 'disappear') {
		obb.html('<img src="/public/template/iso/images/c.png">');
		ul.attr('class', 'appear');
	}
}
</script>
