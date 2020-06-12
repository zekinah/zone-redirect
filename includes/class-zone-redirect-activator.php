<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/zekinah
 * @since      1.0.0
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/includes
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
	
class Zone_Redirect_Activator {

	public static function activate() {
		$db = new Zone_Redirect_Model_Config();
		$db->createTable();
	}

}
