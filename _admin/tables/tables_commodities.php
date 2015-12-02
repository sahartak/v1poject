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

$db=new DBConnection();
$query='SELECT * FROM commodities_groups';
$res=$db->rq($query);
$comGroups=array();
while(($row=$db->fetch($res)) != FALSE) {
    $comGroups[$row['commodities_groups_id']]=$row['commodities_groups_name'];
}

$searchColumns=array('commodities_id','commodities_name','commodities_groups_id','commodities_symbol','commodities_contract_size','commodities_unit','commodities_def_fee','commodities_def_prem','commodities_status');
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
        $searchFor.=$addOr.$columnToSearch.' LIKE "%'.$db->string_escape($_GET['sSearch']).'%"';
    }
}

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM commodities '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(commodities_id) AS total_commodities FROM commodities';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_commodities'];

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
        if($columnToSearch=='commodities_groups_id') {
            $aRow[$columnToSearch]=$comGroups[$aRow[$columnToSearch]];
        }

        if($columnToSearch=='commodities_status') {
            if($aRow[$columnToSearch]==0) {
                $aRow[$columnToSearch]='not active';
            }else {
                $aRow[$columnToSearch]='active';
            }
        }
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