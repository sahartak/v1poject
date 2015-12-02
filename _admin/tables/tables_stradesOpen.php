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
global $tradesStatuses;

$db=new DBConnection();
$searchColumns=array('trade_ref','user_account_num','user_account_name','trade_details','trade_price_share','trade_invoiced','trade_date','trade_status');
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
    $searchFor.=' AND (';
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addOr='';
        if($Count!=0) $addOr.=' OR ';
        $searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
    }
    $searchFor.=')';
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM stock_trades LEFT JOIN users ON stock_trades.user_account_num=users.user_account_num 
WHERE trade_type=1 AND trade_status=1'.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(trades_id) AS total_rows FROM stock_trades LEFT JOIN users ON stock_trades.user_account_num=users.user_account_num 
WHERE trade_type=1 AND trade_status=1';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_rows'];

$sOutput='{';
$sOutput.='"sEcho": '.$_GET['sEcho'].', ';
$sOutput.='"iTotalRecords": '.$iTotal.', ';
$sOutput.='"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput.='"aaData": [ ';
while (($aRow=$db->fetch($rResult))!=FALSE) {
    $sOutput.="[";
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addComma='';
        if($Count!=0) $addComma.=',';
        if($columnToSearch=='trade_status') $aRow[$columnToSearch]=$tradesStatuses[$aRow[$columnToSearch]];

        $sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
    }

    // ADD ICONS
    $sOutput.=',"';
    if($aRow['trade_status']=='Open') {
        $sOutput.=addslashes('<a href="strades.php?action=new_sell&tref='.$aRow['trade_ref'].'"><img src="images/trades_sell.png" title="Add SELL from this BUY" border="0"></a>');
    }else{
        $sOutput.='-';
    }
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