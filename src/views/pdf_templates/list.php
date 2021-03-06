<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
/* Overlay */
#simplemodal-overlay {background-color:#000; cursor: pointer;}
/* Container */
#simplemodal-container {height:320px; width:600px; color:#bbb; background-color:#333; border:4px solid #444; padding:12px;}
#simplemodal-container a {color:#ddd;}
#simplemodal-container a.modalCloseImg {background:url(./images/close.png) no-repeat; width:25px; height:29px; display:inline; z-index:3200; position:absolute; top:-15px; right:-16px; cursor:pointer;}
#simplemodal-container #basic-modal-content {padding:8px;}

</style>
<!--[if lt IE 7]>
<style type="text/css">
#simplemodal-container a.modalCloseImg {
	background:none;
	right:-14px;
	width:22px;
	height:26px;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(
		src="../images/close.png", sizingMethod="scale"
	);
}
</style>
<![endif]-->
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_pdf_templates.js"></script>
<div class="mainHolderSmaller">
	<div class="hintHolder ui-state-default"><b>List All PDF Templates</b></div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tradesTable">
	<thead>
		<tr>
            <th><b>ID</b></th>
            <th><b>Template</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
		<td colspan="8" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	</table>
</div>