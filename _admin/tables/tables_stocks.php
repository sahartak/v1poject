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
$searchColumns=array('stocks_id','stocks_symbol','stocks_name');
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

$searchQuery='SELECT SQL_CALC_FOUND_ROWS * FROM stocks '.$searchFor.' '.$searchOrder.' '.$searchLimit.'';
$rResult=$db->rq($searchQuery);

$query='SELECT FOUND_ROWS() AS frows';
$res=$db->rq($query);
$row=$db->fetch($res);
$iFilteredTotal=$row['frows'];

$query='SELECT COUNT(stocks_id) AS total_stocks FROM stocks';
$res=$db->rq($query);
$row=$db->fetch($res);
$iTotal=$row['total_stocks'];

$sOutput='{';
$sOutput.='"sEcho": '.$_GET['sEcho'].', ';
$sOutput.='"iTotalRecords": '.$iTotal.', ';
$sOutput.='"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput.='"aaData": [ ';
while (($aRow=$db->fetch($rResult))!=FALSE){
    $sOutput.="[";
    foreach ($searchColumns AS $Count=>$columnToSearch) {
        $addComma='';
        if($Count!=1) $addComma.=',';
        if($columnToSearch!='stocks_id') $sOutput.=$addComma.'"'.addslashes($aRow[$columnToSearch]).'"';
    }
    $subq = $db->rq("SELECT value FROM stock_details WHERE stocks_id='".$aRow['stocks_id']."' ORDER BY date DESC LIMIT 1,1");
    $subRow=$db->fetch($subq);
    $sOutput.=',"';
    $prev_price = $subRow['value'];
    $sOutput.=$prev_price ? number_format($prev_price, 2) : 'N/A';
    $sOutput.='"';
    
    $subq = $db->rq("SELECT value, date FROM stock_details WHERE stocks_id='".$aRow['stocks_id']."' ORDER BY date DESC LIMIT 1");
    $subRow=$db->fetch($subq);
    $sOutput.=',"';
    $present_price = $subRow['value'];
    $sOutput.=$present_price ? number_format($present_price, 2) : 'N/A';
    $sOutput.='"';
    
    //% CHANGE
    $sOutput.=',"';
    if($prev_price && $prev_price != 0) { 
        $change = number_format((($present_price-$prev_price)/$prev_price)*100, 2); 
        if($change > 0) { $change = '+'.$change; }
    }
    $sOutput.=$prev_price && $prev_price ? $change : 'N/A';
    $sOutput.='"';
    
    //Updates
    $sOutput.=',"';
    $sOutput.=$aRow['checking'] && $aRow['checking'] != '' ? ucfirst($aRow['checking']) : 'None';
    $sOutput.='"';
    
    //Last Run
    $sOutput.=',"';
    $sOutput.=$subRow['date'] ? $subRow['date'] : 'N/A';
    $sOutput.='"';
    
    // ADD ICONS
    $sOutput.=',"';
    $sOutput.=addslashes('<a href="stocks.php?action=new_stock&sid='.($aRow['stocks_id']).'"><i class="fa fa-edit fa-lg" title="Edit stock info"></i></a>');
    $sOutput.=' ';
    $sOutput.=addslashes('<a href="'.($aRow['stocks_links']).'" target="_blank"><i class="fa fa-link fa-lg" title="External link"></i></a>');
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