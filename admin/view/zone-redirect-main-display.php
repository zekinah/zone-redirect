<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/zekinah
 * @since      1.0.0
 *
 * @package    Zone_Redirect
 * @subpackage Zone_Redirect/admin/partials
 */
?>

<div class="gdpr-card">
    <div class="gdpr-card-header">
        <h2>Zone Redirect</h2>
    </div>
    <div class="container-fluid">
        <?php
        $tab_option = array('Home', 'Manage Redirection', 'Setup', 'History');
        echo '<ul class="nav nav-tabs" role="tablist">';
        foreach ($tab_option as $key => $option_setting) {
            if ($key == 0) {
                $class = "nav-link active";
            } else {
                $class = "nav-link";
            }
            echo '<li class="nav-item">';
            echo '<a class="' . $class . '" data-toggle="tab" href="#tab-' . $key . '">' . $option_setting . '</a>';
            echo '</li>';
        }
        echo ' </ul>';
        ?>
        <div class="tab-content">
            <div id="tab-0" class="container-fluid tab-pane active">
            <!-- Home -->
                <?php require_once('tabs/tab-home.php'); ?>
            </div>
            <!-- Redirect -->
            <div id="tab-1" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-redirect.php'); ?>
            </div>
            <!-- Setup -->
            <div id="tab-2" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-setup.php'); ?>
            </div>
            <!-- History -->
            <div id="tab-3" class="container-fluid tab-pane fade"><br>
                <?php require_once('tabs/tab-history.php'); ?>
            </div>
        </div>
    </div>
</div>