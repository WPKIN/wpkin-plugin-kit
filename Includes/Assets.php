<?php

namespace WPK_PLUGIN_KIT\Includes;

/**
 * Assets Handler Class
 *
 * @since 1.0.0
 */
class Assets {

	/**
	 * Assets class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	/**
	 * Method frontend_enqueue_scripts.
	 *
	 * @since 1.0.0
	 */
	public function frontend_enqueue_scripts() {

		wp_enqueue_style( 'wpkin-pk-public-style', WPK_PK_URL . '/build/public.bundle.css', [], filemtime( WPK_PK_PATH . 'build/public.bundle.css' ), false );
		wp_enqueue_script( 'wpkin-pk-public-scripts', WPK_PK_URL .'/build/public.bundle.js', ['wp-element'], filemtime( WPK_PK_PATH . 'build/public.bundle.js' ), true );

		wp_localize_script(
			'wpkin-pk-public-scripts',
			'wpkinKit',
			array(
				'nonce' => wp_create_nonce('wp_rest'),
			)
		);

	}

	/**
	 * Method admin_enqueue_scripts.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {

		$current_screen = get_current_screen()->id;

		if ( 'toplevel_page_wpkin-plugin-settings' === $current_screen ) {
			wp_enqueue_style( 'wpkin-pk-admin-style', WPK_PK_URL . '/build/admin.bundle.css', [], filemtime( WPK_PK_PATH . 'build/admin.bundle.css' ), false );
			wp_enqueue_script( 'wpkin-pk-admin-scripts', WPK_PK_URL .'/build/admin.bundle.js', ['wp-element'], filemtime( WPK_PK_PATH . 'build/admin.bundle.js' ), true );
		
			wp_localize_script(
				'wpkin-pk-admin-scripts',
				'wpkinKit',
				array(
					'nonce' => wp_create_nonce('wp_rest'),
				)
			);
		}

		
	}

}
