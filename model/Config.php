<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/admin/model
 * @author     Zekinah Lecaros <zjlecaros@gmail.com> 
 * 
 */

/******************************************************************
This Model is the parent model class that returns database object
 *******************************************************************/

require_once(ABSPATH . 'wp-config.php');

class Zone_Redirect_Model_Config
{

    public $wpdb;

    public function db_connect()
    {
        $localhost    = DB_HOST;
        $user        = DB_USER;
        $pw            = DB_PASSWORD;
        $database    = DB_NAME;
        $db = new mysqli($localhost, $user, $pw, $database);
        if ($db) {
            return $db;
        } else {
            die("Connection failed: " . $db->connect_error);
        }
    }

    public function createTable()
    {
        global $wpdb;
        $db = $this->db_connect();

        /** Requester */
        $query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_redirect_links` (
			 `Redirect_ID` int(11) NOT NULL AUTO_INCREMENT,
			 `From` TEXT NOT NULL,
			 `To` TEXT NOT NULL,
			 `Type` varchar(50) NOT NULL,
			 `Status` int(1) NOT NULL DEFAULT '1',
			 `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 PRIMARY KEY (`Redirect_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
			";
       
        $sql = $db->query($query);

        if ($sql) {
                return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
            // DROP TABLE `wp_zn_redirect_links`
        }
    }
}
