
<script type="text/javascript" src="<?php print base_url() . 'public/template/iso/js/jshashtable-3.0.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url() . 'public/template/iso/js/jquery.numberformatter-1.2.3.js' ?>"></script>

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
                <td class="box-message" colspan="8">
                    <?php print Box::showMessage(); ?>
                    <?php print Box::showMessage('errac'); ?>
                </td>
            </tr>
            <tr class="title">
                <th align="left">Họ và tên</th>
                <th align="left">Phòng ban</th>
                <th>Tổng chi phí(VNĐ)</th>
            </tr>
            <?php
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
                $totalCost = 0;
                foreach ($allEmployReturn as $employ) {
                    $perCost = 0;
                    if (!empty($allCost[$employ['uid']])) {
                        foreach ($allCost[$employ['uid']] as $item) {
                            $perCost += $item['realspend'];
                        }
                    }

                    $totalCost += $perCost;
                    ?>
                    <tr>
                        <td>
                            <a href="<?php print base_url() . 'hrm/salary/percost?uid=' . $employ['uid']; ?>">
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
                            <input type="text" style="width: 100px;text-align: left;" class="short-input jformat1" value="<?php print $perCost; ?>" readonly="readonly">
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr class="action">
                <td colspan="2" align="left">
                    <b>Tổng chi phí</b>
                </td>
                <td colspan="1" align="right">
                    <input class="jformat1" value="<?php print $totalCost; ?>" style="width: 100px;border: none;text-align: right;color: red;" type="text" readonly="readonly">
                    <b>VNĐ</b>
                </td>
            </tr>
            <tr class="action">
                <td colspan="8" align="center">
                    <input type="submit" class="button" value="Cập nhật" name="submit">
                </td>
            </tr>
        </table>
        <input type="hidden" name="allEmployId" value="<?php print (!empty($empId)) ? implode(',', $empId) : ''; ?>">
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.jformat1').formatNumber({format:"#,###", locale:"vn"});
    });

    function change_time_work(obj) {
        var value = $(obj).val();
        var level = $(obj).attr('level');
        var employ = $(obj).attr('employ');
        var tw10 = parseFloat($('#'+employ+'-10').val());
        var tw15 = parseFloat($('#'+employ+'-15').val()) * 1.5;
        var tw20 = parseFloat($('#'+employ+'-20').val()) * 2;
        var totalTW = parseFloat(tw10 + tw15 + tw20);
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





