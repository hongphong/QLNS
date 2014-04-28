<div class="pro-info wrap-main">
    <!-- MENU FUNCTION -->
    <?php $tmp = Box::boxFuncI();
    print $tmp[0] . '<div class="clear"></div>' . $tmp[1]; ?>
    <div>
        <?php
        if ($this->session->flashdata('error')):
            echo '<div id="display_error">
						  ' . $this->session->flashdata('error') . '
					  </div>';
        endif;
        if ($this->session->flashdata('success')):
            echo '<div id="success">
						  ' . $this->session->flashdata('success') . '
					  </div>';
        endif;
        ?>
        <div id="md03">
            <script type="text/javascript"> 
                $(document).ready(function() {
                    $("#benefit option[value='<?php echo $query->benefit_id ?>']").attr('selected', 'selected');
                    $("#position option[value='<?php echo $query->position_id ?>']").attr('selected', 'selected');
                    $("#unit option[value='<?php echo $query->unit ?>']").attr('selected', 'selected');
                });
            </script>
            <div class="content">
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="formAction">
                    <input type="hidden" name="id"  value="<?php echo $query->id ?>"/>
                    <table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="">
                        <tr height="30" style="color:#000;">
                            <td align="20%">
                                <select name="input[department_id]" id="department" class="validate[required]">
                                    <option value="">- Phòng ban -</option>
                                    <?php
                                    if ($depart) {
                                        foreach ($depart as $dep) {
                                            $sel = '';
                                            if ($dep['id'] == $query->department_id)
                                                $sel = 'selected="selected"';
                                            print '<option ' . $sel . ' value="' . $dep['id'] . '">' . $dep['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select> 	
                            </td>
                            <td align="20%">
                                <select name="input[position_id]" id="position" class="validate[required]">
                                    <option value="">Chức vụ</option>
                                    <?php
                                    if (isset($position) && count($position) > 0 && is_array($position)):
                                        foreach ($position as $row):
                                            echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </td>
                            <td width="30%">
                                <select name="input[benefit_id]" id="benefit" class="validate[required]">
                                    <option value="">Quyền lợi</option>
                                    <?php
                                    if (isset($benefit) && count($benefit) > 0 && is_array($benefit)):
                                        foreach ($benefit as $row):
                                            echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr height="30" style="color:#000;">
                            <td>
                                <input type="text" name="input[limitation]" class="validate[required]" id="limitation" placeholder="Quyền lợi định mức tối đa" value="<?php echo $query->limitation ?>"/>
                            </td>
                            <td>
                                <select name="input[unit]" id="unit" class="validate[required]">
                                    <option value="">Đơn vị tiền tệ</option>
                                    <?php
                                    if (isset($unit) && count($unit) > 0 && is_array($unit)):
                                        foreach ($unit as $row):
                                            echo '<option value="' . $row->id . '">' . $row->unit . '</option>';
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </td>
                            <td></td>
                        </tr>
                        <tr height="50" style="color:#000; text-align:center;">
                            <td width="100%" colspan="3">
                                <button name="submit" value="submit">Cập nhật</button>
                            </td>
                        </tr>  
                    </table>
                </form>	
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>

<script language="javascript">
    var doing=false;
    $("#cid").change(function(){
        if (doing)
            return;
        doing=true;					
        //$("#loading_district").show();
        $.post("/hrm/company/location", 
        {id: $("#cid").val()}, 
        function(data){ 
            data = "<option value = '0' selected='selected'>Quận/Huyện</option>"+data;
            $("#did").html(data);
            $("#did").val(0);
            //$("#loading_district").hide();
            doing=false;
        }
    );
    });
	
    $("#company").change(function(){
        if (doing)
            return;
        doing=true;					
        //$("#loading_district").show();
        $.post("/hrm/position/location", 
        {id: $("#company").val()}, 
        function(data){ 
            data = "<option value = '' selected='selected'>Trực thuộc phòng ban</option>"+data;
            $("#department").html(data);
            $("#department").val(0);
            doing=false;
        }
    );
    });
	
    $("#department").change(function(){
        if (doing)
            return;
        doing=true;					
        //$("#loading_district").show();
        $.post("/hrm/employee/location", 
        {id: $("#department").val()}, 
        function(data){ 
            data = "<option value = '0' selected='selected'>Chức vụ</option>"+data;
            $("#position").html(data);
            $("#position").val(0);
            //$("#loading_district").hide();
            doing=false;
        }
    );
    });
	
    jQuery(document).ready(function(){
        jQuery("#formAction").validationEngine('attach', {promptPosition : "topLeft", autoPositionUpdate : true});
    });
</script>