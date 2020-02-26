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

class Zone_Redirect_Model_Display extends Zone_Redirect_Model_Config {

    protected $requester;

    public function __construct() {
        global $wpdb;

        $this->links = "`" . $wpdb->prefix . "zn_redirect_links`";
    }

    public function getAllLinks() {
      $db = $this->db_connect();
      $sql= "
        SELECT * FROM ". $this->links;
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getLinkInfo($zn_edit_id)
    {
      $db = $this->db_connect();
      $sql= "
        SELECT * FROM ". $this->links . " WHERE `Redirect_ID` = " . $zn_edit_id."
        ";
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }

    public function getLastLink()
    {
      $db = $this->db_connect();
      $sql = "
        SELECT * FROM " . $this->links . " ORDER BY `Redirect_ID` DESC LIMIT 1
        ";
      $result = $db->query($sql);
      if ($result) {
        return $result;
      } else {
        die("MYSQL Error : " . mysqli_error($db));
      }
    }

    public function getLinkData()
    {
      global $wpdb;
      $result = $wpdb->get_results( "SELECT * FROM ". $this->links );
      return $result;
    }

    public function getColumns()
    {
      global $wpdb;
      $result = $wpdb->get_results( "SHOW COLUMNS FROM " . $this->links );
      return $result;
    }

    public function getLinkRequest($request)
    {
      $db = $this->db_connect();
      $sql = "
        SELECT * FROM " . $this->links . " WHERE `From` = '$request'";
      $result = $db->query($sql);
      if ($result) {
        return $result;
      } else {
        die("MYSQL Error : " . mysqli_error($db));
      }
    }
}