<?php
/*
 * Customized by: Renier C. Rumbaoa
 * Email: renierrumbaoa@gmail.com
 *
 */

if( !class_exists('webztechy_booking_branding') ) {
	
	class webztechy_booking_branding{
		
		
		public function block_post() {
			if($_GET['post_type'] == WEBZTECHY_PROMO_POST_TYPE) 
				wp_redirect('edit.php?post_type='.WEBZTECHY_PROMO_POST_TYPE);
		}

		public function dashboard_redirect_manager($url) {
			 wp_redirect(admin_url('edit.php?post_type='.WEBZTECHY_PROMO_POST_TYPE));
		}
		
		public function dashboard_redirect_cashier($url) {
			 wp_redirect(admin_url('edit.php?post_type='.WEBZTECHY_PROMO_POST_TYPE_SUBSCRIPBER));
		}
		
		public function remove_dashboard_widgets(){
		  global$wp_meta_boxes;

		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
		  unset($wp_meta_boxes['dashboard']['normal']['core']['pmpro_db_widget']);
		 
		  //remove_action('welcome_panel', 'wp_welcome_panel');//welcome panel
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['quick_count_dashboard_widget']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['tribe_dashboard_widget']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['woocommerce_dashboard_recent_reviews']);
		  
		
		}
		
		public function remove_menus(){                 
			remove_menu_page( 'index.php' );                   
			remove_menu_page( 'upload.php' );                   
			remove_menu_page( 'edit.php' );                   
			remove_menu_page( 'edit.php?post_type=page' );   
			remove_menu_page( 'edit.php?post_type=galleries' );   
			remove_menu_page( 'edit.php?post_type=menus' );   
			remove_menu_page( 'edit.php?post_type=testimonials' );   
			remove_menu_page( 'edit.php?post_type=pricing' );   
			remove_menu_page( 'edit.php?post_type=team' );   
			remove_menu_page( 'edit-comments.php' );          
			remove_menu_page( 'plugins.php' );                
			remove_menu_page( 'tools.php' );                  
			remove_menu_page( 'options-general.php' );  
			
		}
		
		public function remove_menus_cahier(){                 
			remove_menu_page( 'edit.php?post_type=qab-promos' );   
		}
		
		
		public function remove_admin_bar_links() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
			$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
			$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
			$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
			$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
			$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
			// $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
			// $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
			$wp_admin_bar->remove_menu('updates');          // Remove the updates link
			$wp_admin_bar->remove_menu('comments');         // Remove the comments link
			$wp_admin_bar->remove_menu('new-content');      // Remove the content link
			$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
			//$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab

		}
		
		public function st_welcome_panel() {
			echo '<div class="welcome-panel-content">'
			.'<h2>Welcome to '.get_bloginfo('name').'</h2>';
		}
		
		public function mytheme_remove_help_tabs() {
			$screen = get_current_screen();
			$screen->remove_help_tabs();
		}
		
		public function remove_footer_admin () {
			echo "Thank you for choosing <a href='http://eraitech.com' target='_blank'>ERA Information Technology</a>";
		}

		public function my_footer_version() {
			return 'Copyright &copy; '.date('Y');
		}
		
		public function regsiter_script_css_func(){
			wp_enqueue_style( WEBZTECHY_PREFIX_APP.'style', WEBZTECHY_ASSETS_URL . 'css/style.css', array() );
		}
		public function regsiter_script_css_func_cashier(){
			wp_enqueue_style( WEBZTECHY_PREFIX_APP.'style-cashier', WEBZTECHY_ASSETS_URL . 'css/style-cashier.css', array() );
		}
		
		
	}
	

	
}



?>
