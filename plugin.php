<?php
  defined('ABSPATH') or die("No script kiddies please!");

  /**
   * Plugin Name: Chunky
   * Plugin URI: https://github.com/jlandrum/wp-chunky
   * Description: Allows the creation of reusable blocks of code in Wordpress
   * Version: 1.0.0
   * Author: James Landrum
   * Author URI: http://jameslandrum.com
   * License: GPL2
   */

		add_action( 'init', 'chunky_create_post_type' );

		function chunky_create_post_type() {
			register_post_type( 'chunk',
				array(
					'labels' => array(
						'name' => __( 'Chunks' ),
						'singular_name' => __( 'Chunk' ),
						'add_new' => __( 'Add Chunk' ),
						'add_new_item' => __( 'Add New Chunk' ),
						'edit_item' => __( 'Edit Chunk' ),
						'new_item' => __( 'New Chunk' ),
						'view_item' => __( 'View Chunk' ),
						'search_items' => __( 'Search Chunks' ),
						'not_found' => __( 'No Chunks found' ),
						'not_found_in_trash' => __( 'No Chunks found in Trash' ),						
					),
					'rewrite' => array(
						'slug' => '',
						'with_front'	=> true
					),
					'supports' => array (
						'title', 'editor'
					),
					'menu_icon' =>  plugin_dir_url( __FILE__ ) . "/images/dashicon.png",
					'public' => true,
					'has_archive' => false,
				)
			);
		}

		add_shortcode( 'chunk', function($attrs, $text="") {
			if (isset($attrs['id'])) {
				$post = get_post( $attrs['id'] );
			} else if (isset($attrs['title'])) {
				$post = get_page_by_title( $attrs['title'], 'OBJECT', 'chunk' );
			} else { return "<!-- Chunk Missing -->"; }
			$content = $post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);			
			$content = do_shortcode($content);
			return $content; 
		});