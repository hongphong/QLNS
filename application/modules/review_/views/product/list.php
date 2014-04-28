<?php if(isset($product) && is_array($product) && count($product) > 0): ?>
<table width="100%" border="0" cellspacing="1" cellpadding="5" id="table" bgcolor="" style="margin-top:10px;">
    <tr height="30" style="color:#000;">
    	<?php 
			$i = 0;
			foreach($product as $row):
				echo '<td width="20%"><input type="checkbox" name="'.$group_id.'[]" value="'.$row->id.'" style="width:auto; margin:0 5px;" /> '.$row->name.'</td>';
				$i++;
				if($i % 5 == 0)
					echo '</tr><tr height="30" style="color:#000;">';
			endforeach;
		?>
    </tr>	
</table>
<?php endif; ?>