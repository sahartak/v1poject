<?php
require '../../vendor/autoload.php';

require_once('../includes/ulogin/config/all.inc.php');
require_once('../includes/ulogin/main.inc.php');
require_once('../includes/auth.php');

if ($_SESSION['admin']['is_logged']!=1) {
    echo 'ERROR';
    exit();
}
require_once ('../../classes/db.class.php');
require_once ('../globalvars.php');

$db=new DBConnection();
$searchColumns=array('tr_ref','transfers.user_account_num','user_firstname','user_lastname','tr_type','tr_date', 'tr_total', 'tr_status');
$searchLimit='';
if (isset($_GET['iDisplayStart'])&&$_GET['iDisplayLength']!='-1') {
    $searchLimit='LIMIT '.$db->string_escape($_GET['iDisplayStart']).', '.$db->string_escape($_GET['iDisplayLength']).'';
}

/* Ordering */
if (isset($_GET['iSortCol_0'])) {
    $searchOrder="ORDER BY  ";
    for($i=0; $i<$db->string_escape($_GET['iSortingCols']); $i++ ) {
        $addComma='';
        if($i!=0) $addComma.=', ';
        $searchOrder.=$addComma.fnColumnToField($db->string_escape($_GET['iSortCol_'.$i])).' '.$db->string_escape($_GET['iSortDir_'.$i]).'';
    }
}

$searchFor='';
if ($_GET['sSearch']!='') {
    $searchFor.='AND (';
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addOr='';
	if($Count==0) $searchFor.=$addOr.'gs.variable_value LIKE "%'.$db->string_escape($_GET['sSearch']).'%" OR ';
	if($Count==0) $searchFor.=$addOr.'gs2.variable_value LIKE "%'.$db->string_escape($_GET['sSearch']).'%" OR ';
	if($Count!=0) $addOr.=' OR ';
        $searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
    }
    $searchFor.=')';
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM transfers LEFT JOIN users ON transfers.user_account_num=users.user_account_num
LEFT JOIN global_settings gs ON transfers.tr_status=gs.variable
LEFT JOIN global_settings gs2 ON transfers.tr_type=gs2.variable WHERE gs.section="transfers" AND gs2.section="transfers_types" '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);
$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(transfers_id) AS total_rows FROM transfers
LEFT JOIN users ON transfers.user_account_num=users.user_account_num
LEFT JOIN global_settings gs ON transfers.tr_status=gs.variable
LEFT JOIN global_settings gs2 ON transfers.tr_type=gs2.variable WHERE gs.section="transfers" AND gs2.section="transfers_types"';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_rows'];

$sOutput='{';
$sOutput.='"sEcho": '.$_GET['sEcho'].', ';
$sOutput.='"iTotalRecords": '.$iTotal.', ';
$sOutput.='"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput.='"aaData": [ ';
global $depositOptions;
$types=array(1=>'Deposit',2=>'Withdraw');
while (($aRow=$db->fetch($rResult))!=FALSE) {
	$maillink='';
    $sOutput.="[";
    foreach ($searchColumns AS $Count=>$columnToSearch) {
	if($columnToSearch=='transfers.user_account_num') $columnToSearch='user_account_num';
        $addComma='';
        if($Count!=0) $addComma.=',';

        if($columnToSearch=='tr_type') {
        	$maillink='&twref='.($aRow['tr_ref']).'';
        	if($aRow[$columnToSearch]==1) $maillink='&tdref='.($aRow['tr_ref']).'';
            $aRow[$columnToSearch]=$types[$aRow[$columnToSearch]];
        }

        if($columnToSearch=='tr_status') {
            $aRow[$columnToSearch]=$depositOptions[$aRow[$columnToSearch]];
        }
        
        if($columnToSearch=='tr_total') $aRow[$columnToSearch]=number_format($aRow['tr_total'],2);

        $sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
    }

    // ADD ICONS
    $sOutput.=',"';
    $sOutput.=addslashes('<a href="/dosuuser.php?uid='.($aRow['user_account_num']).'" id="NewWindow"><i class="fa fa-tachometer fa-lg" title="Login to this user"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="mails_singleuser.php?uid='.($aRow['user_account_num']).''.$maillink.'"><i class="fa fa-envelope fa-lg" title="Send mail to user"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="users.php?action=edit&uid='.($aRow['user_account_num']).'"><i class="fa fa-user fa-lg" title="Edit user details"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="transfers.php?action=pdf&ref='.($aRow['tr_ref']).'"><i class="fa fa-file-text fa-lg" title="Transfer Statement PDF"></i></a>');
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