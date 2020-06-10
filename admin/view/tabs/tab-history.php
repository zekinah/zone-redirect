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
<div class="card">
    <h3 class="zone-title-short">History Logs visits</h3>
    <table id="tbl-history" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Visited From</th>
                <th>Visited To</th>
                <th>Type of Visit</th>
                <th>Date and Time Visited</th>
            </tr>
        </thead>
        <tbody id="body_links">
            <?php
            while($row = $tbl_visits->fetch_assoc()):
            ?>
            <tr id="link-<?= $row['RedirectVisit_ID'] ?>">
                <td><?= $row['RedirectVisit_ID'] ?></td>
                <td><?= $row['Visited_From'] ?></td>
                <td><?= $row['Visited_To'] ?></td>
                <td><?= $row['Visited_Type'] ?></td>
                <td><?= $row['Last_visited_Date'] ?></td>
            </tr>
            <?php
            endwhile;
            ?>
        </tbody>
    </table>
</div>