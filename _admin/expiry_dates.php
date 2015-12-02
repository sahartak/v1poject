<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab']=5;
unset($_SESSION['admin']['uedit']);
if(isset($_POST['_form_submit'])) {
    $db=new DBConnection();
    foreach ($_POST AS $k=>$x) $_POST[$k]=$db->string_escape($x);
    if(($_POST['edid']+0)>0) {
    	$expiry_short=convertTradeDates(strtotime($_POST['expiry_date']));
    	$query='UPDATE expiry_dates SET expiry_date="'.$_POST['expiry_date'].'", expiry_short="'.$expiry_short.'" WHERE expiry_dates_id='.($_POST['edid']+0).'';
		$db->rq($query);
		
		addLog('Back-end','Back-end Settings, Commodities - exp. dates',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity expiry date edited ('.$_POST['expiry_date'].')');
    }else{
    	$expiry_short=convertTradeDates(strtotime($_POST['expiry_date']));
    	$query='INSERT INTO expiry_dates SET expiry_date="'.$_POST['expiry_date'].'", expiry_short="'.$expiry_short.'"';
		$db->rq($query);
		
		addLog('Back-end','Back-end Settings, Commodities - exp. dates',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity expiry date added ('.$_POST['expiry_date'].')');
    }

    $db->close();
    header('Location: expiry_dates.php');
    exit();
}

function addNewExpDate($expiry_dates_id=0){
    if($expiry_dates_id&&!$_POST['_form_submit']) {
	$_SESSION['admin']['uedit']=$expiry_dates_id;
	$db=new DBConnection();
	$query='SELECT * FROM expiry_dates WHERE expiry_dates_id='.($expiry_dates_id+0).'';
	$res=$db->rq($query);
	foreach ($db->fetch($res) AS $RowName=>$RowValue) {
	    $_POST[$RowName]=$RowValue;
	}
	$db->close();
    }

    $pcontent='';
    $pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($expiry_dates_id>0)?'Editing':'Creating New').' Expiry Date</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/expiry_dates.js"></script>
<form name="addNewExpDate" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder">
	<legend>Date information</legend>
	<div class="formsLeft">Expiry date:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="expiry_date" id="expiry_date" value="'.$_POST['expiry_date'].'" autocomplete="off" />
	</div>
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
    if($expiry_dates_id) {
	$pcontent.='
	<input type="hidden" name="edid" value="'.$expiry_dates_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this expiry date?\')) location=\'?action=delete&edid='.($_POST['expiry_dates_id']+0).'\';" />';
    }
    $pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'expiry_dates.php\';" />
	</fieldset>
</form>
</div>';
    return $pcontent;
}

function listExpDates(){
    $pcontent='';
    $pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_expiry_dates.js"></script>
<div class="mainHolderSmaller">
    <div class="hintHolder ui-state-default"><b>List All Expiry Dates</b></div>
    <div class="simpleHolder">Actions: <a href="'.THISPAGE.'?action=new">add new</a></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
        <thead>
	    <tr>
	        <th><b>#</b></th>
	        <th><b>Date</b></th>
		<th><b>Short</b></th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
	        <td colspan="3" class="dataTables_empty">Loading data from server</td>
	    </tr>
	</tbody>
    </table>
</div>';

    return $pcontent;
}

if (isset($_GET['action']))	{
    $cmd=($_GET['action']);
}else{
    $cmd='';
}

if (isset($_POST['_back']))	$cmd='';
$page_content='';
switch	($cmd)	{
    case 'new':
	$page_content=addNewExpDate();
	break;
    case 'edit':
	$page_content=addNewExpDate($_GET['edid']+0);
	break;
    case 'delete'	:
	if($_SESSION['admin']['is_logged']==1) {
	    $db=new DBConnection();
	    $currentInfo=$db->getRow('expiry_dates','expiry_dates_id='.($_GET['edid']+0).'');
	    $query='DELETE FROM expiry_dates WHERE expiry_dates_id='.($_GET['edid']+0);
	    $db->rq($query);

	    addLog('Back-end','Back-end Settings, Commodities - exp. dates',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity expiry date deleted ('.$currentInfo['expiry_date'].')');
	    
	    $db->close();
	    header('Location: expiry_dates.php');
	    exit();
	}
	break;
    default	:
	$page_content=listExpDates();
	break;
}

page_header();
echo $page_content;
page_footer();
?>