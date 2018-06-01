<?php 
$promo_name = get_the_title($subscriber_promo_id);
$end_date = get_post_meta($subscriber_promo_id, WEBZTECHY_PREFIX_APP.'end_date', true);
$end_date = date_create($end_date);
$end_date = date_format($end_date,"F d, Y");
?>
Hello  <strong><?php echo ucwords($subscriber_name); ?></strong>,<br /><br />

Use this coupon code when paying you orders at the counter.<br /><br />

Promo Name : <?php echo $promo_name; ?><br />
Coupon code : <?php echo $today_date_int; ?><br /><br />

Valid until <?php echo $end_date; ?>.<br /><br />

Thank you!<br /><br />

Regards<br />
<?php echo $site_title; ?>