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
<div class="card">
    <h2>Add new Links</h2>
    <div class="row">
        <div class="col">
            <label>From URL <span>*</span></label>
            <input id="zn_txt-from" class="form-control" type="text" placeholder="https://xxxxxx" required>
        </div>
        <div class="col">
            <label>To New URL <span>*</span></label>
            <input id="zn_txt-to" class="form-control" type="text" placeholder="https://xxxxxx" required>
        </div>
        <div class="col">
            <label>URL Type Redirection</label>
            <select id="zn_txt-type" class="form-control" disabled>
                <option  disabled>-- Choose Option --</option>
                <option selected value="301">301</option>
            </select>
        </div>
        <div class="col">
            <label></label>
            <button id="btn-addLink" data-zn_nonce="<?=$zn_form_nonce?>" type="button" class="btn btn-save-settings">Add New Links</button>
        </div>
    </div>
</div>
<div class="card">
    <h2>List of Links</h2>
    <table id="tbl-redirect" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="body_request">
            <?php
            while($row = $tbl_links->fetch_assoc()):
            ?>
            <tr>
                <td><?= $row['Redirect_ID'] ?></td>
                <td><?= $row['From'] ?></td>
                <td><?= $row['To'] ?></td>
                <td><?= $row['Type'] ?></td>
                <td><?= date('M d, Y', strtotime($row['Date'])) ?></td>
                <td><input class="form-check-input zn_link_stat" id="zn_link_stat" type="checkbox" name="zn_link_stat" data-redirectid_stat="<?= $row['Redirect_ID'] ?>" <?php echo ($row['Status'] == '1' ? 'checked' : ''); ?> data-toggle="toggle"></td>
                <td>
                    <a href="#" class="btn btn-info btn-xs btn-link-update" data-link_edit="<?= $row['Redirect_ID'] ?> title="Update"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            <?php
            endwhile;
            ?>
        </tbody>
    </table>
</div>