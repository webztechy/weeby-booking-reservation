<?php
$subscriber_promo_id = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'subscriber_promo_id', true);
$subscriber_name = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'subscriber_name', true);
$subscriber_contact = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'subscriber_contact', true);
$subscriber_email = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'subscriber_email', true);

$subscriber_promo_used = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'subscriber_promo_used', true);
$subscriber_promo_invoice = get_post_meta($post->ID, WEBZTECHY_PREFIX_APP.'subscriber_promo_invoice', true);

?>

<table class="form-table promo-event-table">
<tbody>
	
	<tr>
		<th style="width:12%">Promo :</th>
		<td><input type="text"  value="<?php echo $subscriber_promo_id; ?>" value="<?php echo $subscriber_promo_id; ?>"  readonly /></td>
		
		<th style="width:12%">Used? :</th>
		<td>
			<select name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_promo_used'; ?>">
				<option value="0" <?php echo ($subscriber_promo_used==0)? 'selected':''; ?> >No</option>
				<option value="1" <?php echo ($subscriber_promo_used==1)? 'selected':''; ?>>Yes</option>
			</select>
		</td>
		
	</tr>
	
	<tr>
		<th style="width:12%">Name :</th>
		<td><input type="text" name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_name'; ?>" value="<?php echo $subscriber_name; ?>"  /></td>
		
		<th style="width:12%">Invoice :</th>
		<td><input type="text"  name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_promo_invoice'; ?>" value="<?php echo $subscriber_promo_invoice; ?>"  /></td>
		
	</tr>
	
	<tr>
		<th style="width:12%">Contact:</th>
		<td><input type="text"   name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_contact'; ?>" value="<?php echo $subscriber_contact; ?>"  /></td>

	</tr>
	
	<tr>
		<th style="width:12%">Email :</th>
		<td><input type="text"  name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_email'; ?>" value="<?php echo $subscriber_email; ?>"  /></td>
	</tr>

	
</tbody>
</table>

