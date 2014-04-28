<div>
	<?php
	if (!empty($allTask['newUpdate'])) {
		?>
		<b class="title-work" style="margin-bottom: 10px;"><font color="red">Việc mới cập nhật</font></b>
		<input class="close-reveal-modal" value="X" type="button" style="border: none;cursor: pointer;padding: 2px 0px 2px 10px;float: right;position: absolute;right: 10px;top: 5px;" title="Đóng cửa sổ">
		<ul class="wrap-task">
			<?php
			foreach ($allTask['newUpdate'] as $work) { 
				?>
				<li style="overflow: hidden;">
					<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
						<tr>
							<td>
								<a target="_blank" href="<?php print base_url() . 'iso/step/detail/' . $work['step_id'] . '?read=1'; ?>">
									<?php print $work['name'] . ' ['. $work['number'] .']'; ?>
								</a>
							</td>
							<td width="30%" class="duration">
								<?php print estimate_time_v2(time()-$work['time_create']) . ' trước'; ?>
							</td>
						</tr>
					</table>
				</li>
				<?php 
			} 
			?>
		</ul>
		<?php
	}
	?>
</div>
<?php if (!empty($allTask['newUpdate'])) print '<br>'; ?>




