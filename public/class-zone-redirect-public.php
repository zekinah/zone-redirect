<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/zekinah
 * @since      1.0.0
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/public
 * @author     Zekinah Lecaros <zjlecaros@gmail.com>
 */

class Zone_Redirect_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->insert = new Zone_Redirect_Model_Insert();
		$this->display = new Zone_Redirect_Model_Display();
		$this->deployZone();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zone-redirect-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/zone-redirect-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Outputs the Zone on the frontend
	 */
	public function deployZone() {
		$url_request =str_ireplace(get_option('home'),'',$this->get_address());
		if (is_admin() || empty($url_request)){
			return false;
		} else {
			$this->redirect($url_request);
		}
	}

	public function redirect($url_request) {
		$tbl_redirects = $this->display->getAllLinks();
		if (!empty($tbl_redirects)) {
			foreach($tbl_redirects as $redirectsID => $row) {
				$requestFrom = $row->From;
				$requestTo = urldecode($row->To);
				$stat = $row->Status;
				$type = $row->Type;
				if($stat) {
					if(rtrim(trim($requestFrom), '/') === rtrim(trim($url_request), '/')) {
						$data_and_time_today = date('Y-m-d H:i:s');
						$counted = $this->insert->setVisits($requestFrom,$requestTo,$type,$data_and_time_today);
						if($type == '301'){
							header('Cache-Control: no-store');
							header('HTTP/1.1 301 Moved Permanently');
						} elseif ($type == '302') {
							header('HTTP/1.1 302 Moved Temporarily');
						}
						if($counted) {
							header ('Location: ' . $requestTo,true,$type);
							exit();
						}
					}
				} else {
					unset($url_request);
				}
			}	
			
		}
	}

	public	function get_address() {
		return $this->get_protocol().'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
		
	public	function get_protocol() {
		// Set the base protocol to http
		$protocol = 'http';
		// check for https
		if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {
			$protocol .= "s";
		}
		return $protocol;
	} 

}
