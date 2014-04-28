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

    <form action="<?php print base_url() . '/hrm/salary/update_salary'; ?>" method="POST">
        <input type="hidden" id="month" name="month" value="<?php print $month; ?>">
        <input type="hidden" id="year" name="year" value="<?php print $year; ?>">
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
                <th>Chi phí khác(VNĐ)</th>
                <th align="right">Tổng(VNĐ)</th>
            </tr>
            <?php
            $empId = array();
            if (!empty($allEmploy)) {
                $total_pay = 0;
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
                if ($allEmployReturn) {
                    foreach ($allEmployReturn as $employ) {
                        $empId[] = $employ['uid'];
                        $cost = 0;
                        $salary = 0;
                        if (isset($allSalary[$employ['id']])) {
                            $salary = $allSalary[$employ['id']]['value'];
                        }
                        if (isset($allCost[$employ['uid']])) {
                            if (!empty($allCost[$employ['uid']])) {
                                foreach ($allCost[$employ['uid']] as $c) {
                                    $cost += $c['realspend'];
                                }
                            }
                        }
                        $total = $salary + $cost;
                        $total_pay += $total;
                        ?>
                        <tr>
                            <td>
                                <a href="<?php print base_url() . 'hrm/salary/pertotal?uid=' . $employ['uid']; ?>">
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
                                <input type="text" name="salary-<?php print $employ['id']; ?>" class="short-input jformat1" value="<?php print $salary; ?>" readonly="readonly" style="width: 100px;text-align: left;">
                            </td>
                            <td align="center">
                                <input type="text" name="cost-<?php print $employ['id']; ?>" class="short-input jformat1" value="<?php print $cost; ?>" readonly="readonly" style="width: 100px;text-align: left;">
                            </td>
                            <td align="right">
                                <input type="text" name="total-<?php print $employ['id']; ?>" class="short-input jformat1" value="<?php print $total; ?>" readonly="readonly" style="width: 100px;text-align: left;">
                            </td>
                        </tr>
                        <?php
                    }
                } 
            }else {
                    echo '<tr><td><span style="color:red">Dữ liệu đang được cập nhập<span></td></tr>';
                }
            ?>
            <?php if (isset($allEmployReturn)) { ?>
                <tr class="action">
                    <td colspan="4" align="left">
                        <b>Tổng</b>
                    </td>
                    <td colspan="1" align="right">
                        <input class="jformat1" value="<?php print $total_pay; ?>" style="width: 100px;border: none;text-align: right;color: red;" type="text" readonly="readonly" id="total-cost">
                        <b>VNĐ</b>
                    </td>
                </tr>
            <?php } ?>
            <!--<tr class="action">
                <td colspan="8" align="center">
                    <input type="submit" value="Cập nhật" name="submit" class="button">
                </td>
            </tr>-->
        </table>
        <input type="hidden" name="allEmployId" value="<?php print implode(',', $empId); ?>">
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.jformat1').formatNumber({format:"#,###", locale:"vn"});
    });
</script>





