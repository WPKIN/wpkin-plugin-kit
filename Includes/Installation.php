<?php

namespace WPK_PLUGIN_KIT\Includes;

/**
 * Plugin Installation Class
 *
 * @since 1.0.0
 */
class Installation {

	/**
	 * Installation class constructor
	 *
	 * Database
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->activate();
	}

	/**
	 * After activate Plugin
	 *
	 * @since 1.0.0
	 */
	public function activate() {

		$installed = get_option( 'wpkin_pk_installed' );

		if ( ! $installed ) {
			update_option( 'wpkin_pk_installed', time() );
		}

		update_option( 'wpk_pk_version', WPK_PK_VERSION );

		add_option( 'wpkin_pk_activation_redirect', true );
	}

}
