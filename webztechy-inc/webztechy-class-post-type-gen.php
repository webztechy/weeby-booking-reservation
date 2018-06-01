<?php
/**
 * @package     Post Type Generator
 * @Version: 	1.0.0
 * @author      Renier Rumbaoa < renierrumbaoa@gmail.com > 
 * @copyright   Copyright (c) 2016-2017, iwebtechy
 * @license     
 */
 

if( !class_exists('webtechy_post_type') ) {
	
	class webtechy_post_type{
		
		/*
		 * Initialize variables
		 * @since 2016
		 */
		 
		protected $post_var;
		protected $post_type;
		
		/*
		 * Initialize functions
		 * @since 2016
		 */
		 
		public function init($post_var) {
			$this->post_var = $post_var;
			
			add_action( 'init', array( $this, 'generate_post_type' ) );

		}
		
		public function generate_post_type() {
			
			$post_type_list_array = $this->post_var;
													
			foreach($post_type_list_array as $post_type => $post_type_row){
			

				if ( !empty($post_type_row['label'])){	
				
					$this->post_type = $post_type;
					$this->create_post_type($post_type_row['label'], $post_type_row['supports']);
					
					if ( !empty($post_type_row['taxonomy']) ){
						
						foreach( $post_type_row['taxonomy'] as $taxonomy=>$taxonomy_row){
							
							$this->create_post_type_taxonomy($taxonomy, $taxonomy_row['type'], $taxonomy_row['label']);
						}
					}	

				}
			}
			
		}
		
		public function create_post_type($post_type_label, $post_type_supports) {
			
			$post_type_label = ucwords($post_type_label);
			$labels = array(
				'name' => __($post_type_label.' List'),
				'singular_name' => __($post_type_label.' Item'),
				'add_new' => __('Add New '.$post_type_label),
				'add_new_item' => __('Add New '.$post_type_label.' Item'),
				'edit_item' => __('Edit '.$post_type_label.' Item'),
				'new_item' => __('New '.$post_type_label.' Item'),
				'view_item' => __('View '.$post_type_label.' Item'),
				'search_items' => __('Search '.$post_type_label),
				'not_found' =>  __('Nothing found'),
				'not_found_in_trash' => __('Nothing found in Trash'),
				'parent_item_colon' => ''
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => 'dashicons-groups',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,	
				'menu_position' => null,
				'supports' => $post_type_supports
			);
			
			register_post_type( $this->post_type , $args ); 
			
		}
		
		public function create_post_type_taxonomy($taxonomy, $taxonomy_type, $taxonomy_label) {

			$labels = array(
				'name'          => $taxonomy_label,
				'singular_name' => $taxonomy_label,
				'edit_item'     => 'Edit '.$taxonomy_label,
				'update_item'   => 'Update '.$taxonomy_label,
				'add_new_item'  => 'Add '.$taxonomy_label,
				'menu_name'     => $taxonomy_label
			);
		 
			$taxonomy_type = ($taxonomy_type == 'category') ? true : false;
			$args = array(
				'hierarchical'      => $taxonomy_type,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => $taxonomy )
			);
		 
			register_taxonomy( $taxonomy, $this->post_type, $args );
		
		}
	
			
	}
	
}




?>