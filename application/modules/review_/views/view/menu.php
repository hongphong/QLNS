<div class="left" style="width:100%;">
    <div id="head">
    	<script type="text/javascript"> 
            $(document).ready(function() {
                $("#user-uid option[value='<?php echo $uid  ?>']").attr('selected', 'selected');
                $("#month option[value='<?php echo $month ?>']").attr('selected', 'selected');
				$("#year option[value='<?php echo $year ?>']").attr('selected', 'selected');
            });
        </script>
    	<form action="/review/view" method="post">
        <ul class="tab">
            <li>
            	<select name="user-uid" id="user-uid">
                	<option value="0">Chọn người dùng</option>
                    <?php 
						if(isset($employee) && is_array($employee) && count($employee) > 0):
							foreach($employee as $row):
								echo '<option value="'.$row['id'].'">'.$row['fullname'].'</option>';
							endforeach;
						endif;
					?>
                </select>
            </li>
            <li>
            	<select name="month" id="month">
                	<option value="0">Tháng</option>
                    <?php
						for($i = 1; $i<= 12; $i++){
							echo '<option value="'.$i.'">'.$i.'</option>';	
						}
					?>
                </select>
            </li> 
            <li>
            	<select name="year" id="year">
                	<option value="0">Năm</option>
					<?php
                        $year_current = date("Y");
                        for($i = $year_current; $i>= 2013; $i--){
                            echo '<option value="'.$i.'">'.$i.'</option>';	
                        }
                    ?>
                </select>
            </li>
            <li>
            	<button>Xem đánh giá</button>
            </li>   
        </ul>
        </form>
    </div>
</div>

<div class="right"></div>