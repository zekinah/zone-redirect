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
<h3 class="zone-title-short">Information</h3>
<ul>
    <li><strong>301</strong> - <?php _e( 'HTTP response status code 302 Moved Permanently is used for permanent URL redirection, meaning current links or records using the URL that the response is received for should be updated.'); ?></li>
    <li><strong>302</strong> - <?php _e( 'HTTP response status code 302 redirect status response code indicates that the resource requested has been temporarily moved to the URL given by the Location header.'); ?></li>
</ul>
<div class="card">
    <h3 class="zone-title-sub">Add new Links</h3>
    <div class="row">
        <div class="col">
            <label>From URL <span>*</span> (Page link within the site)</label>
            <input id="zn_txt-from" class="form-control" type="text" placeholder="/xxxxxx" required>
        </div>
        <div class="col">
            <label>To New URL <span>*</span></label>
            <input id="zn_txt-to" class="form-control" type="text" placeholder="https://xxxxxx" required>
        </div>
        <div class="col">
            <label>URL Type Redirection</label>
            <select id="zn_txt-type" class="form-control">
                <option  disabled>-- Choose Option --</option>
                <option value="301">301 - Permanent</option>
                <option value="302">302 - Temporarily</option>
            </select>
        </div>
        <div class="col">
            <label></label>
            <button id="btn-addLink"  type="button" class="button-primary btn-save-settings">Add New Links</button>
        </div>
    </div>
</div>
<div class="card">
    <h3 class="zone-title-sub">List of Links</h3>
    <table id="tbl-redirect" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Date Added</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="body_links">
            <?php
            foreach($tbl_links as $linkId => $row) {
                ?>
                <tr id="link-<?= $row->Redirect_ID ?>">
                    <td><?= $row->Redirect_ID ?></td>
                    <td><?= $row->From ?></td>
                    <td><?= $row->To ?></td>
                    <td><?= $row->Type ?></td>
                    <td><?= date('M d, Y', strtotime($row->Date)) ?></td>
                    <td><input class="form-check-input zn_link_stat" id="zn_link_stat" type="checkbox" name="zn_link_stat" data-zn_link_stat_id="<?= $row->Redirect_ID ?>" <?php echo ($row->Status == '1' ? 'checked' : ''); ?> data-toggle="toggle"></td>
                    <td>
                        <a href="#TB_inline?width=600&height=400&inlineId=edit-links" class="thickbox btn btn-info btn-xs btn-link-update"
                        data-link_edit_id="<?= $row->Redirect_ID ?>"
                        data-link_edit_from="<?= $row->From ?>"
                        data-link_edit_to="<?= $row->To ?>"
                        data-link_edit_type="<?= $row->Type ?>"
                        title="Update"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-danger btn-xs btn-link-remove"
                        data-link_rem_id="<?= $row->Redirect_ID ?>"
                        title="Move to trash"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php add_thickbox(); ?>
<div id="edit-links" style="display:none;">
    <h3 class="zone-title-sub">Links Details</h3>
    <div class="container-link-info">
    <span class="spinner is-active"></span>
    </div>
    <button id="btn-updateLink"  type="button" class="button-primary btn-save-settings pull-r">Save</button>
</div>