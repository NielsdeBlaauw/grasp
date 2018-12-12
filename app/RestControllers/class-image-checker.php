<?php
/**
 * Create the Image Checker endpoint
 *
 * @package Grasp
 */

namespace Grasp\RestControllers;

/**
 * A REST endpoint that takes image urls, and checks if they have alt texts
 * filled in WordPress.
 */
class Image_Checker extends \WP_REST_Controller {
	/**
	 * Register the routes needed to check image statuses.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'grasp/v' . $version;
		$base      = 'image-checker';
		register_rest_route(
			$namespace,
			'/' . $base,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_image_info' ),
					'permission_callback' => array( $this, 'get_image_info_permissions_check' ),
					'args'                => array(
						'required' => true,
						'images'   => array(
							'description' => __( 'Images to check', 'grasp' ),
							'type'        => 'array',
							'items'       => array(
								'type' => 'string',
							),
						),
					),
				),
			)
		);
	}

	/**
	 * Gets the information from WordPress for the images to be checked, Based
	 * on image URL.
	 *
	 * @param \WP_REST_Request $request Contains the request info.
	 */
	public function get_image_info( \WP_REST_Request $request ) {
		$data   = array();
		$images = $request->get_param( 'images' );
		foreach ( $images as $key => $image_url ) {
			$clean_image_url = preg_replace( '/-[0-9]+x[0-9]+/', '', $image_url ); // Clean URL from size modifications.
			$image_id        = attachment_url_to_postid( $clean_image_url );
			if ( $image_id ) {
				$data[] = array(
					'id'        => $image_id,
					'url'       => $image_url,
					'alt'       => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
					'thumbnail' => wp_get_attachment_image_src( $image_id ),
				);
			}
		}
		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Only allow viewing the image status if the user can actually influence the problem.
	 *
	 * @param \WP_REST_Request $request Contains the request info.
	 */
	public function get_image_info_permissions_check( $request ) {
		return current_user_can( 'edit_posts' );
	}
}
