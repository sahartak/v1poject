<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}
$_SESSION['admin']['selected_tab']=9;
unset($_SESSION['admin']['uedit']);

function listOutgoingMails() {
    $pcontent='';
    $pcontent.='
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
<script type="text/javascript" src="tables/tables_mail_queue.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("#MassResend").click(function() {
		var src = "mails_sendmail.php?action=sendall";

		$.modal(\'<iframe src="\' + src + \'" height="150" width="400" style="border:0">\', {
			containerCss:{
			backgroundColor:"#fff", 
			borderColor:"#999999", 
			height:150,
			width:400,
			padding:0 
		},
		overlayClose:true
		});
		return false;
	});
});
</script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Outgoing Mails</b></div>
    <div class="simpleHolder">Actions: 
    	<a href="mails_sendmail.php?action=sendall" id="MassResend">Force resend for all</a> | 
    	<a href="#" onclick="if(confirm(\'Are you sure you want to delete all mails from the quaue?\')) location=\''.THISPAGE.'?action=massdel\';">Delete all</a>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
        <thead>
            <tr>
                <th><b>#</b></th>
                <th><b>Mail Subject</b></th>
                <th><b>Created</b></th>
                <th><b>Created by</b></th>
                <th><b>Recipient</b></th>
                <th><b>Failed attepmts</b></th>
                <th><b>Actions</b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
    </table>
</div>';

    return $pcontent;
}

if (isset($_GET['action'])) {
    $cmd=($_GET['action']);
}else {
    $cmd='';
}

if (isset($_POST['_back']))	$cmd='';
$page_content='';
switch	($cmd) {
    case 'delete'	:
        if($_SESSION['admin']['is_logged']==1) {
            $db=new DBConnection();
            $query='DELETE FROM mail_queue WHERE mail_queue_id='.($_GET['mailid']+0);
            $db->rq($query);

            $db->close();
            header('Location: mails_outbox.php');
            exit();
        }
        break;
        
    case 'massdel'	:
        if($_SESSION['admin']['is_logged']==1) {
            $db=new DBConnection();
            $query='DELETE FROM mail_queue WHERE is_sent=0';
            $db->rq($query);

            $db->close();
            header('Location: mails_outbox.php');
            exit();
        }
    break;
    default	:
        $page_content=listOutgoingMails();
        break;
}

page_header();
echo $page_content;
page_footer();
?>