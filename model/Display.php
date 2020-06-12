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


class Zone_Redirect_Model_Display {

    protected $redirect_links;
    protected $redirect_visits;
    protected $wpdb;

    public function __construct() {
        global $wpdb;

        $this->redirect_links = "`" . $wpdb->prefix . "zn_redirect_links`";
        $this->redirect_visits = "`" . $wpdb->prefix . "zn_redirect_visits`";
        $this->wpdb = $wpdb;
    }

    public function getAllLinks() {
      $sql= "
        SELECT * FROM ". $this->redirect_links;
      $result = $this->wpdb->get_results($sql);
      if($result){
        return $result;
      }else{
        $this->wpdb->show_errors();
      }
    }

    public function getLinkInfo($zn_edit_id)
    {
      $sql= "
        SELECT * FROM ". $this->redirect_links . " WHERE `Redirect_ID` = " . $zn_edit_id."
        ";
      $result = $this->wpdb->get_results($sql);
      if($result){
        return $result;
      }else{
        $this->wpdb->show_errors();
      }
    }

    public function getLastLink()
    {
      $sql = "
        SELECT * FROM " . $this->redirect_links . " ORDER BY `Redirect_ID` DESC LIMIT 1
        ";
      $result = $this->wpdb->get_results($sql);
      if ($result) {
        return $result;
      } else {
        $this->wpdb->show_errors();
      }
    }

    public function getLinkData()
    {
      $result = $this->wpdb->get_results( "SELECT * FROM ". $this->redirect_links );
      return $result;
    }

    public function getColumns()
    {
      $result =$this->wpdb->get_results( "SHOW COLUMNS FROM " . $this->redirect_links );
      return $result;
    }

    /** NOT USING ANYMORE - OLD REQEUST */
    public function getLinkRequest($request)
    {
      $sql = "
        SELECT * FROM " . $this->redirect_links . " WHERE `From` = '$request'";
      $result = $this->wpdb->get_results($sql);
      if ($result) {
        return $result;
      } else {
        $this->wpdb->show_errors();
      }
    }

    public function checkLinkStatus($zn_ID)
    {
      $sql = "
        SELECT `Status` FROM " . $this->redirect_links . " WHERE `Redirect_ID` = ". $zn_ID."
        ";
      $result = $this->wpdb->get_results($sql);
      if ($result) {
        foreach($result as $res => $row){
          return $row->Status;
        }
      } else {
        $this->wpdb->show_errors();
      }
    }

    public function getAllHistory() {
      $sql= "
        SELECT * FROM ". $this->redirect_visits;
      $result = $this->wpdb->get_results($sql);
      if($result){
        return $result;
      }else{
        $this->wpdb->show_errors();
      }
    }
}