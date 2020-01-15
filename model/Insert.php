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
    protected $links;

    public function __construct() {
        global $wpdb;

        $this->links = "`" . $wpdb->prefix . "zn_redirect_links`";
    }

    public function setNewLinks($zn_from,$zn_to,$zn_type){
		$db = $this->db_connect();
		$query="
            INSERT INTO " . $this->links . " (`From`,`To`,`Type`) VALUES 
            ('". $zn_from. "','" . $zn_to . "','" . $zn_type . "')";
		$result = $db->query($query);
		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
    }
	
	public function extractPost($post){
		return print_r($post);

	}

    
}
