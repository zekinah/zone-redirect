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
class Zone_Redirect_Model_Config
{

    /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function __construct() {
        global $wpdb;

		if ( defined( 'ZONE_REDIRECT_VERSION' ) ) {
			$this->version = ZONE_REDIRECT_VERSION;
		} else {
			$this->version = '1.0.2';
		}
        $this->plugin_name = 'zone-redirect';
        $this->wpdb = $wpdb;

	}

    public function createTable()
    {
        $table_prefix = $this->wpdb->prefix;
        $charset_collate = $this->wpdb->get_charset_collate();
        $queries = array();

        /** Requester */
        $queries[] = "
			CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_redirect_links` (
			 `Redirect_ID` int(11) NOT NULL AUTO_INCREMENT,
			 `From` TEXT NOT NULL,
			 `To` TEXT NOT NULL,
			 `Type` varchar(50) NOT NULL,
			 `Status` int(1) NOT NULL DEFAULT '1',
			 `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 PRIMARY KEY (`Redirect_ID`)
            )".$charset_collate;
            
        $queries[] = "
            CREATE TABLE IF NOT EXISTS `" . $table_prefix . "zn_redirect_visits` (
            `RedirectVisit_ID` int(11) NOT NULL AUTO_INCREMENT,
            `Visited_From` TEXT NOT NULL,
            `Visited_To` TEXT NOT NULL,
            `Visited_Type` varchar(50) NOT NULL,
            `Last_visited_Date` timestamp NOT NULL,
            PRIMARY KEY (`RedirectVisit_ID`)
           )".$charset_collate;
       
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // create structure
         foreach ($queries as $query) {
            dbDelta($query);
        }
        add_option('zone_redirect_version', $this->version);
    }

    public function dropTable()
    {
        $table_prefix = $this->wpdb->prefix;

        $this->wpdb->query("DROP TABLE IF EXISTS `" . $table_prefix . "zn_redirect_links`");
        $this->wpdb->query("DROP TABLE IF EXISTS `" . $table_prefix . "zn_redirect_visits`");

        // DROP TABLE `wp_zn_redirect_links`, `wp_zn_redirect_visits`
    }
}
