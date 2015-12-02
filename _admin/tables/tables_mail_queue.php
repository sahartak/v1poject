<?php
require '../../vendor/autoload.php';

require_once('../includes/ulogin/config/all.inc.php');
require_once('../includes/ulogin/main.inc.php');
require_once('../includes/auth.php');

if ($_SESSION['admin']['is_logged']!=1){
	echo 'ERROR';
	exit();
}
require_once ('../../classes/db.class.php');

$db=new DBConnection();

$searchColumns=array('mail_queue_id', 'mail_subject', 'create_time', 'admins_id', 'mail_to', 'try_sent');
$searchLimit='';
if (isset($_GET['iDisplayStart'])&&$_GET['iDisplayLength']!='-1'){
	$searchLimit='LIMIT '.$db->string_escape($_GET['iDisplayStart']).', '.$db->string_escape($_GET['iDisplayLength']).'';
}

/* Ordering */
if (isset($_GET['iSortCol_0'])){
	$searchOrder="ORDER BY  ";
	for($i=0; $i<$db->string_escape($_GET['iSortingCols']); $i++ ){
		$addComma='';
		if ($i!=0) $addComma.=', ';
		$searchOrder.=$addComma.fnColumnToField($db->string_escape($_GET['iSortCol_'.$i])).' '.$db->string_escape($_GET['iSortDir_'.$i]).'';
	}
}

$searchFor='';
if ($_GET['sSearch']!=''){
	
	$searchFor.='AND (';
	foreach ($searchColumns as $Count=>$columnToSearch){
		$addOr='';
		if ($Count!=0) $addOr.=' OR ';
		$searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
	}
	$searchFor.=')';
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM mail_queue WHERE is_sent=0 '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(mail_queue_id) AS total_groups FROM mail_queue WHERE is_sent=0';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_groups'];

$sOutput='{';
$sOutput.='"sEcho": '.$_GET['sEcho'].', ';
$sOutput.='"iTotalRecords": '.$iTotal.', ';
$sOutput.='"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput.='"aaData": [ ';
while (($aRow=$db->fetch($rResult))!=FALSE){
	$sOutput.="[";
	foreach ($searchColumns as $Count=>$columnToSearch){
		$addComma='';
		if ($Count!=0) $addComma.=',';
		$sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
	}
	
	 // ADD ICONS
    $sOutput.=',"';
    $sOutput.=addslashes('<a href="mails_outbox.php?action=delete&mailid='.($aRow['mail_queue_id']+0).'"><img src="images/delete.png" title="Delete this mail" border="0"></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="mails_sendmail.php?action=single&mailid='.($aRow['mail_queue_id']+0).'" id="NewWindow"><img src="images/mail_resend.png" title="Force send" border="0"></a>');
    $sOutput.='"';
    $sOutput.="],";
}
$sOutput=substr_replace($sOutput, "", -1);
$sOutput.='] }';

echo $sOutput;

function fnColumnToField($i) {

	global $searchColumns;
	return $searchColumns[$i];
}
?>