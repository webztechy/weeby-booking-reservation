<?php
$btn_promo = 'Avail Promo';
$today_date = date('Y-m-d');

$args = array(
    'meta_key' 		=> WEBZTECHY_PREFIX_APP.'isactive',
    'meta_type' 	=> 'NUMERIC',
    'meta_value' 	=> 1,
	'orderby' 		=> 'meta_value', 
	'order'         =>  'ASC' ,
	'post_type'     =>  WEBZTECHY_PROMO_POST_TYPE,
	'post_status'   =>  'publish',
	'posts_per_page' => 1,
	'paged' => 1,
);
$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ):
		while ( $the_query->have_posts() ):
			$the_query->the_post();
			$post_id = get_the_ID();
			
			$start_date = get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'start_date', true);
			$end_date = get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'end_date', true);
			
			if ( $today_date>=$start_date && $today_date<=$end_date):
				
				$promo_title = get_the_title($post_id);
				$promo_title_arr = explode(' ', $promo_title);
				$promo_title_1 = $promo_title_arr[0];
				unset($promo_title_arr[0]);
				$promo_title = implode(' ', $promo_title_arr);
				
?>	

<div id="booking_promo_wrapper">
	<div class="promo_content">
	
		<div class="promo_form">
			
			<div class="promo_form_wrapper">
				<a id="promo_cancel_btn" href="javascript:;"><i class="fa fa-close"></i></a>
				<h2 class="ppb_title"><span class="ppb_title_first"><?php echo $promo_title_1; ?></span><?php echo $promo_title; ?></h2>
				<div id="reponse_msg_promo" class="reponse_msg_promo"></div>
				<form id="tg_promo_form" method="post" autocomplete="off">
					
					
					<div class="one_third">
						<input type="hidden" name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_promo_id'; ?>" value="<?php echo $post_id; ?>" />
						<?php echo the_post_thumbnail(); ?>
			    	</div>
					
					<div class="two_third col-promo-third">
						<div class="promo-content">
							<?php the_content(); ?>
						</div>
						
						<div id="promo-avail-enrty-wrap">
							<div class="promo-separator"></div>
							<p class="reponse_msg_promo" style="text-align:left; padding-bottom:15px;">Get yout coupon:</p>
							<div>	
								<div class="one_half no-padd">
									<label for="your_name">Name*</label>
									<input id="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_name'; ?>" name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_name'; ?>" type="text" class="required_field">
									
									<br /><br />
									
									<label for="your_name">Email*</label>
									<input id="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_email'; ?>" name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_email'; ?>" type="text" class="required_field">
									
								</div>
								
								<div class="one_half no-padd">
									<label for="your_name">Contact*</label>
									<input id="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_contact'; ?>" name="<?php echo WEBZTECHY_PREFIX_APP.'subscriber_contact'; ?>" type="text" class="required_field">
									<p> <button id="promo_submit_btn" type="submit">Avail Promo</button> </p>
								</div>
								
								<div class="clear"></div>
							</div>
							
							
							
						</div>
						
			    	</div>

					
					<br class="clear">
				</form>
				
			</div>
			
			<?php endif; ?>
			
		</div>

	</div>

</div>


<?php
$success_msg = 'You have successfully availed the promo.<br />Please check you email to know you coupon number.';
$error_msg = 'Error, cound not submit you detail.<br />Please reload the page or contact the administrator.';
$error_availed_msg = 'Sorry, youre already availed this promo.<br />Pelase contact the administrator.';
$button_clicked = 'Generating code, and sending email..';

?>
<script>
jQuery(function (){
	class_btn = 'promo_submit_btn-loading';
	button_html = jQuery('#tg_promo_form').find('#promo_submit_btn');
	
	form_promo = jQuery('#tg_promo_form');
	form_promo.submit(function (e){
		e.preventDefault();
		var hasError = false;
		
		jQuery('.required_field').removeClass('error-input');
		jQuery('.required-label').removeClass('required-label');
		
		
		
		jQuery('form#tg_promo_form .required_field').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				jQuery(this).addClass('error-input');
				jQuery(this).parent('div').find('label').addClass('required-label');
				hasError = true;
			}
		});
		
		if(!hasError) {
			button_html.removeClass(class_btn).addClass(class_btn).text('<?php echo $button_clicked; ?>').prop('disabled', true);
			promo_vals = jQuery(this).serialize()+'&action=avail_promo';
			
			jQuery.post(<?php echo WEBZTECHY_PREFIX_APP.'_ajax_script'; ?>.ajaxurl, promo_vals , function (result){
				//alert(result);
				button_html.removeClass(class_btn);
				result = parseInt(result);
				msg = '';
				if (result=='1'){
					msg = '<?php echo $success_msg; ?>';
					jQuery('#promo-avail-enrty-wrap').remove();
				}else if (result=='2'){
					msg = '<?php echo $error_availed_msg; ?>';
					button_html.removeClass(class_btn).text('<?php echo $btn_promo; ?>').prop('disabled', false);
				}else{
					msg = '<?php echo $error_msg; ?>';
					button_html.removeClass(class_btn).text('<?php echo $btn_promo; ?>').prop('disabled', false);
				}
				
				jQuery('#reponse_msg_promo').hide().html(msg).fadeIn();
				form_promo[0].reset();
			});
			
		}
	});
	
	jQuery('a#promo_cancel_btn').click (function (){
		jQuery('#booking_promo_wrapper').fadeOut();
	});

});
</script>


<?php 
	
		endwhile;
	
	endif;

?>