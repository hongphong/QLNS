<div class="pro-info wrap-main">
    <!-- NAVIGATION -->
    <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>

    <!-- MENU FUNCTION -->
    <?php $tmp = Box::boxFuncI();
    print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

    <!-- SELECT BOX -->
    <div style="margin: 10px 0px;" class="sel-box-wrap">
        <form method="post" action="/hrm/reportlog/dayoffyear">
            <table width="60%" cellspacing="5" cellpadding="5">
                <tbody><tr>
                        <td width="120">
                            <b>Năm</b>
                            <select name="year" class="sel-box">
                                <?php
                                for ($i = 2003; $i <= 2030; $i++) {
                                    if ($i == $year) {
                                        echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
                                    }else{
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" style="padding: 0px 10px;" value="Chọn">
                        </td>
                    </tr>
                </tbody></table>
        </form>
    </div>

    <form action="" method="post">
        <table id="logon-time" width="100%" bordercolor="#d8d8d8" border="1" style="border-collapse: collapse;">
            <?php
            if (!empty($employ)) {
                $i = 0;
                foreach ($employ as $dep => $emp) {

                    foreach ($emp as $em) {
                        $t_np = 0;
                        $t_nl = 0;
                        $t_nkl = 0;
                        $i++;
                        if ($i == 1) {
                            ?>
                            <tr>
                                <td width="200" align="center"><b>Nhân viên</b></td>
                                <td align="center" style="border: none;">
                                    <table id="" width="100%">
                                        <tr>
                                            <?php
                                            $d = 0;
                                            for ($d = 1; $d <= 12; $d++) {
                                                print '<td style="padding: 0px;border: 0px;" align="center"><b style="width: 20px;display: block;font-size: 11px;">' . $d . '</b></td>';
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </td>
                                <td align="center" style="border: none;"><b>NP</b></td>
                                <td align="center" style="border: none;"><b>NL</b></td>
                                <td align="center" style="border: none;"><b>NKL</b></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td align="left"><?php print $em['fullname']; ?></td>
                                <td align="center" style="border: none;">
                                    <table id="" width="100%" bordercolor="#d8d8d8" border="1" style="border-collapse: collapse;">
                                        <tr>
                                            <?php
                                            $class = '';
                                            for ($h = 1; $h <= 12; $h++) {
                                                $np = 0;
                                                $nl = 0;
                                                $nkl = 0;
                                                foreach ($dayoff as $key => $value) {
                                                    if ($value['employ_id'] == $em['id']) {
                                                        if ($value['month'] == $h) {
                                                            if ($value['reason'] == 1) {
                                                                $np++;
                                                                $t_np++;
                                                            }
                                                            if ($value['reason'] == 2) {
                                                                $nl++;
                                                                $t_nl++;
                                                            }
                                                            if ($value['reason'] == 3) {
                                                                $nkl++;
                                                                $t_nkl++;
                                                            }
                                                        }
                                                    }
                                                }
                                                $title = $np . ' ngày nghỉ phép' . ', ' . $nl . ' ngày nghỉ lễ, ' . $nkl . ' ngày nghỉ không lương';
                                                ?>
                                                <td class="dayoff-wrap" align="center">
                                                    <div class="dayoff-item" style="color:black" title="<?php echo $title ?>">
                                                        <?php echo $np . ',' . $nl . ',' . $nkl; ?>
                                                    </div>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </td>
                                <td align="center" style="border: none;">
                                    <input class="total-nl" id="" type="text" name="" value="<?php echo $t_np ?>" />
                                </td>
                                <td align="center" style="border: none;">
                                    <input class="total-nl" id="" type="text" name="" value="<?php echo $t_nl ?>" />
                                </td>
                                <td align="center" style="border: none;">
                                    <input class="total-nl" id="" type="text" name="" value="<?php echo $t_nkl ?>" />
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
            ?>
        </table>
    </form>
</div>



