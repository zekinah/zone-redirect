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
$zn_form_nonce = wp_create_nonce('zn_form_nonce');
?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
        <h2>Import Data</h2>
            <div class="form">
                <div class="form-group">
                    <label><strong>Select Input File:</strong></label>
                    <?php
                    extract($_POST);
                    $selectedFile = isset($selected_file) ? $selected_file : null; ?>
                    <input name="selected_file" id="selected_file" type="text" size="70" value="<?=$selectedFile?>"/>
                    <button id="btn-upload" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-upload btn-zn-primary pull-r">Upload</button>
                    <br><?php _e( 'File must end with a .csv extension.'); ?>
                </div>
                <div class="form-group">
                    <label><strong>Select Starting Row:</strong></label>
                    <input id="zn_start_row" name="zn_start_row" type="number" min="0"/>
                    <br><?php _e( 'Defaults to row 1 (top row) of .csv file.'); ?>
                </div>
                <div class="form-group">
                    <label><strong>Update exisiting data:</strong></label>
                    <input class="form-check-input zn_update_data" id="zn_update_data" data-nonce="<?= $zn_form_nonce ?>" type="checkbox" name="zn_update_data" data-toggle="toggle">
                    <br><?php _e( 'Will update exisiting database rows when a duplicated primary key is encountered. Defaults to all rows inserted as new rows.'); ?>
                </div>
                <?php
                    $csvpath =  plugin_dir_url( dirname( __FILE__ ) ).'file/zone-redirect-sampledata.csv';
                ?>
                <strong><label for="">Download the sample data. <a href="<?=$csvpath?>" download="zone-redirect-sampledata.csv">here</a></label></strong>
                <button id="btn-import" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-import btn-zn-primary pull-r">Import</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <h2>Export Data</h2>
            <p>The file that will be exported is a .csv.</p>
            <div class="form">
                <button id="btn-extract" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-save-settings">Export</button>
            </div>
        </div>
    </div>
</div>