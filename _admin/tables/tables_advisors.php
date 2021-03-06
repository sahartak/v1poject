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
$searchColumns=array('advisor_names','advisor_ref','advisor_firm','advisor_contacts');
$searchLimit='';
if (isset($_GET['iDisplayStart'])&&$_GET['iDisplayLength']!='-1'){
    $searchLimit='LIMIT '.$db->string_escape($_GET['iDisplayStart']).', '.$db->string_escape($_GET['iDisplayLength']).'';
}

/* Ordering */
if (isset($_GET['iSortCol_0'])){
    $searchOrder="ORDER BY  ";
    for($i=0; $i<$db->string_escape($_GET['iSortingCols']); $i++ ){
	$addComma='';
	if($i!=0) $addComma.=', ';
	$searchOrder.=$addComma.fnColumnToField($db->string_escape($_GET['iSortCol_'.$i])).' '.$db->string_escape($_GET['iSortDir_'.$i]).'';
    }
}

$searchFor='';
if ($_GET['sSearch']!=''){
    $searchFor.='WHERE ';
    foreach ($searchColumns AS $Count=>$columnToSearch) {
	$addOr='';
	if($Count!=0) $addOr.=' OR ';
	$searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
    }
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM users_advisors '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(users_advisors_id) AS total_users FROM users_advisors';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_users'];

$sOutput='{';
$sOutput.='"sEcho": '.$_GET['sEcho'].', ';
$sOutput.='"iTotalRecords": '.$iTotal.', ';
$sOutput.='"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput.='"aaData": [ ';
while (($aRow=$db->fetch($rResult))!=FALSE){
    $sOutput.="[";
    foreach ($searchColumns AS $Count=>$columnToSearch) {
	$addComma='';
	if($Count!=0) $addComma.=',';
	$sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
    }

    // ADD ICONS
    $sOutput.=',"';
    $sOutput.=addslashes('<a href="users_advisors.php?action=edit&advid='.($aRow['users_advisors_id']+0).'"><i class="fa fa-user fa-lg" title="Edit user details"></i></a>');
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