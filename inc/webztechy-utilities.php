<?php
/*
 * Customized by: Renier C. Rumbaoa
 * Email: renierrumbaoa@gmail.com
 *
 */

if( !class_exists('webztechy_utilities') ) {
	
	class webztechy_utilities{
		

		public function coupon_expired_check($promo_id = 0, $coupon_id = 0){
			
			$str = '<a alt="f147" class="dashicons dashicons-yes"></a><br />Promo alreasy expired!';
			if ($promo_id>0 && $coupon_id>0){
				$end_date_promo = get_post_meta($promo_id, WEBZTECHY_PREFIX_APP.'end_date', true);
				$fomatted_date_availed_date = get_the_date('Y-m-d', $coupon_id);
				
				$end_date_promo = strtotime($end_date_promo);
				$fomatted_date_availed_date = strtotime($fomatted_date_availed_date);
				
				if ($fomatted_date_availed_date<$end_date_promo){ // means expired, invalid
					$str = '<div alt="f335" class="dashicons dashicons-no-alt"></div>';
				}
			}
			
			echo $str;
		}
	
	}
	
}



?>
