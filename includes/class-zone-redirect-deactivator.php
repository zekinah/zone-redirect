<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/zekinah
 * @since      1.0.0
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/includes
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
class Zone_Redirect_Deactivator {

	public static function deactivate() {
		$db = new Zone_Redirect_Model_Config();
		$db->dropTable();
	}

}
