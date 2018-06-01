<?php
/*
 * Customized by: Renier C. Rumbaoa
 * Email: renierrumbaoa@gmail.com
 *
 */

if( !class_exists('webztechy_booking_metabox') ) {
	
	class webztechy_booking_metabox{
		

		public function init() { 
			add_action('admin_menu' ,array($this, 'metaboxes_func') );
			add_action('save_post' ,array($this, 'metaboxes_func_submit') );
		}
		
		//  METABOX
		public function metaboxes_func() {
			add_meta_box(WEBZTECHY_PREFIX_APP.'detail', 'Promo Details', array($this, WEBZTECHY_PREFIX_APP.'detail_call_box'), WEBZTECHY_PROMO_POST_TYPE, 'normal', 'low' );
			
			add_meta_box(WEBZTECHY_PREFIX_APP.'detail_subsciber', 'Subsciber Details', array($this, WEBZTECHY_PREFIX_APP.'detail_subsciber_box'), WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER, 'normal', 'low' );
			
		}
		
		public function webztechy_promo_detail_call_box() {
			global $post;
			include(WEBZTECHY_TEMPLATE_FOLDER.'metaboxes/metaboxes_promo_detail.php');
		}
		
		public function webztechy_promo_detail_subsciber_box() {
			global $post;
			include(WEBZTECHY_TEMPLATE_FOLDER.'metaboxes/metaboxes_promo_detail_subscriber.php');
		}
		
		
		/*
		 * SAVING MEATBOX CONTENT
		 * GAMING EVENT
		 */
		public function metaboxes_func_submit($post_id){

			global $post;
			//// CHECK IF IT'S AN AUTOSAVE
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
			
			if(isset($_POST['post_type'])) {
			
				//// VERIFY PERMISSIONS
				if('page' == $_POST['post_type']) {
					 
					//// IF USER CAN'T EDIT PAGE
					if(!current_user_can('edit_page', $post_id)) { return $post_id; }
					
					//// IF USER CAN'T EDIT POST
					if(!current_user_can('edit_post', $post_id)) { return $post_id; }
					
				}
			  
			}
			
			$var_detail = array(
							 WEBZTECHY_PREFIX_APP.'isactive',
							 WEBZTECHY_PREFIX_APP.'start_date',
							 WEBZTECHY_PREFIX_APP.'end_date',
							 
							 WEBZTECHY_PREFIX_APP.'subscriber_name',
							 WEBZTECHY_PREFIX_APP.'subscriber_contact',
							 WEBZTECHY_PREFIX_APP.'subscriber_email',
							 WEBZTECHY_PREFIX_APP.'subscriber_promo_used',
							 WEBZTECHY_PREFIX_APP.'subscriber_promo_invoice',
						);
			
			foreach($var_detail as $field){
				if(isset($_POST[$field])) { update_post_meta($post_id, $field , $_POST[$field]); }
			}
			
		
			
		}
		
		
	}
	
	$webztechy_booking_metabox = new webztechy_booking_metabox();
	$webztechy_booking_metabox->init();
		
	
}



?>
