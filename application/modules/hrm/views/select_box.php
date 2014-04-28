<div class="sel-box-wrap" style="margin: 10px 0px;">
    <form action="<?php print $_SERVER['REQUEST_URI']; ?>" method="post">
        <table width="60%" cellpadding="5" cellspacing="5">
            <tr>
                <?php
                if ($this->uri->segment(2) != 'reportlog') {
                    ?>
                    <td>
                        <b>Phòng ban</b>
                        <select class="sel-box" width="100%" name="d">
                            <option>- Chọn phòng ban -</option>
                            <?php
                            if (!empty($allDepart)) {
                                foreach ($allDepart as $depart) {
                                    $sel = '';
                                    if ($department == $depart['id'])
                                        $sel = 'selected="selected"';
                                    ?>
                                    <option <?php print $sel; ?> value="<?php print $depart['id']; ?>"><?php print $depart['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <?php
                }
                ?>
                <td width="150">
                    <b>Tháng</b>
                    <select class="sel-box" name="m">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $sel = '';
                            if ($month == $i)
                                $sel = 'selected="selected"';
                            ?>
                            <option <?php print $sel; ?> value="<?php print $i; ?>"><?php print $i; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td width="120">
                    <b>Năm</b>
                    <select class="sel-box" name="y">
                        <?php
                        $cur = date('Y');
                        for ($i = $cur - 10; $i <= $cur + 10; $i++) {
                            $sel = '';
                            if ($year == $i)
                                $sel = 'selected="selected"';
                            ?>
                            <option <?php print $sel; ?> value="<?php print $i; ?>"><?php print $i; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Chọn" style="padding: 0px 10px;">
                </td>
            </tr>
        </table>
    </form>
</div>

