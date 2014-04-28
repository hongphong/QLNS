<div>
<?php
if (!empty($allTask)) {
	if (!empty($allTask[2])) {
		?>
		<b class="title-work" style="margin-bottom: 10px;"><font color="red">Việc tôi phụ trách</font></b>
		<input class="close-reveal-modal" value="X" type="button" style="border: none;cursor: pointer;padding: 2px 0px 2px 10px;float: right;position: absolute;right: 10px;top: 5px;" title="Đóng cửa sổ">
		<ul class="wrap-task">
			<?php if (!empty($projectLead)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php
						$projectLead = super_sort($projectLead, 'duration', 'ASC');
						foreach ($projectLead as $taskLead) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'project/detail/' . $taskLead['iso_id']; ?>">
										<?php print $taskLead['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskLead['duration']); ?></td>
							</tr>
						<?php } ?>
					</table>
				</li>
			<?php } if (!empty($phaseLead)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php
						$phaseLead = super_sort($phaseLead, 'duration', 'ASC'); 
						foreach ($phaseLead as $taskLead) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'phase/detail/' . $taskLead['iso_id']; ?>">
										<?php print $taskLead['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskLead['duration']); ?></td>
							</tr>
						<?php } ?>
					</table>
				</li>
			<?php } if (!empty($stepLead)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php
						$stepLead = super_sort($stepLead, 'duration', 'ASC');
						foreach ($stepLead as $taskLead) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'step/detail/' . $taskLead['iso_id']; ?>">
										<?php print $taskLead['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskLead['duration']); ?></td>
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
<?php if (!empty($allTask[2])) print '<br>'; ?>
