<?php

namespace WPK_PLUGIN_KIT\Includes\Admin;

/**
 * Admin Menu Class
 *
 * @since 1.0.0
 */
class Notice {

	/**
	 * Notice class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->notice_init();
	}

	/**
	 * Method notice_init.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function notice_init() {

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, WPK_PK_MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'minimum_php_version' ] );
			return;
		}

		// Check if WooCommerce installed and activated.
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Woocommerce version.
		if ( version_compare( WC_VERSION, WPK_PK_MINIMUM_WC_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'minimum_wc_version' ] );
			return;
		}

	}

	/**
	 * Method minimum_php_version.
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function minimum_php_version() {

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'wpkin-plugin-kit'),
			'<strong>' . esc_html__('WPKIN Plugin Kit', 'wpkin-plugin-kit') . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'wpkin-plugin-kit' ) . '</strong>',
			WPK_PK_MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses( $message, wpkin_plugins_allowedtags() ) );
	}

	/**
	 * Method admin_notice_missing_main_plugin.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		$plugin            = 'woocommerce';
		$file_path         = 'woocommerce/woocommerce.php';
		$installed_plugins = get_plugins();

		if ( isset( $installed_plugins[ $file_path ] ) ) { // check if plugin is installed.

			if ( ! current_user_can('activate_plugins') ) {
				return;
			}
			$activation_url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=' . $file_path), 'activate-plugin_' . $file_path);

			$message  = wp_sprintf('<p><strong>%s</strong>%s</p>', esc_html__('WPKIN Plugin Kit', 'wpkin-plugin-kit'), __( ' not working because you need to activate the WooCommerce plugin.', 'wpkin-plugin-kit') );
			$message .= wp_sprintf('<p><a href="%s" class="button-primary">%s</a></p>', $activation_url, esc_html__('Activate WooCommerce Now', 'wpkin-plugin-kit'));

		} else {

			if ( ! current_user_can('install_plugins') ) {
				return;
			}
			$install_url = wp_nonce_url( add_query_arg(
				[
					'action' => 'install-plugin',
					'plugin' => $plugin,
				],
					admin_url('update.php') ),
					'install-plugin_' . $plugin
				);
			$message     = wp_sprintf('<p><strong>%s</strong>%s</p>', esc_html__('WPKIN Plugin Kit', 'wpkin-plugin-kit'), __(' not working because you need to install the WooCommerce plugin.', 'wpkin-plugin-kit') );
			$message    .= wp_sprintf('<p><a href="%s" class="button-primary">%s</a></p>', $install_url, esc_html__('Install WooCommerce Now', 'wpkin-plugin-kit') );

		}

		printf('<div class="error"><p>%s</p></div>', wp_kses( $message, wpkin_plugins_allowedtags() ) );
	}

	/**
	 * Method minimum_wc_version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function minimum_wc_version() {

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', '%1$s' . esc_html__( ' requires ', 'wpkin-plugin-kit' ) . ' %2$s' . esc_html__( ' version ', 'wpkin-plugin-kit' ) . '%3$s' . esc_html__( 'or greater.', 'wpkin-plugin-kit' ),
		'<strong>' . esc_html__('WPKIN Plugin Kit', 'wpkin-plugin-kit') . '</strong>',
		'<strong>' . esc_html__('Woocommerce', 'wpkin-plugin-kit') . '</strong>',
		floatval( WPK_PK_MINIMUM_WC_VERSION ) );
	}

}
