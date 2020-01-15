<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/zekinah
 * @since      1.0.0
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/includes
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
class Zone_Redirect_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'zone-redirect',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
