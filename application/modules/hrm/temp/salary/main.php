
<div class="pro-info wrap-main">
    <!-- NAVIGATION -->
    <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>

    <!-- MENU FUNCTION -->
    <?php $tmp = Box::boxFuncI();
    print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

    <!-- SELECT BOX -->
    <?php $this->load->view('salary/select_box'); ?>

    <form action="<?php print base_url() . 'hrm/salary/update_salary'; ?>" method="POST">
        <input type="hidden" id="month" name="month" value="<?php print $month; ?>">
        <input type="hidden" id="year" name="year" value="<?php print $year; ?>">
        <input type="hidden" name="redirect" value="<?php print $_SERVER['REQUEST_URI']; ?>">
        <table class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
            <tr>
                <td class="box-message" colspan="9">
                    <?php print Box::showMessage(); ?>
                    <?php print Box::showMessage('errac'); ?>
                </td>
            </tr>
            <tr class="title">
                <th align="left">Họ và tên</th>
                <th align="left">Phòng ban</th>
                <th>Giờ làm 1.0</th>
                <th>1.5</th>
                <th>2.0</th>
                <td>NKL</td>
                <th>Tổng giờ làm</th>
                <th>Lương / giờ(VNĐ)</th>
                <th>Tổng lương(VNĐ)</th>
            </tr>
            <?php
            //var_dump($allEmploy);die;
            $allSalary = 0;
            if (!empty($allEmploy)) {

                $allEmployReturn = array();
                $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                if ($emInfo['job_level'] == 3) {
                    $allEmployReturn = $allEmploy;
                }
                if ($emInfo['job_level'] == 2) {
                    foreach ($allEmploy as $key => $value) {
                        if ($value['department_id'] == $emInfo['department_id']) {
                            $allEmployReturn[] = $value;
                        }
                    }
                }
                if ($emInfo['job_level'] == 1) {
                    foreach ($allEmploy as $key => $value) {
                        if ($value['id'] == $emInfo['id']) {
                            $allEmployReturn[] = $value;
                        }
                    }
                }
                foreach ($allEmployReturn as $employ) {
                    //xu ly view theo quyền
                    $tw10 = $num * 8;
                    $dayoff = 0;
                    $houseoff = 0;
                    if (isset($nkl)) {
                        foreach ($nkl as $key_n => $value_n) {
                            if ($employ['id'] == $value_n['employ_id'] && $value_n['reason'] == 3) {
                                $dayoff++;
                            }
                        }
                    }
                    $houseoff = $dayoff * 8;
                    $tw15 = 0;
                    $tw20 = 0;
                    $empId[] = $employ['id'];
                    if (isset($allTimeWork[$employ['id']])) {
                        $tw = $allTimeWork[$employ['id']];
                        if ($tw['tw10'] > 0) {
                            $tw10 = $tw['tw10'];
                        }
                        if ($tw['tw15'] > 0) {
                            $tw15 = $tw['tw15'];
                        }
                        if ($tw['tw20'] > 0) {
                            $tw20 = $tw['tw20'];
                        }
                    }
                    $total = $tw10 + ($tw15 * 1.5) + ($tw20 * 2);
                    $total = $total - $houseoff;
                    $totalSalary = $employ['salary_per_hour'] * $total;

                    $allSalary += $totalSalary;
                    ?>
                    <tr>
                        <td>
                            <a href="<?php print base_url() . 'hrm/salary/cost?uid=' . $employ['uid']; ?>">
                                <?php print $employ['fullname']; ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            if (!empty($allDepart)) {
                                foreach ($allDepart as $depart) {
                                    if ($depart['id'] == $employ['department_id']) {
                                        print $depart['name'];
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td align="center">
                            <input employ="<?php print $employ['id']; ?>" id="<?php print $employ['id'] . '-10'; ?>" onchange="change_time_work(this);" level="10" type="text" name="wt10" class="short-input" value="<?php print $tw10; ?>">
                        </td>
                        <td align="center">
                            <input employ="<?php print $employ['id']; ?>" id="<?php print $employ['id'] . '-15'; ?>" onchange="change_time_work(this);" level="15" type="text" name="wt15" class="short-input" value="<?php print $tw15; ?>">
                        </td>
                        <td align="center">
                            <input employ="<?php print $employ['id']; ?>" id="<?php print $employ['id'] . '-20'; ?>" onchange="change_time_work(this);" level="20" type="text" name="wt20" class="short-input" value="<?php print $tw20; ?>">
                        <td><?php echo $houseoff ?><input type="hidden" id="dayoff_<?php echo $employ['id'] ?>" value="<?php echo $houseoff ?>"/></td>
                        </td>
                        <td align="center">
                            <input type="text" value="<?php print $total; ?>" id="<?php print $employ['id']; ?>-total-work-time" disabled="disabled" class="short-input" style="width: 50px;">
                        </td>
                        <td align="center">
                            <input type="text" id="<?php print $employ['id'] . '-salary-per-hour'; ?>" value="<?php print $employ['salary_per_hour']; ?>" disabled="disabled" class="short-input jformat" style="width: 80px;text-align: right;">
                        </td>
                        <td align="center">
                            <input type="text" id="<?php print $employ['id'] . '-salary'; ?>" name="<?php print $employ['id'] . '-salary'; ?>" value="<?php print $totalSalary; ?>" readonly="readonly" class="short-input jformat" style="width: 100px;text-align: right;">
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr class="action">
                <td colspan="7" align="left">
                    <b>Tổng lương</b>
                </td>
                <td colspan="2" align="right">
                    <input class="jformat" value="<?php print $allSalary; ?>" style="width: 100px;border: none;text-align: right;color: red;" type="text" readonly="readonly">
                    <b>VNĐ</b>
                </td>
            </tr>
            <tr class="action">
                <td colspan="9" align="center">
                    <input type="submit" class="button" value="Cập nhật" name="submit">
                </td>
            </tr>
        </table>
        <input type="hidden" name="allEmployId" value="<?php print (!empty($empId)) ? implode(',', $empId) : ''; ?>">
    </form>
</div>

<script type="text/javascript">
    function change_time_work(obj) {
        var value = $(obj).val();
        var level = $(obj).attr('level');
        var employ = $(obj).attr('employ');
        var tw10 = parseFloat($('#'+employ+'-10').val());
        var tw15 = parseFloat($('#'+employ+'-15').val()) * 1.5;
        var tw20 = parseFloat($('#'+employ+'-20').val()) * 2;
        var houseoff = parseFloat($('#dayoff_'+employ).val());
        var totalTW = parseFloat(tw10 + tw15 + tw20 - houseoff);
        var month = $('#month').val();
        var year = $('#year').val();
        var salPer = $('#'+employ+'-salary-per-hour').val();
        salPer = $.parseNumber(salPer, {format:"#,###", locale:"vn"});
        var totalSalary = totalTW * salPer;
	
        $('#'+employ+'-salary').val(totalSalary);
        $('#'+employ+'-salary').formatNumber({format:"#,###", locale:"vn"});
        $('#'+employ+'-total-work-time').val(totalTW);
	
        update_time_work(employ,level,month,year,value);
    }

    function update_time_work(employ, level, month, year, value) {
        $.ajax({
            type: 'POST',
            url: '/hrm/salary/update_time_work',
            data: {
                employ_id: employ,
                level: level,
                month: month,
                year: year,
                value: value
            }
        });
    }
</script>





