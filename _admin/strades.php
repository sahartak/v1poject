<?php
require_once ('template.php');
if (!$_SESSION['admin']['is_logged']){
	header('Location: index.php');
	exit();
}

$_SESSION['admin']['selected_tab']=2;
unset($_SESSION['admin']['uedit']);

if (isset($_POST['_form_submit']) && array_get($_POST, '_add_sell')==1){
	include_once('stock-trades/c.add.sell.php');
}

if (isset($_POST['_form_submit']) && array_get($_POST, '_add_short')==1){
	include_once('stock-trades/c.add.short.php');
}

if (isset($_POST['_form_submit']) && array_get($_POST, '_add_edit_buy')==1){
	include_once('stock-trades/c.add.edit.buy.php');
}

if (isset($_POST['_form_submit']) && array_get($_POST, '_add_cover')==1){
	include_once('stock-trades/c.add.cover.php');
}

include_once('stock-trades/add.buy.php');
include_once('stock-trades/add.sell.php');
include_once('stock-trades/add.short.php');
include_once('stock-trades/add.cover.php');
include_once('stock-trades/list.trades.php');
include_once('stock-trades/list.open.trades.php');
include_once('stock-trades/list.short.trades.php');

if (isset($_GET['action'])){
	$cmd=($_GET['action']);
}else{
	$cmd='';
}

if (isset($_POST['_back'])){
    $cmd='';
}

$page_content='';
switch ($cmd) {
	case 'new_buy' :
		$page_content=addNewTradeBuy();
		break;
	case 'edit_buy' :
		$exp="/[^a-zA-Z0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: strades.php');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM stock_trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeBuy($_GET['tref']);
			}else{
				header('Location: strades.php');
				exit();
			}
		}
		break;
	case 'delete_buy' :
		if ($_SESSION['admin']['is_logged']==1){
			$exp="/[^a-zA-Z0-9]/i";
			$check=preg_match($exp, $_GET['buyid']);
			if (($check+0)==1||$_GET['buyid']==''){
				header('Location: strades.php');
				exit();
			}
			$db=new DBConnection();
			$query='SELECT * FROM trades_related WHERE trade_ref_relatedto="'.($_GET['buyid']+0).'"';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			
			if($num_rows>0) {
				header('Location: strades.php');
				exit();
			}
			
			$query='SELECT * FROM stock_trades WHERE trade_ref="'.($_GET['buyid']+0).'"';
			$res=$db->rq($query);
			$row=$db->fetch($res);
			
			if ($row['trade_type']==1&&($row['trade_status']==1||$row['trade_status']==4)){
				$query='UPDATE users SET user_balance=(user_balance+'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$row['user_account_num'].'"';
				$db->rq($query);
			}
			
			$query='DELETE FROM stock_trades WHERE trade_ref="'.$_GET['buyid'].'"';
			$db->rq($query);
			
			$uDetails=$db->getRow('users','user_account_num="'.$row['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			global $tradesStatuses;
			addLog('Back-end','Stock Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Buy deleted '.($row['trade_ref']+0).' ('.$tradesStatuses[$row['trade_status']].')');
			
			$db->close();
			header('Location: strades.php');
			exit();
		}
		break;
	case 'list_open' :
		$page_content=listOpenTrades();
		break;
	case 'list_short' :
		$page_content=listShortTrades();
		break;
	case 'new_sell' :
		$exp="/[^0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: strades.php?action=list_open');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM stock_trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeSell($_GET['tref']);
			}else{
				header('Location: strades.php');
				exit();
			}
		}
		break;
	case 'new_short' :
		$page_content=addNewTradeShort();
		break;
	case 'new_cover' : 
		$exp="/[^0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: strades.php?action=list_short');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM stock_trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeCover($_GET['tref']);
			}else{
				header('Location: strades.php');
				exit();
			}
		}
		break;
	case 'edit_sell' :
		$exp="/[^a-zA-Z0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: strades.php');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM stock_trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeSell($_GET['tref']);
			}else{
				header('Location: strades.php');
				exit();
			}
		}
		break;
	case 'delete_sell' :
		if ($_SESSION['admin']['is_logged']==1){
			$exp="/[^a-zA-Z0-9]/i";
			$check=preg_match($exp, $_GET['sellid']);
			if (($check+0)==1||$_GET['sellid']==''){
				header('Location: strades.php');
				exit();
			}
			$db=new DBConnection();
			
			$query='SELECT * FROM stock_trades WHERE trade_ref="'.($_GET['sellid']+0).'"';
			$res=$db->rq($query);
			$row=$db->fetch($res);
			
			$query2='SELECT * FROM trades_related WHERE trade_ref="'.($_GET['sellid']+0).'"';
			$res2=$db->rq($query2);
			$row2=$db->fetch($res2);
			
			$query3='UPDATE stock_trades SET trade_shares_left=(trade_shares_left+'.($row['trade_shares']+0).') 
			WHERE trade_ref="'.$row2['trade_ref_relatedto'].'"';
			$db->rq($query3);

			$checkPositions=$db->getRow('stock_trades','trade_ref="'.$row2['trade_ref_relatedto'].'"','trade_shares_left');
			if($checkPositions['trade_shares_left']>0) {
				$query4='UPDATE stock_trades SET trade_status=1 WHERE trade_ref="'.$row2['trade_ref_relatedto'].'"';
				$db->rq($query4);
			}
			
			if ($row['trade_type']==2&&$row['trade_status']==1){
				$query='UPDATE users SET user_balance=(user_balance-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$row['user_account_num'].'"';
				$db->rq($query);
			}
			
			$query='DELETE FROM trades_related WHERE trade_ref="'.$_GET['sellid'].'"';
			$db->rq($query);
			
			$query='DELETE FROM stock_trades WHERE trade_ref="'.$_GET['sellid'].'"';
			$db->rq($query);
			
			$uDetails=$db->getRow('users','user_account_num="'.$row['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			global $tradesSellStatuses;
			addLog('Back-end','Stock Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Sell deleted '.($row['trade_ref']+0).' ('.$tradesSellStatuses[$row['trade_status']].')');
			
			$db->close();
			header('Location: strades.php');
			exit();
		}
		break;
    case 'pdf':
        $db         = new DBConnection();
        $tradeModel = new App\Model\StockTrades($db);
        
        $trade      = $tradeModel->getTradeByRef($_GET['ref']);
        $tradeTypes = $tradeModel->getTypes();
        
        $trade['trade_type'] = $tradeTypes[$trade['trade_type']];
        $trade = $tradeModel->formatPriceValues($trade);
        
        $mpdf = new mPDF(null, 'A4', null, null, 8, 8, 40, 20, 8, 8);
        $pdf  = new App\Utility\Pdf($db);
        
        $mpdf->SetHTMLHeader($pdf->getHeader());
        $mpdf->SetHTMLFooter($pdf->getFooter());
        
        $mpdf->WriteHTML($pdf->getBody('stock_trade', $trade));
        
        $mpdf->Output($trade['user_account_num'] . '_' . $trade['trade_ref'] . '.pdf', 'D');
        exit();
        break;
	default :
		$page_content=listTrades();
		break;
}

page_header();
echo $page_content;
page_footer();