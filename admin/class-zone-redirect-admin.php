<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/zekinah
 * @since      1.0.0
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/admin
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */
require_once(plugin_dir_path(__FILE__) . '../model/model.php');

class Zone_Redirect_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->insert = new Zone_Redirect_Model_Insert();
		$this->display = new Zone_Redirect_Model_Display();
		$this->update = new Zone_Redirect_Model_Update();
		$this->deployZone();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zone-redirect-admin.css', array(), $this->version, 'all' );
		/* Bootstrap 4 CSS */
		echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__) . 'css/bootstrap/bootstrap.min.css">';
		wp_enqueue_style('zone-redirect-datatable-css', plugin_dir_url(__FILE__) . 'css/datatable/jquery.dataTables.css', array(), $this->version);
		wp_enqueue_style('zone-redirect-pnotify', plugin_dir_url(__FILE__) . 'css/pnotify/pnotify.css', array(), $this->version);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/zone-redirect-admin.js', array( 'jquery' ), $this->version, false );
		/* Bootstrap 4 JS */
		echo '<script src="'.plugin_dir_url(__FILE__) . 'js/bootstrap/jquery-3.3.1.slim.min.js"></script>
		<script src="'.plugin_dir_url(__FILE__) . 'js/bootstrap/popper.min.js"></script>
		<script src="'.plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap.min.js"></script>';
		wp_enqueue_script('zone-redirect-toggle', plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap-toggle.min.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-fontawesome', plugin_dir_url(__FILE__) . 'js/fontawesome/all.js', array('jquery'), '5.9.0', false);
		wp_enqueue_script('zone-redirect-pnotify', plugin_dir_url(__FILE__) . 'js/pnotify/pnotify.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-datatable-js', plugin_dir_url(__FILE__) . 'js/datatable/jquery.dataTables.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-ajax', plugin_dir_url(__FILE__)  . 'js/zone-redirect-ajax.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_localize_script('zone-redirect-ajax', 'redirectsettingsAjax', array('ajax_url' => admin_url('admin-ajax.php')));

	}

	public function deployZone()
	{
		add_action('admin_menu', array(&$this, 'zoneOptions'));

		add_action('wp_ajax_save_redirection_link',  array(&$this, 'save_redirection_link'));
	}

	public function zoneOptions()
	{
		add_menu_page(
			'Zone Redirect', 	//Page Title
			'Zone Redirect',   //Menu Title
			'manage_options', 			//Capability
			'zone-redirect', 				//Page ID
			array(&$this, 'zoneOptionsPage'),		//Functions
			'dashicons-admin-site-alt3', 						//Favicon
			99							//Position
		);
	}

	public function zoneOptionsPage()
	{
		$tbl_links = $this->display->getAllLinks();
		require_once('view/zone-redirect-main-display.php');
	}

	public function save_redirection_link()
	{
		extract($_POST);
		if (isset($zn_nonce)) {
			$tbl_links = $this->insert->setNewLinks($zn_txt_from,$zn_txt_to,$zn_txt_type);
			// if ($tbl_links) {
			// 	$data = 1;
			// } else {
			// 	$data = 0;
			// }
		}
		echo $tbl_links;
		exit();
	}

}
