<?php
$isactive = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'isactive', true);
$start_date = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'start_date', true);
$end_date = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'end_date', true);
?>


<table class="form-table promo-event-table">
<tbody>
	
	<tr>
		<th style="width:12%">Active? :</th>
		<td>
			<select name="<?php echo WEBZTECHY_PREFIX_APP.'isactive'; ?>" style="width:100px;">
				<option value="0" <?php echo ($isactive==0) ? 'selected' : ''; ?>>No</option>
				<option value="1" <?php echo ($isactive==1) ? 'selected' : ''; ?>>Yes</option>
			</select>
		</td>
		
	<tr>
		<th>Start Date:</th>
		<td><input type="text"  name="<?php echo WEBZTECHY_PREFIX_APP.'start_date'; ?>" value="<?php echo $start_date; ?>"  placeholder="Format: yyyy-mm-dd" /></td>
	</tr>
	
	<tr>
		<th>End Date:</th>
		<td><input type="text"  name="<?php echo WEBZTECHY_PREFIX_APP.'end_date'; ?>" value="<?php echo $end_date; ?>"  placeholder="Format: yyyy-mm-dd"  /></td>
	</tr>
	
		
	</tr>
	
	
</tbody>
</table>

