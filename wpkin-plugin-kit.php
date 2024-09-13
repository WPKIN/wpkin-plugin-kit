<?php
/**
 * Plugin Name:       WPKIN Plugin Kit
 * Plugin URI:        https://wpkin.com
 * Description:       This is a plugin kit
 * Version:           1.0.0
 * Author:            Richard
 * Author URI:        https://wpkin.com
 * Text Domain:       wpkin-plugin-kit
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package wpkin plugin kit.
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'wpkin-plugin-kit' ) );
}

/**
 * Included Autoload File
 */
require_once __DIR__ . '/vendor/autoload.php';

/** If class `WPKIN_Plugin_Kit` doesn't exists yet. */
if ( ! class_exists( 'WPKIN_Plugin_Kit' ) ) {

	/**
	 * Set up and initializes the plugin.
	 * Main initiation class
	 *
	 * @since 1.0.0
	 */
	final class WPKIN_Plugin_Kit {

		/**
		 * Plugin Version
		 */
		const VERSION = '1.0.0';

		/**
		 * Php Version
		 */
		const MIN_PHP_VERSION = '7.4';

		/**
		 * WC Version
		 */
		const MIN_WC_VERSION = '8.0.0';

		/**
		 * WordPress Version
		 */
		const MIN_WP_VERSION = '6.2';

		/**
		 * Class Constractor
		 */
		private function __construct() {

			$this->define_constance();
			register_activation_hook( __FILE__, [ $this, 'activate' ] );
			register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
			add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
			add_action( 'init', [ $this, 'i18n' ] );
			add_action( 'admin_init', [$this, 'activation_redirect'] );
			add_filter( 'plugin_action_links_' . plugin_basename( WPK_PK_FILE ), [ __CLASS__, 'wpkin_pk_action_links' ] );
		}

		/**
		 * Initilize a singleton instance
		 *
		 * @return /Order_Layouts
		 */
		public static function init() {

			static $instance = false;

			if ( ! $instance ) {

				$instance = new self();
			}

			return $instance;
		}

		/**
		 * Plugin Constance
		 *
		 * @return void
		 */
		public function define_constance() {

			define( 'WPK_PK_VERSION', self::VERSION );
			define( 'WPK_PK_FILE', __FILE__ );
			define( 'WPK_PK_PATH', plugin_dir_path( __FILE__ ) );
			define( 'WPK_PK_URL', plugins_url( '', WPK_PK_FILE ) );
			define( 'WPK_PK_ASSETS', WPK_PK_URL . '/assets/' );
			define( 'WPK_PK_MINIMUM_PHP_VERSION', self::MIN_PHP_VERSION );
			define( 'WPK_PK_MINIMUM_WC_VERSION', self::MIN_WC_VERSION );
			define( 'WPK_PK_MINIMUM_WP_VERSION', self::MIN_WP_VERSION );

		}

		/**
		 * After Activate Plugin
		 *
		 * Fired by `register_activation_hook` hook.
		 *
		 * @return void
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function activate() {
			new WPK_PLUGIN_KIT\Includes\Installation();
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function i18n() {
			// load_plugin_textdomain( WPK_SC_TEXT_DOMAIN );
		}

		/**
		 * After Deactivate Plugin
		 *
		 * @return void
		 */
		public function deactivate() {

		}

		/**
		 * Plugins Loaded
		 *
		 * @return void
		 */
		public function init_plugin() {
			new WPK_PLUGIN_KIT\Includes\Assets();
			new WPK_PLUGIN_KIT\Includes\Frontend();
			if ( is_admin() ) {
				new WPK_PLUGIN_KIT\Includes\Admin();
			}
		}

		/**
		 *
		 * Redirect to settings page after activation the plugin
		 */
		public function activation_redirect() {

			if ( get_option( 'wpkin_pk_activation_redirect', false ) ) {

				delete_option( 'wpkin_pk_activation_redirect' );

				wp_safe_redirect( admin_url( 'admin.php?page=store-commander' ) );
				exit();
			}
		}

		/**
		 * Plugin Page Settings menu
		 *
		 * @param mixed $links .
		 */
		public static function wpkin_pk_action_links( $links ) {

			if ( ! current_user_can( 'manage_options' ) ) {
				return $links;
			}

			$links = array_merge(
				[
					sprintf(
						'<a href="%s">%s</a>',
						admin_url( 'admin.php?page=store-commander' ),
						esc_html__( 'Settings', 'store-commander' )
					),
				],
				$links
			);

			return $links;
		}
	}

}

/**
 * Initilize the main plugin
 *
 * @return /WPKIN_Plugin_Kit
 */
function wpkin_plugin_kit() {

	if ( class_exists( 'WPKIN_Plugin_Kit' ) ) {
		return WPKIN_Plugin_Kit::init();
	}

	return false;
}

/**
 * Kick-off the plugin
 */
wpkin_plugin_kit();

