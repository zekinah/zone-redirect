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

require_once('Config.php');

class Zone_Redirect_Model_Insert extends Zone_Redirect_Model_Config
{
    protected $redirect_links;

    public function __construct() {
        global $wpdb;

        $this->redirect_links = "`" . $wpdb->prefix . "zn_redirect_links`";
    }

    public function setNewLinks($zn_from,$zn_to,$zn_type){
		$db = $this->db_connect();
		$query="
            INSERT INTO " . $this->redirect_links . " (`From`,`To`,`Type`) VALUES 
            ('". $zn_from. "','" . $zn_to . "','" . $zn_type . "')";
		$result = $db->query($query);
		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
	}
	
	public function importingData($zn_import_file,$zn_start_row,$zn_update_data)
	{
		$db = $this->db_connect();
		$totalInserted = 0;
		$totalDuplicated = 0;
		$csvData = array();
		$csvFile = fopen($zn_import_file, 'r');
		$temp = 0;
		while ( ( $row = fgetcsv( $csvFile )) !== false ) {  // Get file contents and set up row array
			$csvData[] = array_map("utf8_encode", $row); // Each new line of .csv file becomes an array
			if( count( $csvData ) >= $zn_start_row) {
				$zn_from = trim($csvData[$temp][0]);
				$zn_to = trim($csvData[$temp][1]);
				$zn_type = trim($csvData[$temp][2]);
				if(!empty($zn_from) && !empty($zn_to) && !empty($zn_type) ) {
					if(!$zn_update_data) {
						$query="
							INSERT INTO " . $this->redirect_links . " (`From`,`To`,`Type`) VALUES 
							('". $zn_from. "','" . $zn_to . "','" . $zn_type . "')";
						$result = $db->query($query);
						if($result){
							$totalInserted++;
						}else{
							die("MYSQL Error : ".mysqli_error($db));
						}
					} else {
						$query="
							INSERT INTO " . $this->redirect_links . " (`From`,`To`,`Type`) VALUES 
							('". $zn_from. "','" . $zn_to . "','" . $zn_type . "')
							ON DUPLICATE KEY UPDATE `To` = '. $zn_to .'  ;";
						$result = $db->query($query);
						if($result){
							$totalDuplicated++;
						}else{
							die("MYSQL Error : ".mysqli_error($db));
						}
					}
				}
			}
			$temp++;
		}
		$message = 'Total record Inserted : '.$totalInserted.'<br>';
		$message .= 'Total record Updated : '.$totalDuplicated;
		return $message;
		// https://pv-locale.primeview.com/wp-content/uploads/2020/02/zone-redirect2-1.csv
	}
	
	public function extractPost($post){
		return print_r($post);

	}

    
}
