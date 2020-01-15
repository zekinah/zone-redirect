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

class Zone_Redirect_Model_Update extends Zone_Redirect_Model_Config
{
    protected $requester;

    public function __construct() {
        global $wpdb;

        $this->links = "`" . $wpdb->prefix . "zn_redirect_links`";
    }

    public function offRedirectLink($zn_id){
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->zn_redirect_links . " SET
                `Status` = '0'
            WHERE `Redirect_ID` = '". $zn_id."'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }

    public function onRedirectLink($zn_id){
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->zn_redirect_links . " SET
                `Status` = '1'
            WHERE `Redirect_ID` = '". $zn_id."'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }

    public function setNewlinks($zn_id,$zn_from,$zn_to,$zn_type){
        $db = $this->db_connect();
        $query = "
            UPDATE " . $this->zn_redirect_links . " SET
                `From` = '". $zn_from."',
                `To` = '". $zn_to."',
                `Type` = '". $zn_type."'
            WHERE `Redirect_ID` = '". $zn_id."'";
        $result = $db->query($query);
        if ($result) {
            return true;
        } else {
            die("MYSQL Error : " . mysqli_error($db));
        }
    }
}
