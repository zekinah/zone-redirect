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
                    <?php $selectedFile = isset( $_POST[ 'selected_file' ] ) ? $_POST[ 'selected_file' ] : null; ?>
                    <input name="selected_file" id="selected_file" type="text" size="70" value="<?=$selectedFile?>"/>
                    <button id="btn-upload" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-upload btn-zn-primary pull-r">Upload</button>
                    <br><?php _e( 'File must end with a .csv extension.'); ?>
                </div>
                <div class="form-group">
                    <label><strong>Select Starting Row:</strong></label>
                    <input id="zn_start_row" name="zn_start_row" type="text" size="10" />
                    <br><?php _e( 'Defaults to row 1 (top row) of .csv file.'); ?>
                </div>
                <button id="btn-import" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-import btn-zn-primary pull-r">Import</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <h2>Export Data</h2>
            <button id="btn-extract" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-save-settings pull-r">Download</button>
        </div>
    </div>
</div>