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
<h3 class="zone-title-short">Setup</h3>
<div class="row">
    <div class="col-md-6">
        <div class="card">
        <h3 class="zone-title-sub">Import Data</h3>
            <div class="form">
                <div class="form-group">
                    <label><strong>Select Input File:</strong></label>
                    <?php
                    $selected_file = sanitize_text_field($_POST['selected_file']);
                    $selectedFile = isset($selected_file) ? $selected_file : null; ?>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="selected_file" id="selected_file" type="text" size="70" value="<?=$selectedFile?>"/>
                        </div>
                        <div class="input-group-append">
                            <button id="btn-upload" type="button" class="button-primary btn-upload btn-zn-primary pull-r">Upload</button>
                        </div>
                    </div>
                    <?php _e( 'File must end with a .csv extension.'); ?>
                </div>
                <div class="form-group">
                    <label><strong>Select Starting Row:</strong></label>
                    <input id="zn_start_row" name="zn_start_row" type="number" min="0" value="1"/>
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
                <button id="btn-import" type="button" class="button-primary btn-import btn-zn-primary pull-r">Import</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <h3 class="zone-title-sub">Export Data</h3>
            <p>The file that will be exported is a .csv.</p>
            <div class="form">
                <button id="btn-extract" type="button" class="button-primary btn-save-settings">Export</button>
            </div>
        </div>
    </div>
</div>