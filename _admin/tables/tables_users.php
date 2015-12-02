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
require_once('../globalvars.php');

$db=new DBConnection();
$searchColumns=array('user_account_num','user_account_name','user_firstname','user_lastname','user_app_date','user_trades',
    'user_loginscount','user_status','user_lastupdate','user_lscp','user_hpsp','user_balance');
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
	if(fnColumnToField($db->string_escape($_GET['iSortCol_'.$i]))=='user_account_num') {
	    $searchOrder.=$addComma.'users.'.fnColumnToField($db->string_escape($_GET['iSortCol_'.$i])).' '.$db->string_escape($_GET['iSortDir_'.$i]).'';
	}else{
	    $searchOrder.=$addComma.fnColumnToField($db->string_escape($_GET['iSortCol_'.$i])).' '.$db->string_escape($_GET['iSortDir_'.$i]).'';
	}
    }
}

global $userStatuses;
$searchFor='';
if ($_GET['sSearch']!='') {
    $searchFor.='WHERE ';
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addOr='';
        if($Count!=0) $addOr.=' OR ';
        $searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
    }
}

if($_GET['subSearch']=='active') {
    if($searchFor) {
	$searchFor.=' AND user_status=1';
    }else{
	$searchFor.=' WHERE user_status=1';
    }
}

if($_GET['subSearch']=='pending') {
    if($searchFor) {
	$searchFor.=' AND user_status=2';
    }else{
	$searchFor.=' WHERE user_status=2';
    }
}

if($_GET['subSearch']=='disabled') {
    if($searchFor) {
	$searchFor.=' AND user_status=3';
    }else{
	$searchFor.=' WHERE user_status=3';
    }
}

$LeftJoins='';
$GroupInfo='';
$HavingInfo='';
$CustomSelect='';
if($_GET['subSearch']=='trades2') {
    $CustomSelect.='COUNT(trades_id) AS total_num, ';
    $LeftJoins.=' LEFT JOIN trades ON users.user_account_num=trades.user_account_num';
    $GroupInfo.=' GROUP BY users.user_account_num';
    $HavingInfo.=' HAVING total_num>=2';
}

if($_GET['subSearch']=='trades1') {
    $CustomSelect.='COUNT(trades_id) AS total_num, ';
    $LeftJoins.=' LEFT JOIN trades ON users.user_account_num=trades.user_account_num';
    $GroupInfo.=' GROUP BY users.user_account_num';
    $HavingInfo.=' HAVING total_num=1';
}

if($_GET['subSearch']=='trades0') {
    $CustomSelect.='COUNT(trades_id) AS total_num, ';
    $LeftJoins.=' LEFT JOIN trades ON users.user_account_num=trades.user_account_num';
    $GroupInfo.=' GROUP BY users.user_account_num';
    $HavingInfo.=' HAVING total_num=0';
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS '.$CustomSelect.'users.* FROM users'.$LeftJoins.' '.$searchFor.''.$GroupInfo.''.$HavingInfo.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);
$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(users_id) AS total_users FROM users';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_users'];

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

        if($columnToSearch=='user_lastupdate') {
            if($aRow[$columnToSearch]!="0000-00-00 00:00:00") {
            }else {
                $aRow[$columnToSearch]='-';
            }
        }

        if($columnToSearch=='user_status') {
            $aRow[$columnToSearch]=$userStatuses[$aRow[$columnToSearch]];
        }

        $sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
    }

    // ADD ICONS
    $sOutput.=',"';
    $sOutput.=addslashes('<a href="/dosuuser.php?uid='.($aRow['user_account_num']).'" id="NewWindow"><i class="fa fa-tachometer fa-lg" title="Login to this user"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="mails_singleuser.php?uid='.($aRow['user_account_num']).'"><i class="fa fa-envelope fa-lg" title="Send mail to user"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="users.php?action=edit&uid='.($aRow['user_account_num']).'"><i class="fa fa-user fa-lg" title="Edit user details"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="trades.php?action=new_buy&uid='.($aRow['user_account_num']).'"><i class="fa fa-pencil-square-o fa-lg" title="Add options trade"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="transfers.php?action=new_deposit&uid='.($aRow['user_account_num']).'"><i class="fa fa-plus fa-lg" title="Add new $$ deposit"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="transfers.php?action=new_withdraw&uid='.($aRow['user_account_num']).'"><i class="fa fa-minus fa-lg" title="Add new $$ withdraw"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="users.php?action=pdf&uid='.($aRow['user_account_num']).'"><i class="fa fa-file-text fa-lg" title="Current Account PDF Statment"></i></a>');
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