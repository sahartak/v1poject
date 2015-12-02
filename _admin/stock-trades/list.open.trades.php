<?php

function listOpenTrades() {

	$pcontent='';
	$pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_stradesOpen.js"></script>
<div class="mainHolder">
	<div class="hintHolder ui-state-default"><b>List All Open Trades</b></div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tradesTable">
	<thead>
		<tr>
		<th><b>REF #</b></th>
		<th><b>Account</b></th>
		<th><b>Account Name</b></th>
		<th><b>Details</b></th>
		<th><b>Price/Share</b></th>
		<th><b>Price</b></th>
		<th><b>Date</b></th>
		<th><b>Status</b></th>
		<th><b></b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
		<td colspan="8" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	</table>
</div>';

	return $pcontent;
}

?>