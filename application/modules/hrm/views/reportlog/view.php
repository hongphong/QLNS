<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
	<!-- SELECT BOX -->
	<?php $this->load->view('salary/select_box'); ?>
	
	<table id="logon-time" width="95%" bordercolor="#d8d8d8" border="1" style="border-collapse: collapse;">
		<tr>
			<th align="center" width="50">Ngày</th>
			<th align="center" width="50">Thứ</th>
			<th align="center" style="border: none;">
				<table id="logon-time-label" width="95%" bordercolor="white" border="1" style="border-collapse: collapse;">
					<tr>
						<?php
						for ($i=1,$j=7; $i<=16,$j<=23; $i++,$j++) {
							print '<td align="center"><span>'. $j.':00' .'</span></td>';
						}
						?>
					</tr>
				</table>
			</th>
		</tr>
		<?php
		if ($numday > 0) {
			for ($i=1; $i<=$numday; $i++) {
				if ($i>=1 && $i<=9) $lbDate = '0'.$i; else $lbDate = $i;
				$date = new DateTime($year.'-'.$month.'-'.$i);
				?>
				<tr>
					<td align="center"><?php print $lbDate; ?></td>
					<td align="center"><?php print $date->format('D'); ?></td>
					<td align="center" style="border: none;">
						<table id="logon-time-child" width="95%" bordercolor="#d8d8d8" border="1" style="border-collapse: collapse;">
							<tr>
								<?php
								$class = '';
								for ($h=1; $h<=34; $h++) {
									if (!empty($logAct[$i])) {
										
										foreach ($logAct[$i] as $lg) {
											if ($lg['position'] == $h) {
												if ($lg['action'] == 'start') {
													if ($lg['area'] == 'lan') {
														$class = 'login';
													} else if ($lg['area'] == 'internet') {
														$class = 'login-internet';
													}
												} else if ($lg['action'] == 'end') {
													$class = '';
												}
											}
										}
									}
									?>
									<td class="<?php print $class; ?>" id="h-<?php print $h; ?>"></td>
									<?php
								}
								?>
							</tr>
						</table>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	
</div>
	
	

