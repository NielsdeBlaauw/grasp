<?php
/**
 * Plugin Name:     Grasp
 * Plugin URI:      https://grasp.actd.nl
 * Description:     Making usable and accessible websites that are found well should be easy. Grasp helps you optimise WordPress images in a way that makes the web better.
 * Author:          Niels de Blaauw
 * Author URI:      https://actd.nl
 * Text Domain:     grasp
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Grasp
 */

add_action(
	'init',
	function() {
		if ( current_user_can( 'edit_posts' ) ) {
			add_action(
				'admin_bar_menu',
				function() {
					global $wp_admin_bar;
					$wp_admin_bar->add_node(
						array(
							'id' => 'grasp_container',
						)
					);
				},
				100
			);

			add_action(
				'wp_enqueue_scripts',
				function() {
						wp_enqueue_script( 'grasp', plugin_dir_url( __FILE__ ) . 'dist/main.js', array( 'wp-api' ), get_file_data( __FILE__, array( 'version' => 'Version' ) )['version'], true );
				}
			);

			add_action(
				'rest_api_init',
				function ( $server ) {
						require_once realpath( __DIR__ . '/app/RestControllers/class-image-checker.php' );
						$image_checker_endpoint = new \Grasp\RestControllers\Image_Checker();
						$image_checker_endpoint->register_routes();
				}
			);
		}
	}
);
