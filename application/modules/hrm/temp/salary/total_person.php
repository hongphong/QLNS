<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jshashtable-3.0.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url().'public/template/iso/js/jquery.numberformatter-1.2.3.js' ?>"></script>

<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
	<div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
	
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
	<form action="<?php print base_url().'hrm/salary/update_salary'; ?>" method="POST">
		<table class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
			<tr>
				<td class="box-message" colspan="8">
					<?php print Box::showMessage(); ?>
					<?php print Box::showMessage('errac'); ?>
				</td>
			</tr>
			<tr class="title">
				<th align="left">Họ và tên</th>
				<th align="left">Phòng ban</th>
				<th>Lương(VNĐ)</th>
				<th align="right">Chi phí khác(VNĐ)</th>
			</tr>
			<?php
			if ($userSalary) {
				$totalCost = 0;
				if (!empty($allCost)) {
					foreach ($allCost as $c) {
						$totalCost += $c['realspend'];
					}
				}
				$Total = $totalCost + $userSalary->value;
				?>
				<tr>
					<td>
						<a href="<?php print $_SERVER['REQUEST_URI']; ?>">
							<?php print $userInfo['fullname']; ?>
						</a>
					</td>
					<td>
						<?php
						if (!empty($allDepart)) {
							foreach ($allDepart as $depart) {
								if ($depart['id'] == $userInfo['department_id']) {
									print $depart['name'];
								}
							}
						}
						?>
					</td>
					<td align="center">
						<input type="text" name="salary" class="short-input jformat" value="<?php print $userSalary->value; ?>" readonly="readonly" style="width: 100px;text-align: left;">
					</td>
					<td align="right">
						<input type="text" name="cost" class="short-input jformat" value="<?php print $totalCost; ?>" readonly="readonly" style="width: 100px;text-align: left;">
					</td>
				</tr>
				<tr class="action">
					<td colspan="3" align="left">
						<b>Tổng</b>
					</td>
					<td align="right">
						<input class="jformat" value="<?php print $Total; ?>" style="width: 100px;border: none;text-align: right;color: red;" type="text" readonly="readonly" id="total-cost">
						<b>VNĐ</b>
					</td>
				</tr>
			<?php
			} else {
			?>
				<tr class="action">
					<td colspan="4">
						<p>Chưa có dữ liệu lương tháng <b><?php print $month; ?></b>/<b><?php print $year; ?></b> của <b><?php print $userInfo['fullname']; ?></b></p>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.jformat').formatNumber({format:"#,###", locale:"vn"});
});
</script>





