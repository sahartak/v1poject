<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}
$_SESSION['admin']['selected_tab']=10;
unset($_SESSION['admin']['uedit']);

page_header();

echo '
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_logs.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Admins Logs</b></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
        <thead>
            <tr>
                <th><b>#</b></th>
                <th><b>Area</b></th>
                <th><b>Section</b></th>
                <th><b>User</b></th>
                <th><b>Admin</b></th>
                <th><b>Details</b></th>
                <th><b>Date</b></th>
                <th><b>IP</b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
    </table>
</div>';

page_footer();
?>