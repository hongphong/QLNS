<script type="text/javascript" src="<?php print base_url() . 'public/template/iso/js/jshashtable-3.0.js' ?>"></script>
<script type="text/javascript" src="<?php print base_url() . 'public/template/iso/js/jquery.numberformatter-1.2.3.js' ?>"></script>

<div class="pro-info wrap-main">
    <!-- NAVIGATION -->
    <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>

    <!-- MENU FUNCTION -->
    <?php $tmp = Box::boxFuncI();
    print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

    <form action="<?php print base_url() . 'hrm/salary/update_cost'; ?>" method="POST">
        <input type="hidden" id="month" name="month" value="<?php print $month; ?>">
        <input type="hidden" id="year" name="year" value="<?php print $year; ?>">
        <input type="hidden" name="uid" value="<?php print $_GET['uid']; ?>">
        <input type="hidden" name="listId" value="<?php print $listId; ?>">
        <table class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
            <tr>
                <td class="box-message" colspan="8">
                    <?php print Box::showMessage(); ?>
                    <?php print Box::showMessage('errac'); ?>
                </td>
            </tr>
            <tr class="title">
                <th align="left">Tên chi phí</th>
                <th align="left">Đơn vị</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>Thực chi</th>
                <th>Đơn vị tiền</th>
            </tr>
            <?php
            if (!empty($userBenefit)) {
                $userTotalCost = 0;
                foreach ($userBenefit as $benefit) {
                    if($benefit['realspend'] > 0){
                        $userTotalCost += $benefit['realspend'];
                    }else{
                        $userTotalCost += $benefit['money'];
                    }
                    ?>
                    <tr>
                        <td>
                            <?php print $benefit['name']; ?>
                        </td>
                        <td>
                            / <?php print $benefit['per_unit']; ?>
                        </td>
                        <td align="center">
                            <input name="quantity-<?php print $benefit['id']; ?>" benefit="<?php print $benefit['id']; ?>" class="short-input" value="<?php print $benefit['quantity']; ?>" onchange="change_money(this);" type="text">
                        </td>
                        <td align="center">
                            <input style="width: 100px;text-align: left;" name="price-<?php print $benefit['id']; ?>" id="bprice-<?php print $benefit['id']; ?>" class="short-input jformat1" value="<?php print $benefit['price']; ?>" type="text" readonly="readonly">
                        </td>
                        <td align="center">
                            <input style="width: 100px;text-align: left;" name="money-<?php print $benefit['id']; ?>" id="bmoney-<?php print $benefit['id']; ?>" class="short-input jformat1" value="<?php print $benefit['money']; ?>" readonly="readonly" type="text">
                        </td>
                        <td align="center">
                            <input style="width: 100px;text-align: left;" name="realspend-<?php print $benefit['id']; ?>" class="short-input" value="<?php print ($benefit['realspend'] > 0)?$benefit['realspend']:$benefit['money']; ?>" type="text" />
                        </td>
                        <td align="center">
                            <?php
                            if (!empty($unit)) {
                                foreach ($unit as $u) {
                                    if ($u->id == $benefit['unit'])
                                        print $u->unit;
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr class="action">
                <td colspan="5" align="left">
                    <b>Tổng chi phí</b>
                </td>
                <td colspan="3" align="right">
                    <input class="jformat1" value="<?php print $userTotalCost; ?>" style="width: 100px;border: none;text-align: right;color: red;" type="text" readonly="readonly" id="total-cost"><b>VNĐ</b>
                </td>
            </tr>
            <tr class="action">
                <td colspan="8" align="center">
                    <input type="submit" value="Cập nhật" name="submit" class="button">
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.jformat1').formatNumber({format:"#,###", locale:"vn"});
    });

    function fmnb(obj) {
        $(obj).formatNumber({format:"#,###", locale:"vn"});
    }

    function change_money(obj) {
        var quantity = parseInt($(obj).val());
        var benefit = $(obj).attr('benefit');
        var temp = $('#bprice-'+benefit).val();
        var price = $.parseNumber(temp, {format:"#,###", locale:"vn"});
        var money = parseFloat(quantity * price);
        $('#bmoney-'+benefit).val(money);
        $('#bmoney-'+benefit).formatNumber({format:"#,###", locale:"vn"});
    }
</script>





