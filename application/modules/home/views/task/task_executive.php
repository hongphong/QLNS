<div>
<?php
if (!empty($allTask)) {
	if (!empty($allTask[1])) {
		?>
		<b class="title-work" style="margin-bottom: 10px;"><font color="red">Việc tôi phụ trách</font></b>
		<ul class="wrap-task">
			<?php if (!empty($stepExecutive)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php 
						$stepExecutive = super_sort($stepExecutive, 'duration', 'ASC');
						foreach ($stepExecutive as $taskExecutive) { 
							?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'project/detail/' . $taskExecutive['iso_id']; ?>">
										<?php print $taskExecutive['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskExecutive['duration']); ?></td>
							</tr>
							<?php
							}
						?>
					</table>
				</li>
			<?php } if (!empty($transactionExecutive)) { ?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<?php 
						$transactionExecutive = super_sort($transactionExecutive, 'duration', 'ASC');
						foreach ($transactionExecutive as $taskExecutive) { 
						?>
							<tr>
								<td width="20">
									<a target="_blank" href="<?php print base_url() . 'phase/detail/' . $taskExecutive['iso_id']; ?>">
										<?php print $taskExecutive['iso_name']; ?>
									</a>
								</td>
								<td width="40%" class="duration"><?php print estimate_time($taskExecutive['duration']); ?></td>
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
<?php if (!empty($allTask[1])) print '<br>'; ?>
