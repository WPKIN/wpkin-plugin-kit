<?php

namespace WPK_PLUGIN_KIT\Includes\Admin;

/**
 * Admin Menu Class
 *
 * @since 1.0.0
 */
class Menu {

	/**
	 * Menu class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'regiter_admin_menu' ] );
	}

	/**
	 * Register Admin Menue
	 *
	 * @return void
	 */
	public function regiter_admin_menu() {
		$user = 'manage_options';
		add_menu_page( __( 'WPKIN Plugin Kit', 'wpkin-plugin-kit' ), __( 'WPKIN Plugin Kit', 'wpkin-plugin-kit' ), $user, 'wpkin-plugin-settings', [ $this, 'plugin_page' ], 'dashicons-businessman', 58 );
	}

	/**
	 * Plugin Admin Menu
	 *
	 * @return void
	 */
	public function plugin_page() {
		echo '<div id="wpkin-plugin-kit-admin">Hello</div>';
	}

}
