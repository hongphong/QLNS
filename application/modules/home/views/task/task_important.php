<div>
	<?php
	if (!empty($allTask['important'])) {
		?>
		<b class="title-work" style="margin-bottom: 10px;"><font color="red">Việc khẩn cấp</font></b>
		<input class="close-reveal-modal" value="X" type="button" style="border: none;cursor: pointer;padding: 2px 0px 2px 10px;float: right;position: absolute;right: 10px;top: 5px;" title="Đóng cửa sổ">
		<ul class="wrap-task">
		<?php
		foreach ($allTask['important'] as $work) {
			switch ($work['type']) { 
				case 'step': $url = base_url() . 'iso/step/detail/' . $work['step_id']; break;
				case 'phase': $url = base_url() . 'iso/phase/detail/' . $work['step_id']; break;
				case 'transaction': {
					$this->load->model('iso/TransactionModel', 'transaction');
					$temp = $this->transaction->get_transaction('id,step_id', 'id='.$work['step_id']);
					$url = base_url().'iso/step/detail/'.$temp[0]['step_id'];
					break;
				}
				default: $url = base_url() . 'iso/step/detail/' . $work['step_id']; break;
			}
			?>
			<li style="overflow: hidden;">
				<table width="99%" boder="1" bordercolor="#f2f2f2" class="task-table">
					<tr>
						<td>
							<?php
							$label = '';
							switch ($work['type']) {
								case 'step': $label = 'Bước'; break;
								case 'phase': $label = 'Giai đoạn'; break;
								case 'transaction': $label = 'Việc'; break;
							}
							print $label;
							?>
						</td>
						<td width="50%">
							<a target="_blank" href="<?php print $url; ?>">
								<?php print $work['step_name']; ?>
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
		print '</ul>';
	}
	?>
</div>
<?php if (!empty($allTask['important'])) print '<br>'; ?>



