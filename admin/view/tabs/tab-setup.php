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
            <input type="file" name="external-links" accept=".xls,.xlsx, .csv"/>
            <button id="btn-extract" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-save-settings pull-r">Extract</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <h2>Export Data</h2>
            <button id="btn-extract" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-save-settings pull-r">Download</button>
        </div>
    </div>
</div>