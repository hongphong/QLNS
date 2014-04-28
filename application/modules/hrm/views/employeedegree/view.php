<div class="pro-info wrap-main">
   <!-- NAVIGATION -->
   <div class="navigation"><ul><?php print navigation($navi); ?></ul></div>

   <!-- MENU FUNCTION -->
   <?php $tmp = Box::boxFuncI();
   print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>

   <div>
      <div>
         <div>
            <table class="tbl-template-2" width="100%" border="1" cellspacing="3" bordercolor="#f2f2f2">
               <tr>
                  <td class="box-message" colspan="7">
                     <?php print Box::showMessage(); ?>
                     <?php print Box::showMessage('errac'); ?>
                  </td>
               </tr>
               <tr class="title">
                  <th width="4%" class="stt">STT</th>
                  <th align="left">Tên hồ sơ</th>
                  <th align="left" width="20%">Tên nhân viên</th>
                  <th width="10%">Ngày tạo</th>
                  <th width="10%">Tải về</th>
                  <th width="7%">Sửa</th>
                  <th width="7%">Xóa</th>
               </tr>
               <?php
               $stt = 0;
               if (isset($query) && is_array($query) && count($query) > 0) {
                  foreach ($query as $row) {
                     $stt++;
                     $id = $row->id;
                     $title = $row->name;
                     $name = $row->employee;
                     $request = isset($_GET['name']) ? '/?name=' . $_GET['name'] : '';
                     $linkEdit = base_url() . 'hrm/employeeDegree/edit/' . $id . $request;
                     $date = $row->created;
                     if (is_file('./public/uploads/' . $row->file_attachment)) {
                        $down = base_url() . 'public/uploads/' . $row->file_attachment;
                        $ok_down = 1;
                     } else {
                        $ok_down = 0;
                     }
                     ?>
                     <tr id="ms">
                        <td><b><?php print $stt; ?></b></td>
                        <td align="left">
                           <span><?= $title ?></span>
                        </td>
                        <td align="left">
                           <?php print $row->employee; ?>
                        </td>
                        <td align="center"><?php print date(FORMAT_DATE, $row->created); ?></td>
                        <td align="center">
                           <?php if ($ok_down == 1) { ?>
                              <a href="<?php print $down; ?>">
                                 <img alt="" src="<?php print base_url() . 'public/template/iso/images/download.png'; ?>">
                              </a> 
                           <?php } else { ?>
                              <a href="javascript:void(0)" onclick="alert('File không tồn tại.Vui lòng upload lại file!')">
                                 <img alt="" src="<?php print base_url() . 'public/template/iso/images/download.png'; ?>">
                              </a> 
                           <?php } ?>
                        </td>
                        <td align="center"><a href="<?= $linkEdit ?>" class="edit-project"></a></td>
                        <td align="center">
                           <a href="javascript:;" onclick="cpanel.deleted($(this), <?php echo $id ?>, '<?= $actionDel ?>');" class="delete-project"></a>
                        </td>
                     </tr>
                     <?php
                  }
               } else {
                  ?>
                  <tr class="action">
                     <td align="left" colspan="7">
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
