<div class="pro-info wrap-main">
	<!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>
   
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI();
	print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
	<div>
        <div>
            <div>
                <?php if (isset($query) && is_array($query) && count($query) > 0) : ?>
                    <table width="100%" border="1" bordercolor="#f2f2f2" cellspacing="3" class="tbl-template-2">
                        <tr>
                            <td colspan="7" class="box-message">
                                <?php print Box::showMessage(); ?>
                            </td>
                        </tr>
                        <tr class="title">
                            <th width="4%" class="stt">STT</th>
                            <th align="left">Tên nhân viên</th>
                            <th align="center">Chức vụ</th>
                            <th width="120">QL chấm công</th>
                            <th width="120">QL bằng cấp</th>
                            <th width="120">QL quyền lợi</th>
                            <th width="7%">Sửa</th>
                            <th width="7%">Xóa</th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($query as $row):
                            $id = $row->id;
                            $name = $row->fullname;
                            $linkEdit = base_url() . 'hrm/employee/edit/' . $id;
                            $isactive = $row->status;
                            $posName = '';
                            if ($row->position_id > 0) {
                            	if (isset($position[$row->position_id])) {
                            		$posName = $position[$row->position_id]['name'];
                            	}
									 }
                            ?>
                            <tr align="center" id="ms">
                                <td align="center"><b><?php print $i; ?></b></td>
                                <td align="left"><a href="<?php echo base_url() . 'hrm/employee/edit/' . $id ?>"><?= $name ?></a></td>
                                <td align="left"><?php print $posName; ?></td>
                                <td><a href="<?php print base_url() . 'hrm/reportlog?uid=' . $row->uid; ?>">Chấm công</a></td>
                                <td><a href="<?= base_url() . 'hrm/employeeDegree/?employee_id=' . $id?>"><span>Bằng cấp</span></a></td>
                                <td><a href="<?= base_url() . 'hrm/benefitemployee/edit?uid=' . $row->uid ?>"><span>Quyền lợi</span></a></td>
                                <td>
                                    <a href="<?= $linkEdit ?>">
                                        <img alt="" src="<?php print base_url() . 'public/template/iso/images/edit.png'; ?>">
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="cpanel.deleted($(this), <?php echo $id ?>, '<?= $actionDel ?>');" >
                                        <img alt="" src="<?php print base_url() . 'public/template/iso/images/pro-delete.png'; ?>">
                                    </a>
                                </td>
                            </tr>
                            <?php $i++;
                        endforeach; ?>
                        <tr class="action">
                            <td colspan="7">
                                <?php echo $pagination ?>
                            </td>
                        </tr>
                    </table>
                <?php else: ?>
                    <p style="color:#f00;">Dữ liệu đang được cập nhật.</p>
                <?php endif; ?>
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".deletemulti").click(function(){
            var TABLE = $(this).attr("value");							 
            if(confirm("Bạn muốn xóa những mục đã chọn này không ?")){	
                var val = [];
                $('input:checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                    $(this).parent().parent().remove();	
                })
                $.post("<?php echo base_url() . 'hrm/employee/deletemulti' ?>", { ids : val, table : TABLE } );	
            }
        });
    });
</script>
<script type="text/javascript">
    $(function(){
        $("#selectall").click(function () {
            $('.case').attr('checked', this.checked);
        });
        $(".case").click(function(){
            if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
            } else {
                $("#selectall").removeAttr("checked");
            }
        });
    });
</script>