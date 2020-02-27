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

        $this->redirect_links = "`" . $wpdb->prefix . "zn_redirect_links`";
        $this->redirect_visits = "`" . $wpdb->prefix . "zn_redirect_visits`";
    }

    public function getAllLinks() {
      $db = $this->db_connect();
      $sql= "
        SELECT * FROM ". $this->redirect_links;
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
        SELECT * FROM ". $this->redirect_links . " WHERE `Redirect_ID` = " . $zn_edit_id."
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
        SELECT * FROM " . $this->redirect_links . " ORDER BY `Redirect_ID` DESC LIMIT 1
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
      $result = $wpdb->get_results( "SELECT * FROM ". $this->redirect_links );
      return $result;
    }

    public function getColumns()
    {
      global $wpdb;
      $result = $wpdb->get_results( "SHOW COLUMNS FROM " . $this->redirect_links );
      return $result;
    }

    /** NOT USING ANYMORE - OLD REQEUST */
    public function getLinkRequest($request)
    {
      $db = $this->db_connect();
      $sql = "
        SELECT * FROM " . $this->redirect_links . " WHERE `From` = '$request'";
      $result = $db->query($sql);
      if ($result) {
        return $result;
      } else {
        die("MYSQL Error : " . mysqli_error($db));
      }
    }

    public function checkLinkStatus($zn_ID)
    {
      $db = $this->db_connect();
      $sql = "
        SELECT `Status` FROM " . $this->redirect_links . " WHERE `Redirect_ID` = ". $zn_ID."
        ";
      $result = $db->query($sql);
      if ($result) {
        $row = $result->fetch_assoc();
        return $row['Status'];
      } else {
        die("MYSQL Error : " . mysqli_error($db));
      }
    }

    public function getAllHistory() {
      $db = $this->db_connect();
      $sql= "
        SELECT * FROM ". $this->redirect_visits;
      $result = $db->query($sql);
      if($result){
        return $result;
      }else{
        die("MYSQL Error : ".mysqli_error($db));
      }
    }
}