<style type="text/css">
    @import "css/table_jui.css";
    @import "tables/media/css/TableTools.css";
</style>

<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_admins.js"></script>

<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Administrators</b></div>
    
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="adminsTable">
        <thead>
            <tr>
                <th><b>Username</b></th>
                <th><b>REF</b></th>
                <th><b>Names</b></th>
                <th><b>E-mail</b></th>
                <th><b>Last login</b></th>
                <th><b>Type</b></th>
                <th><b>Status</b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
    </table>
</div>