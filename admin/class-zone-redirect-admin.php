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
		wp_enqueue_style('zone-redirect-bootstrap-css', plugin_dir_url(__FILE__) . 'css/bootstrap/bootstrap.min.css', array(), $this->version);
		wp_enqueue_style('zone-redirect-bootstrap-toggle', plugin_dir_url(__FILE__) . 'css/bootstrap/bootstrap-toggle.min.css', array(), $this->version);
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
		wp_enqueue_script('jquery');
		/* Bootstrap 4 JS */
		wp_enqueue_script('zone-redirect-bootstrap-js', plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap.min.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-toggle', plugin_dir_url(__FILE__) . 'js/bootstrap/bootstrap-toggle.min.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-fontawesome', plugin_dir_url(__FILE__) . 'js/fontawesome/all.js', array('jquery'), '5.9.0', false);
		wp_enqueue_script('zone-redirect-pnotify', plugin_dir_url(__FILE__) . 'js/pnotify/pnotify.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-datatable-js', plugin_dir_url(__FILE__) . 'js/datatable/jquery.dataTables.js', array('jquery'), $this->version);
		wp_enqueue_script('zone-redirect-ajax', plugin_dir_url(__FILE__)  . 'js/zone-redirect-ajax.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_localize_script('zone-redirect-ajax', 'redirectsettingsAjax', array('ajax_url' => admin_url('admin-ajax.php'),'ajax_nonce'=>wp_create_nonce('zn-ajax-nonce')));

	}

	public function deployZone()
	{
		add_action('admin_menu', array(&$this, 'zoneOptions'));
		add_action('wp_ajax_save_redirection_link',  array(&$this, 'save_redirection_link'));
		add_action('wp_ajax_load_link_info',  array(&$this, 'load_link_info'));
		add_action('wp_ajax_update_redirection_link',  array(&$this, 'update_redirection_link'));
		add_action('wp_ajax_trash_link',  array(&$this, 'trash_link'));
		add_action('wp_ajax_change_link_status',  array(&$this, 'change_link_status'));
		add_action('wp_ajax_importing_spreadsheet',  array(&$this, 'importing_spreadsheet'));
		add_action('wp_ajax_exporting_spreadsheet',  array(&$this, 'exporting_spreadsheet'));
	}

	public function zoneOptions()
	{
		global $zoneRedirectMenu;
		$zoneRedirectMenu = add_menu_page(
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
		$tbl_visits = $this->display->getAllHistory();
		require_once('view/zone-redirect-main-display.php');
	}

	public function save_redirection_link()
	{
		$data = array();
		$zn_txt_from = sanitize_text_field($_POST['zn_txt_from']);
		$zn_txt_to = sanitize_text_field($_POST['zn_txt_to']);
		$zn_txt_type = sanitize_text_field($_POST['zn_txt_type']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$response = wp_remote_get( esc_url_raw( $zn_txt_to ) ); // no need to escape entities
			if ( ! is_wp_error( $response ) ) {
				$tbl_links = $this->insert->addNewLinks($zn_txt_from,$zn_txt_to,$zn_txt_type);
				$tbl_getlink = $this->display->getLastLink();
			} else {
				$data['confirm'] = 2;
			}
			if ($tbl_links) {
				$data['confirm'] = 1;
				$temp_html = '<tr>';
				foreach($tbl_getlink as $getLinkID => $row ){
					if($row->Status == '1') {
						$status = 'checked';
					} else {
						$status = '';
					}
					$temp_html .= '<td>' .$row->Redirect_ID. '</td>';
					$temp_html .= '<td>' .$row->From. '</td>';
					$temp_html .= '<td>' .$row->To. '</td>';
					$temp_html .= '<td>' .$row->Type. '</td>';
					$temp_html .= '<td>' .date('M d, Y', strtotime($row->Date)). '</td>';
					$temp_html .= '<td>
								<div class="toggle btn btn-primary" data-toggle="toggle" style="width: 50.9531px; height: 28px;">
								<input class="form-check-input" id="zn_link_stat" type="checkbox" data-redirectid_stat="'. $row->Redirect_ID .'" name="zn_link_stat" '. $status .' data-toggle="toggle">
								<div class="toggle-group">
									<label class="btn btn-primary toggle-on">On</label>
									<label class="btn btn-default active toggle-off">Off</label>
									<span class="toggle-handle btn btn-default"></span>
								</div>
								</div>
								</td>
								';
					$temp_html .= '<td>
									<a href="#TB_inline?width=600&height=400&inlineId=edit-links" class="thickbox btn btn-info btn-xs btn-link-update"
									data-link_edit_id="'. $row->Redirect_ID . '"
									data-link_edit_from="'. $row->From . '"
									data-link_edit_to="'. $row->To . '"
									data-link_edit_type="'. $row->Type . '"
									title="Update"><i class="fas fa-edit"></i></a>
									<a href="#" class="btn btn-danger btn-xs btn-link-remove"
									data-link_rem_id="'. $row->Redirect_ID . '"
									title="Move to trash"><i class="far fa-trash-alt"></i></a>
								</td>';
					$temp_html .= '</tr>';
				}
				$data['html'] = $temp_html;
			} else {
				$data['confirm'] = 0;
			}
		}
		wp_send_json($data);
		echo $data;
		wp_die();
	}

	public function update_redirection_link()
	{
		$zn_edit_id = sanitize_text_field($_POST['zn_edit_id']);
		$zn_txt_from = sanitize_text_field($_POST['zn_txt_from']);
		$zn_txt_to = sanitize_text_field($_POST['zn_txt_to']);
		$zn_txt_type = sanitize_text_field($_POST['zn_txt_type']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$response = wp_remote_get( esc_url_raw( $zn_txt_to ) ); // no need to escape entities
			if ( ! is_wp_error( $response ) ) {
				$tbl_linkupdate = $this->update->update_redirection_link($zn_edit_id, $zn_txt_from, $zn_txt_to, $zn_txt_type);
				$tbl_getlink = $this->display->getLinkInfo($zn_edit_id);
			} else {
				$data['confirm'] = 0;
			}
			if ($tbl_linkupdate) {
				$data['confirm'] = 1;
				$temp_html = '';
				foreach($tbl_getlink as $getLinkID => $row) {
					if($row->Status == '1') {
						$status = 'checked';
					} else {
						$status = '';
					}
					$temp_html .= '<td>' .$row->Redirect_ID. '</td>';
					$temp_html .= '<td>' .$row->From. '</td>';
					$temp_html .= '<td>' .$row->To. '</td>';
					$temp_html .= '<td>' .$row->Type. '</td>';
					$temp_html .= '<td>' .date('M d, Y', strtotime($row->Date)). '</td>';
					$temp_html .= '<td>
								<div class="toggle btn btn-primary" data-toggle="toggle" style="width: 50.9531px; height: 28px;">
									<input class="form-check-input" id="zn_link_stat" type="checkbox" data-redirectid_stat="'. $row->Redirect_ID .'" name="zn_link_stat" '. $status .' data-toggle="toggle">
									<div class="toggle-group">
										<label class="btn btn-primary toggle-on">On</label>
										<label class="btn btn-default active toggle-off">Off</label>
										<span class="toggle-handle btn btn-default"></span>
									</div>
								</div></td>';
					$temp_html .= '<td>
									<a href="#TB_inline?width=600&height=400&inlineId=edit-links" class="thickbox btn btn-info btn-xs btn-link-update"
									data-link_edit_id="'. $row->Redirect_ID . '"
									data-link_edit_from="'. $row->From . '"
									data-link_edit_to="'. $row->To . '"
									data-link_edit_type="'. $row->Type . '"
									title="Update"><i class="fas fa-edit"></i></a>
									<a href="#" class="btn btn-danger btn-xs btn-link-remove"
									data-link_rem_id="'. $row->Redirect_ID . '"
									title="Move to trash"><i class="far fa-trash-alt"></i></a>
								</td>';
				
				}
				$data['html'] = $temp_html;
			} else {
				$data['confirm'] = 0;
			}
		}
		wp_send_json($data);
		wp_die();
	}

	public function load_link_info()
	{
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$dataFeed = '';
			$dataFeed .= '<div class="row">
				<input type="hidden" id="zn_edit_id" value="'.sanitize_text_field($_POST['link_edit_id']).'">
				<div class="col-md-12">
					<div class="form-group">
						<label><strong>From URL</strong></label>
						<input type="text" class="form-control" id="zn_edit_from" value="' . sanitize_text_field($_POST['link_edit_from']) . '" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label><strong>To URL</strong></label>
						<input type="text" class="form-control" id="zn_edit_to" value="' . sanitize_text_field($_POST['link_edit_to']) . '" />
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label><strong>Redirection Type</strong></label>
						<input type="text" class="form-control" id="zn_edit_type" value="' . sanitize_text_field($_POST['link_edit_type']) . '" readonly/>
					</div>
				</div>
			</div>';
		}
		echo $dataFeed;
		wp_die();
	}

	public function trash_link()
	{
		$link_rem_id = sanitize_text_field($_POST['link_rem_id']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$tbl_links = $this->update->trashLink($link_rem_id);
			// if ($tbl_links) {
			// 	$data = 1;
			// } else {
			// 	$data = 0;
			// }
		}
		echo $tbl_links;
		wp_die();
	}

	public function change_link_status()
	{
		$zn_link_stat_id = sanitize_text_field($_POST['zn_link_stat_id']);
		if (check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )) {
			$link_stat = $this->display->checkLinkStatus($zn_link_stat_id);
			if ($link_stat) {
				/** Change to OFF link */
				$tbl_link = $this->update->offRedirectLink($zn_link_stat_id);
				$data = 0;
			} else {
				/** Change to ON link */
				$tbl_link =  $this->update->onRedirectLink($zn_link_stat_id);
				$data = 1;
			}
		}
		echo $data;
		wp_die();
	}

	public function importing_spreadsheet()
	{
		$zn_import_file = sanitize_text_field($_POST['zn_import_file']);
		$zn_start_row = sanitize_text_field($_POST['zn_start_row']);
		$zn_update_data = sanitize_text_field($_POST['zn_update_data']);
		if(check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )){
			$extension = pathinfo($zn_import_file, PATHINFO_EXTENSION);
			// If file extension is 'csv'
			if(!empty($zn_import_file) && $extension == 'csv'){
				try {
					$tbl_import = $this->insert->importingData($zn_import_file,$zn_start_row,$zn_update_data);
					echo $tbl_import;
				} catch(Exception $e) {
					echo 'Message: ' .$e->getMessage();
				}
			}else{
				echo "Invalid Extension";
			}
		}
		wp_die();
	}

	public function exporting_spreadsheet()
	{
		if(check_ajax_referer( 'zn-ajax-nonce', '_ajax_nonce' )){
			ob_end_clean();
			$field = '';
			$getField = '';
			$result = $this->display->getLinkData();
			$columnsList = $this->display->getColumns();
			$fieldsCount = count( $columnsList );

			foreach ( $columnsList as $column ) {
				$getField .= $column->Field . ',';
			}
			$sub = substr_replace( $getField, '', -1 );
			$fields = $sub . "\n"; // Get fields names
			$csv_file_name = 'Zone_Redirect_Links_' . date( 'Y-m-d' ) . '.csv';

			// Get fields values with last comma excluded
			foreach ( $result as $row ) {
				foreach ( $row as $data ) {
					$value	 = str_replace( array( "\n", "\n\r", "\r\n", "\r" ), "\t", $data ); // Replace new line with tab
					$value	 = str_getcsv( $value, ",", "\"", "\\" ); // SEQUENCING DATA IN CSV FORMAT, REQUIRED PHP >= 5.3.0
					$fields	 .= $value[ 0 ] . ','; // Separate fields with comma
				}
				$fields	 = substr_replace( $fields, '', -1 ); 
				$fields	 .= "\n";
			}

			header( "Content-type: text/csv" );
			header( "Content-Transfer-Encoding: binary" );
			header( "Content-Disposition: attachment; filename=" . $csv_file_name );
			header( "Content-type: application/x-msdownload" );
			header( "Pragma: no-cache" );
			header( "Expires: 0" );

			echo $fields;
		}
		wp_die();
	}
}
