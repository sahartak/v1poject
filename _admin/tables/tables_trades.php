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
global $tradesBuyOptions;
global $tradesSellStatuses;

$db=new DBConnection();
$searchColumns=array('trade_ref','user_account_num','user_account_name','trade_details','trade_option','trade_expiry_date','trade_premium_price','trade_strikeprice','trade_invoiced','trade_date','trade_status');
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
    $searchFor.='WHERE ';
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addOr='';
        if($Count!=0) $addOr.=' OR ';
        if($columnToSearch=='user_account_num') {
	    $searchFor.=$addOr.'users.'.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
	}else{
	    $searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
	}
    }
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM trades LEFT JOIN users ON trades.user_account_num=users.user_account_num '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(trades_id) AS total_rows FROM trades LEFT JOIN users ON trades.user_account_num=users.user_account_num';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_rows'];

$sOutput='{';
$sOutput.='"sEcho": '.$_GET['sEcho'].', ';
$sOutput.='"iTotalRecords": '.$iTotal.', ';
$sOutput.='"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput.='"aaData": [ ';
while (($aRow=$db->fetch($rResult))!=FALSE) {
	$maillink='';
    $sOutput.="[";
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addComma='';
        if($Count!=0) $addComma.=',';
        if($columnToSearch=='trade_option') $aRow[$columnToSearch]=$tradesBuyOptions[$aRow[$columnToSearch]];
        if($columnToSearch=='trade_status') {
        	if($aRow['trade_type']==1) {
        		$maillink='&buyref='.($aRow['trade_ref']).'';
        		$aRow[$columnToSearch]=$tradesStatuses[$aRow[$columnToSearch]];
        	}else{
        		$maillink='&sellref='.($aRow['trade_ref']).'';
        		$aRow[$columnToSearch]=$tradesSellStatuses[$aRow[$columnToSearch]];
        	}
        }

        if($columnToSearch=='trade_strikeprice') $aRow[$columnToSearch]=number_format($aRow['trade_strikeprice'],2);
        if($columnToSearch=='trade_invoiced') $aRow[$columnToSearch]=number_format($aRow['trade_invoiced'],2);
        
        $sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
    }

    // ADD ICONS
    $sOutput.=',"';
    if($aRow['trade_status']=='Open') {
    	$sOutput.=addslashes('<a href="trades.php?action=new_sell&tref='.$aRow['trade_ref'].'"><i class="fa fa-exchange fa-lg" title="SELL out this BUY"></i></a>');
    }
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="/dosuuser.php?uid='.($aRow['user_account_num']).'" id="NewWindow"><i class="fa fa-tachometer fa-lg" title="Login to this user"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="mails_singleuser.php?uid='.($aRow['user_account_num']).''.$maillink.'"><i class="fa fa-envelope fa-lg" title="Send mail to user"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="users.php?action=edit&uid='.($aRow['user_account_num']).'"><i class="fa fa-user fa-lg" title="Edit user details"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="trades.php?action=pdf&ref='.($aRow['trade_ref']).'"><i class="fa fa-file-text fa-lg" title="Trade Comfirmation PDF"></i></a>');
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