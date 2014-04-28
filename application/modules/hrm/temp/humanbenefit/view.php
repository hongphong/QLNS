<div class="pro-info wrap-main">
	<!-- MENU FUNCTION -->
	<?php $tmp = Box::boxFuncI(); print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
	
    <div>
    	<div>
            <div>
            	<table class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
            		<tr>
            			<td class="box-message" colspan="8">
            				<?php print Box::showMessage(); ?>
            				<?php print Box::showMessage('errac'); ?>
            			</td>
            		</tr>
                    <tr class="title">
                        <th width="4%" class="stt">STT</th>
                        <th align="left">Tên quyền lợi</th>
                        <th align="left">Tên phòng ban</th>
                        <th align="left">Tên chức vụ</th>
                        <th width="15%">Phí định mức</th>
                        <th width="10%">Ngày tạo</th>
                        <th width="7%">Sửa</th>
                        <th width="7%">Xóa</th>
                    </tr>
                	<?php
                	if (isset($query) && is_array($query) && count($query) > 0) {
						$stt = 0;
						foreach ($query as $row) { 
							$stt++;
							$id 	  = $row->id;
							$name     = $row->name;
							$limit    = number_format($row->limitation);
							$request  = isset($_GET['name'])?'/?name='.$_GET['name']:'';
							$unit	  = '<span style="color:#f00; font-weight:bold;">'.$row->unit.'</span>';
							$linkEdit = base_url().'hrm/humanbenefit/edit/'.$id.$request;
							$date     = $row->created;
							$depart   = $row->department;
							$position = $row->position_name;
		                    ?>
		                    <tr>
		                        <td align="center"><b><?php print $stt; ?></b></td>
		                        <td align="left">
		                            <?php print $name; ?>
		                        </td>
		                        <td><?= $depart ?></td>
		                        <td><?= $position ?></td>
		                        <td align="right" style="padding-right:3px;"><?= $limit.' VNĐ' ?></td>
		                        <td align="center"><?= date(FORMAT_DATE, $date) ?></td>
		                        <td align="center"><a href="<?= $linkEdit ?>" class="edit-project"></a></td>
		                        <td align="center">
		                            <a href="javascript:;" onclick="cpanel.deleted($(this), <?php echo $id ?>, '<?= $actionDel ?>');" class="delete-project"></a>
		                        </td>
		                    </tr>
		                    <?php
						}
					} else { 
						?>
	                	<tr>
	                    	<td align="left" colspan="8">
	                    		<p style="color:#f00;padding-left: 10px;">Dữ liệu đang được cập nhật.</p>
	                    	</td>
	                    </tr>
		                <?php
					} 
					?>
	                <tr class="action">
                    	<td colspan="7">
                    		<?php echo $pagination ?>
                    	</td>
                    </tr>
                </table>
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>
