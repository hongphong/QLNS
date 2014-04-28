<div>
<?php
if (!empty($allTask)) {
	if (!empty($allTask[3])) {
		?>
		<b class="title-work" style="margin-bottom: 10px;"><font color="red">Việc tôi theo dõi</font></b>
		<input class="close-reveal-modal" value="X" type="button" style="border: none;cursor: pointer;padding: 2px 0px 2px 10px;float: right;position: absolute;right: 10px;top: 5px;" title="Đóng cửa sổ">
		<ul class="wrap-task">
			<?php if (!empty($projectMornitor)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php
						$projectMornitor = super_sort($projectMornitor, 'duration', 'ASC');
						foreach ($projectMornitor as $taskMornitor) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'project/detail/' . $taskMornitor['iso_id']; ?>">
										<?php print $taskMornitor['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskMornitor['duration']); ?></td>
							</tr>
						<?php } ?>
					</table>
				</li>
			<?php } if (!empty($phaseMornitor)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php
						$phaseMornitor = super_sort($phaseMornitor, 'duration', 'ASC'); 
						foreach ($phaseMornitor as $taskMornitor) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'phase/detail/' . $taskMornitor['iso_id']; ?>">
										<?php print $taskMornitor['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskMornitor['duration']); ?></td>
							</tr>
						<?php } ?>
					</table>
				</li>
			<?php } if (!empty($stepMornitor)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php
						$stepMornitor = super_sort($stepMornitor, 'duration', 'ASC');
						foreach ($stepMornitor as $taskMornitor) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'step/detail/' . $taskMornitor['iso_id']; ?>">
										<?php print $taskMornitor['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskMornitor['duration']); ?></td>
							</tr>
						<?php } ?>
					</table>
				</li>
			<?php } ?>
		</ul>
		<?php
	}
}
?>
</div>
<?php if (!empty($allTask[3])) print '<br>'; ?>




