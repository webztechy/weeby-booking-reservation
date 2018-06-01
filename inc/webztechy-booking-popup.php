<?php
/*
 * Customized by: Renier C. Rumbaoa
 * Email: renierrumbaoa@gmail.com
 *
 */

if( !class_exists('webztechy_booking_popup') ) {
	
	class webztechy_booking_popup{
		
		public function init(){
			// Enqueue stylesheets and javascripts 
			add_action('wp_enqueue_scripts', array( $this, 'wp_head' ) ) ;
			add_action('wp_print_scripts', array( $this, 'ajax_load_scripts' ) );
			
			
			
			add_action( 'wp_ajax_nopriv_avail_promo', array( $this, 'avail_promo_func' )  );
			add_action( 'wp_ajax_avail_promo', array( $this, 'avail_promo_func' ) );
		
		}
		
		
		
		public function avail_promo_func(){
			global $wpdb;
			
			$posted = 0;
			unset($_POST['action']);

				$today_date = date('Y-m-d');
				$today_date_int = strtotime($today_date);
				
				$subscriber_name_key = WEBZTECHY_PREFIX_APP.'subscriber_name';
				$subscriber_contact_key = WEBZTECHY_PREFIX_APP.'subscriber_contact';
				$subscriber_promo_id_key = WEBZTECHY_PREFIX_APP.'subscriber_promo_id';
				$subscriber_email_key = WEBZTECHY_PREFIX_APP.'subscriber_email';
				$subscriber_email_promo_key = WEBZTECHY_PREFIX_APP.'subscriber_email_promo';

				$subscriber_name = $_POST[$subscriber_name_key];
				$subscriber_contact = $_POST[$subscriber_contact_key];
				$subscriber_promo_id = $_POST[$subscriber_promo_id_key];
				$subscriber_email = $_POST[$subscriber_email_key];
				$subscriber_email_promo = $subscriber_email.'^'.$subscriber_promo_id;
					
				
					
					
					$sql = " SELECT COUNT(*) FROM `".$wpdb->prefix."postmeta` WHERE `meta_key` LIKE '".$subscriber_email_promo_key."' AND `meta_value` LIKE '".$subscriber_email_promo."' ";
					$result_existant = $wpdb->get_var( $sql );

					if ( $result_existant==0){
					
						// Create Post
						$my_post = array(
						  'post_title'    => $today_date_int,
						  'post_name'    => $today_date_int,
						  'post_type'     => WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER,
						  'post_status'   => 'publish',
						  'comment_status' => 'closed'
						);
						$post_id = wp_insert_post( $my_post );
						
						if($post_id){
							$posted = 1;
							add_post_meta($post_id, $subscriber_name_key, $subscriber_name);
							add_post_meta($post_id, $subscriber_contact_key, $subscriber_contact);
							add_post_meta($post_id, $subscriber_promo_id_key, $subscriber_promo_id);
							add_post_meta($post_id, $subscriber_email_promo_key, $subscriber_email_promo);
						}
						
						
						
							/*$today_date_int = '545466'; */
							$site_title = get_bloginfo('name');
							$from_email = get_option('admin_email');	
							
							$subject = 'Coupon - '.$site_title;
							if( isset($from_email) ){

								// EMAIL CONTENT
								ob_start();
								include(WEBZTECHY_TEMPLATE_FOLDER.'email/email-content.php');
								$promo_email_html = ob_get_clean(); 
								
								$headers = 'From:'.$from_email. "\r\n"; 
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
								
								$send = wp_mail( $subscriber_email, $subject, $promo_email_html, $headers ); //message default //Sends email to user o
								$posted = (($send)?1:0);
							}	
							
						
					}else{
						
						$posted = 2;
					}
					
					echo $posted;
			die();
		}
		
		
		public function start_popup_session() {
			session_start();

			//unset( $_SESSION[WEBZTECHY_SESSION_PROMO_KEY] );
			
			if ( !isset($_SESSION[WEBZTECHY_SESSION_PROMO_KEY] ) ){
				$_SESSION[WEBZTECHY_SESSION_PROMO_KEY] = 1;
			}else{
				$_SESSION[WEBZTECHY_SESSION_PROMO_KEY] = 0;
			}
			
		}
		
		public function html_popup_footer_func() {
			
			if ( isset( $_SESSION[WEBZTECHY_SESSION_PROMO_KEY] ) && $_SESSION[WEBZTECHY_SESSION_PROMO_KEY]==1){
				include (WEBZTECHY_TEMPLATE_FOLDER.'popup/popup.php');
			}
		}

		/*
		 * Worpress - Enqueue Stylesheets and Javascripts
		 * @since 2016
		 */
		public static function wp_head(){
			wp_register_style( WEBZTECHY_PREFIX_APP.'style-popup', WEBZTECHY_ASSETS_URL.'css/style-promo-popup.css');
			wp_enqueue_style( WEBZTECHY_PREFIX_APP.'style-popup' );

		}
		
		/*
		 * Worpress - Adding Ajax URL
		 * @since 2016
		 */
		public static function ajax_load_scripts(){
			wp_enqueue_script( WEBZTECHY_PREFIX_APP.'js-ajax', WEBZTECHY_ASSETS_URL.'js/promo-popup-js.js', array( 'jquery', 'jquery-form' ), array(), true );
			wp_localize_script( WEBZTECHY_PREFIX_APP.'js-ajax', WEBZTECHY_PREFIX_APP.'_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	
		}
		
		
		
	}

}



?>
