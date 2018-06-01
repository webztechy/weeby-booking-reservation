<?php
/*
Plugin Name: Booking Reservation
Version: 1.5.0
Plugin URI: https://www.facebook.com/iwebtechy
Description: Booking reservation with role accounts
Author: Renier Rumbaoa - Webztechy
Author URI: https://www.facebook.com/iwebtechy
License: GPLv3.0 or later
*/



/**
* @class   webztechy_booking_reservation
* @version	1.0.0
*/

if( !class_exists('class_webztechy_booking_reservation') ) {
	
	define('WEBZTECHY_PREFIX', 'webztechy_');
	define('WEBZTECHY_PREFIX_APP', WEBZTECHY_PREFIX.'promo_');
	define('WEBZTECHY_SESSION_PROMO_KEY', 'popup_session_key');

	
	/* User Roles */
	define('WEBZTECHY_MANAGER_USER', WEBZTECHY_PREFIX.'manager_user');
	define('WEBZTECHY_MANAGER_CASHIER', WEBZTECHY_PREFIX.'cashier_user');
	
	/* Post Types */
	define('WEBZTECHY_PROMO_POST_TYPE', 'qab-promos');
	define('WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER', 'qab-subscriber');
	define('WEBZTECHY_PROMO_POST_TYPE_CAT', 'qab-promos-categories');
	define('WEBZTECHY_PROMO_IMAGE', WEBZTECHY_PREFIX.'promo_image');
	define('WEBZTECHY_PROMO_IMAGE_SIZE', 350 );
	
	
	/* Plugin Directory */
	define('WEBZTECHY_PLUGIN_URL', plugin_dir_url( __FILE__ ).'/' );
	define('WEBZTECHY_ASSETS_URL', plugin_dir_url( __FILE__ ).'assets/' );
	define('WEBZTECHY_PLUGIN_DIR', plugin_dir_path( __FILE__ ).'/' );
	define('WEBZTECHY_ASSETS_FOLDER', WEBZTECHY_PLUGIN_DIR.'assets/' );
	define('WEBZTECHY_TEMPLATE_FOLDER', WEBZTECHY_PLUGIN_DIR.'templates/' );
	define('WEBZTECHY_INCS_FOLDER', WEBZTECHY_PLUGIN_DIR.'webztechy-inc/' );
	define('WEBZTECHY_INCS_FOLDER_APP', WEBZTECHY_PLUGIN_DIR.'inc/' );


	/* Labels */
	$LABELS_ARR = array(
					WEBZTECHY_PREFIX.'manager_user' => 'Manager User',
					WEBZTECHY_PREFIX.'cashier_user' => 'Cashier User',
					
					WEBZTECHY_PREFIX.'promo_post_type' => 'Promo',
					WEBZTECHY_PREFIX.'promo_post_type_categories' => 'Promo Category',
					
					WEBZTECHY_PREFIX.'promo_post_type_subscriber' => 'Promo Subscriber'
	
				);
	
	
	
	/* Includes webztechy files  */
	include (WEBZTECHY_INCS_FOLDER.'webztechy-class-post-type-gen.php');
	include (WEBZTECHY_INCS_FOLDER_APP.'webztechy-utilities.php');
	
	
	
	
	class class_webztechy_booking_reservation{	
		
		/*
		 * Initialize variables
		 * @since 2017
		 */
		 
		private $LABELS_ARRAY = array();
		
		
		/*
		 * Initialize Plugin
		 * @since 2017
		 */
		public function init( $LABELS_ARR ) {
			
	
			$this->LABELS_ARRAY = $LABELS_ARR;
			
			self::register_post_type();
			self::register_role_user();
			
			//remove_role( WEBZTECHY_MANAGER_USER );
			//remove_role( WEBZTECHY_MANAGER_CASHIER );
			//add_filter('login_redirect', array( $this, 'dashboard_redirect') ); 
			
			$this->webtechy_post_type = new webtechy_post_type();
			add_action( 'plugins_loaded',  array( $this, 'user_restriction_func')  );
			
			// CALLING POPUP
			include ( WEBZTECHY_INCS_FOLDER_APP .'webztechy-booking-popup.php');
			$popup = new webztechy_booking_popup; 
			
			$popup->init();
			add_action('wp', array( $popup, 'start_popup_session') );
			add_action( 'wp_footer', array( $popup, 'html_popup_footer_func'), 100 );
			
			add_action('admin_head',  array( $this, 'custom_admin_css') );
			
			// ADD Filtering Subsribers / Promo
			add_action( 'restrict_manage_posts', array( $this, 'wpse45436_admin_posts_filter_restrict_manage_posts')  );
			add_filter( 'parse_query',  array( $this, 'wpse45436_posts_filter') );
		}
		
		
		
		public function user_restriction_func(){
		 
			
		  $current_user = wp_get_current_user(); 

		  if ( !($current_user instanceof WP_User) ) 
				return; 

				include ( WEBZTECHY_INCS_FOLDER_APP .'webztechy-booking-branding.php');
				$branding = new webztechy_booking_branding; 

				$user_role_arr =  $current_user->roles;

				$branding = new webztechy_booking_branding; 
				if ( in_array( WEBZTECHY_MANAGER_USER , $user_role_arr) || in_array( WEBZTECHY_MANAGER_CASHIER, $user_role_arr ) ){

					add_action( 'admin_enqueue_scripts', array( $branding, 'regsiter_script_css_func')  );
					add_action( 'admin_menu',  array( $branding, 'remove_menus') , 999);
					add_action('wp_dashboard_setup', array( $branding, 'remove_dashboard_widgets') );
					add_action( 'wp_before_admin_bar_render', array( $branding, 'remove_admin_bar_links') );
					add_action( 'admin_footer_text', array( $branding, 'remove_footer_admin' ) );
					add_filter( 'update_footer', array( $branding, 'my_footer_version') , 11 );
					add_action('welcome_panel', array( $branding, 'st_welcome_panel') );
					add_action('admin_head',  array( $branding, 'mytheme_remove_help_tabs') );
					
					
					
				}
				
				if (in_array( WEBZTECHY_MANAGER_USER, $user_role_arr ) ){
					add_action('load-index.php', array( $branding, 'dashboard_redirect_manager' ) );
				}
				
				if (in_array( WEBZTECHY_MANAGER_CASHIER, $user_role_arr ) ){
				  add_action("load-post-new.php", array( $branding, 'block_post') );
				  add_action( 'admin_menu',  array( $branding, 'remove_menus_cahier') , 999);
				  add_action( 'admin_enqueue_scripts', array( $branding, 'regsiter_script_css_func_cashier')  );
				  add_action('load-index.php', array( $branding, 'dashboard_redirect_cashier' ) );
				}
				
				
		}

		public function custom_admin_css(){
			$script = "<link rel='stylesheet' href='".WEBZTECHY_ASSETS_URL."css/style-admin.css' type='text/css'/>";
			echo $script;
		}	
		
		
		
		
		
		
		
		/*
		 * Initialize Post Type
		 * @since 2017
		 */
		public function register_post_type(){
			$post_type_setting = array(
										'label' => $this->LABELS_ARRAY[ WEBZTECHY_PREFIX.'promo_post_type' ] ,
										'supports' =>  array('title','editor','thumbnail'),
										'taxonomy' => array(
														WEBZTECHY_PROMO_POST_TYPE_CAT => array(
																'label' => $this->LABELS_ARRAY[ WEBZTECHY_PREFIX.'promo_post_type_categories' ],
																'type' => 'category'
															)
													)
									);
									
			$post_type_list[WEBZTECHY_PROMO_POST_TYPE] = $post_type_setting;
			
			$webtechy_post_type = new webtechy_post_type();
			$webtechy_post_type->init($post_type_list);
			
				// Call all necessary modules
				
				self::register_post_type_thumbnail();
				add_filter('manage_'.WEBZTECHY_PROMO_POST_TYPE.'_posts_columns' , array($this, 'custom_column_post') );
				add_action('manage_'.WEBZTECHY_PROMO_POST_TYPE.'_posts_custom_column', array($this, 'get_custom_column_post'), 10, 2);
				
				add_filter('manage_'.WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER.'_posts_columns' , array($this, 'custom_column_post_subscriber') );
				add_action('manage_'.WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER.'_posts_custom_column', array($this, 'get_custom_column_post_subscriber'), 10, 2);
				
			
			// Subscribers
			$post_type_setting = array(
										'label' => $this->LABELS_ARRAY[ WEBZTECHY_PREFIX.'promo_post_type_subscriber' ] ,
										'supports' =>  array('title')
									);
									
			$post_type_list[WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER] = $post_type_setting;
			
			$webtechy_post_type = new webtechy_post_type();
			$webtechy_post_type->init($post_type_list);
				
			
			// Meatabox
			include (WEBZTECHY_INCS_FOLDER_APP.'webztechy-post-type-metabox.php');

		}
		
		
		
		public function register_post_type_thumbnail(){
			add_image_size( WEBZTECHY_PROMO_IMAGE , WEBZTECHY_PROMO_IMAGE_SIZE, WEBZTECHY_PROMO_IMAGE_SIZE, false ); // Hard Crop Mode
		}
		
		public function custom_column_post($columns){
			$custom_columns = array(
									WEBZTECHY_PREFIX_APP.'isactive'=> __('Active?'),
									WEBZTECHY_PREFIX_APP.'availed'=> __('Who Availed?')
								);
			return array_merge($columns, $custom_columns);
		}
		
		public function get_custom_column_post( $column, $post_id  ) {
			global $wpdb;
			
			switch ( $column ) {
				case WEBZTECHY_PREFIX_APP.'isactive' : 
						$isactive = get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'isactive', true);
						echo ($isactive==1)?'<div alt="f147" class="dashicons dashicons-yes"></div>':'<div alt="f335" class="dashicons dashicons-no-alt"></div>';
					break;
				case WEBZTECHY_PREFIX_APP.'availed' : 
						$subscriber_promo_id_key = WEBZTECHY_PREFIX_APP.'subscriber_promo_id';
						$sql = " SELECT COUNT(*) FROM `".$wpdb->prefix."postmeta` WHERE `meta_key` LIKE '".$subscriber_promo_id_key."' AND `meta_value` LIKE '".$post_id."' ";
						echo $wpdb->get_var( $sql );
					break;
			}	
		}
		
		public function custom_column_post_subscriber($columns){
			$custom_columns = array(
									'title'=> __('Promo Code'),
									'date'=> __('Date Availed'),
									
									WEBZTECHY_PREFIX_APP.'subscriber_name'=> __('Subscriber Name'),
									WEBZTECHY_PREFIX_APP.'subscriber_email'=> __('Email'),
									WEBZTECHY_PREFIX_APP.'subscriber_contact'=> __('Contact'),	
									WEBZTECHY_PREFIX_APP.'subscriber_promo_used'=> __('Used?'),
									WEBZTECHY_PREFIX_APP.'subscriber_promo_invoice'=> __('Invoice'),
									WEBZTECHY_PREFIX_APP.'subscriber_promo_id'=> __('Promo Name'),
									WEBZTECHY_PREFIX_APP.'isexpired'=> __('Expired?'),
								);
			unset($columns['thumbnail']);
			return array_merge($columns, $custom_columns);
		}
		
		public function get_custom_column_post_subscriber( $column, $post_id  ) {
			switch ( $column ) {
				
				case WEBZTECHY_PREFIX_APP.'subscriber_promo_id' : 
						echo get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_promo_id', true);
					break;
				case WEBZTECHY_PREFIX_APP.'subscriber_name' : 
						echo get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_name', true);
					break;
				case WEBZTECHY_PREFIX_APP.'subscriber_email' : 
						echo get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_email', true);
					break;
				case WEBZTECHY_PREFIX_APP.'subscriber_contact' : 
						echo get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_contact', true);
					break;
				case WEBZTECHY_PREFIX_APP.'subscriber_promo_used' : 
						$isused = get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_promo_used', true);
						echo ($isused==1)?'<a alt="f147" class="dashicons dashicons-yes"></div>':'<div alt="f335" class="dashicons dashicons-no-alt"></a>';
					break;
				case WEBZTECHY_PREFIX_APP.'subscriber_promo_invoice' : 
						$subscriber_promo_invoice = get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_promo_invoice', true);
						echo (empty($subscriber_promo_invoice))?'-':$subscriber_promo_invoice;
					break;
				case WEBZTECHY_PREFIX_APP.'isexpired' : 
						$promo_id = get_post_meta($post_id, WEBZTECHY_PREFIX_APP.'subscriber_promo_id', true);
						echo webztechy_utilities::coupon_expired_check($promo_id,$post_id);
					break;
			}	
		}
		
		
		public function wpse45436_admin_posts_filter_restrict_manage_posts(){
			global $wpdb;
			
			$type = 'post';
			if (isset($_GET['post_type'])) {
				$type = $_GET['post_type'];
			}
			
			$filter_meta = WEBZTECHY_PREFIX_APP.'subscriber_promo_id';
			//only add filter to post type you want

			if ( WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER  == $type){
				
				$values = array();
				$qry = "SELECT `post_title`,`ID` FROM ".$wpdb->prefix."posts ";
				$qry .= " WHERE  `post_type` = '".WEBZTECHY_PROMO_POST_TYPE."' AND post_status LIKE 'publish' ORDER BY `post_title` ASC";
				$promo_list_arr = $wpdb->get_results($qry, OBJECT );
					

				?>
				<select name="<?php echo $filter_meta; ?>">
				<option value=""><?php _e('Filter by Promo '); ?></option>
				<?php
					$current_v = isset($_GET[$filter_meta])? $_GET[$filter_meta]:'';
					foreach ($promo_list_arr as $promo) {
						printf
							(
								'<option value="%s" %s >%s</option>',
								$promo->ID,
								$promo->ID == $current_v? ' selected="selected"':'',
								$promo->post_title
							);
						}
				?>
				</select>
				<?php
			}
		}
		
		public function wpse45436_posts_filter( $query ){
			global $pagenow;
			
			$type = 'post';
			$filter_meta = WEBZTECHY_PREFIX_APP.'subscriber_promo_id';
			
			if (isset($_GET['post_type'])) {
				$type = $_GET['post_type'];
			}
			
			if ( WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER == $type && $pagenow=='edit.php' && isset($_GET[$filter_meta])&& $_GET[$filter_meta] != '') {
				$query->query_vars['meta_key'] = $filter_meta;
				$query->query_vars['meta_value'] = $_GET[$filter_meta];
			}
			
		}
		

		/*
		 * Initialize USer Roles
		 * @since 2017
		 */
		public function register_role_user(){

			$manager_user = $this->LABELS_ARRAY[ WEBZTECHY_PREFIX.'manager_user' ];
			$cashier_user = $this->LABELS_ARRAY[ WEBZTECHY_PREFIX.'cashier_user' ];
			
			$role = get_role( 'editor' ); 
			$editor = $role->capabilities;
			//print_r($contributor);
			$custom_cap = array();

			$custom_cap = array_merge($editor, $custom_cap);
			add_role( WEBZTECHY_MANAGER_USER, __( $manager_user ), $custom_cap );
			
			$role = get_role( 'editor' ); 
			$contributor = $role->capabilities;
			$custom_cap = array();
			$custom_cap = array_merge($contributor, $custom_cap);
			add_role( WEBZTECHY_MANAGER_CASHIER, __( $cashier_user ), $custom_cap );
				
			
		}
		
	}
	
	$class_webztechy_booking_reservation = new class_webztechy_booking_reservation;
	$class_webztechy_booking_reservation->init($LABELS_ARR);

}

?>
