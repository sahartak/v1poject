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

$searchColumns=array('logs_id', 'log_area', 'log_section', 'log_user', 'log_admin', 'log_details', 'log_date', 'log_ip');
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

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM logs WHERE 1 '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(logs_id) AS total_logs FROM logs WHERE 1';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_logs'];

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