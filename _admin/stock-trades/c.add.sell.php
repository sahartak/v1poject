<?php

$db=new DBConnection();

$query='SELECT * FROM stock_trades WHERE trade_ref="'.($_POST['trid']+0).'"';
$res=$db->rq($query);
$num_rows=$db->num_rows($res);
global $tradesSellStatuses;

if ($num_rows>0){
	$row=$db->fetch($res);
	if ($row['trade_type']==1){
		//ADD SELL ORDER
		$mysql_fields='';
		$mysql_fields.='user_account_num="'.($_POST['user_account_num']+0).'", ';

		$mysql_fields.='stocks_id="'.$row['stocks_id'].'", ';

		$mysql_fields.='trade_details="'.$_POST['trade_details'].'", ';

		$mysql_fields.='trade_shares="'.$_POST['trade_shares'].'", ';
		$mysql_fields.='trade_shares_left="'.$_POST['trade_shares'].'", ';

		$mysql_fields.='trade_price_share="'.str_replace(',', '', $_POST['trade_price_share']).'", ';
		$mysql_fields.='trade_value="'.str_replace(',', '', $_POST['trade_value']).'", ';
		$mysql_fields.='trade_fees="'.str_replace(',', '', $_POST['trade_fees']).'", ';
		$mysql_fields.='trade_invoiced="'.str_replace(',', '', $_POST['trade_invoiced']).'", ';
		$mysql_fields.='trade_status="'.$_POST['trade_status'].'", ';
		$mysql_fields.='trade_notes="'.$_POST['trade_notes'].'", ';
		$mysql_fields.='trade_date="'.$_POST['trade_date'].'" ';

		$tradeRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;

		$query='INSERT INTO stock_trades SET '.$mysql_fields.', trade_type=2, trades_id="'.NID.'", trade_ref='.($tradeRef+0); //, trade_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'"
		$db->rq($query);

		$NewSharesCount=$row['trade_shares_left']-$_POST['trade_shares'];
		if ($NewSharesCount>0){
			$query='UPDATE stock_trades SET trade_shares_left='.($NewSharesCount+0).' WHERE trades_id='.($row['trades_id']+0).'';
			$db->rq($query);
		}else{
			$query='UPDATE stock_trades SET trade_shares_left=0, trade_status=4 WHERE trades_id='.($row['trades_id']+0).'';
			$db->rq($query);
		}

		if ($_POST['trade_status']==1){
			$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}

		$query='INSERT INTO trades_related SET trade_ref='.($tradeRef+0).', trade_ref_relatedto='.($row['trade_ref']+0).'';
		$db->rq($query);

		$link='sellref='.$tradeRef;

		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Stock Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Sell added '.($tradeRef+0).' ('.$tradesSellStatuses[$_POST['trade_status']].')');
	}else{
		//EDIT SELL ORDER
		$mysql_fields='';
		$mysql_fields.='user_account_num="'.($row['user_account_num']+0).'", ';

		$mysql_fields.='trade_shares="'.$_POST['trade_shares'].'", ';
		$mysql_fields.='trade_shares_left="'.$_POST['trade_shares'].'", ';
		$mysql_fields.='trade_details="'.$_POST['trade_details'].'", ';
		$mysql_fields.='trade_price_share="'.str_replace(',', '', $_POST['trade_price_share']).'", ';
		$mysql_fields.='trade_value="'.str_replace(',', '', $_POST['trade_value']).'", ';
		$mysql_fields.='trade_fees="'.str_replace(',', '', $_POST['trade_fees']).'", ';
		$mysql_fields.='trade_invoiced="'.str_replace(',', '', $_POST['trade_invoiced']).'", ';
		$mysql_fields.='trade_date="'.$_POST['trade_date'].'", ';
		$mysql_fields.='trade_status="'.$_POST['trade_status'].'", ';
		$mysql_fields.='trade_notes="'.$_POST['trade_notes'].'" ';

		/*** FIX SHARES IF NEEDED ***/
		if ($row['trade_shares']!=$_POST['trade_shares']){
			// Get Related Buy
			$query2='SELECT trade_ref_relatedto, trade_shares_left FROM trades_related tr LEFT JOIN stock_trades t ON trade_ref_relatedto=t.trade_ref 
			WHERE tr.trade_ref="'.$row['trade_ref'].'"';
			$res2=$db->rq($query2);
			$row2=$db->fetch($res2);

			// Update Related Buy
			$query3='UPDATE stock_trades SET trade_shares_left=(trade_shares_left+'.($row['trade_shares']+0).') 
			WHERE trade_ref="'.$row2['trade_ref_relatedto'].'"';
			$db->rq($query3);

			$getUpdatedRow=$db->getRow('stock_trades','trade_ref="'.$row2['trade_ref_relatedto'].'"','trade_shares_left');

			$NewSharesCount=$getUpdatedRow['trade_shares_left']-$_POST['trade_shares'];
			if ($NewSharesCount>0){
				$query='UPDATE stock_trades SET trade_shares_left='.($NewSharesCount+0).' WHERE trades_id='.($row['trades_id']+0).'';
				$db->rq($query);
			}else{
				$query='UPDATE stock_trades SET trade_shares_left=0, trade_status=4 WHERE trades_id='.($row['trades_id']+0).'';
				$db->rq($query);
			}
		}

		$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
		/*** FIX USERS's BALANCE IF NEEDED ***/
		if ($fixPostValue==$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total are same, but status is different
			if ($_POST['trade_status']==1){
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif($row['trade_status']==1){
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}elseif ($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']==$row['trade_status']&&$row['trade_status']==1){ // if new total and old total are different, but status is same (open)
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif ($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total different and also status is different
			if ($_POST['trade_status']==1&&$row['trade_status']!=1){
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}else{
				$query='UPDATE users SET user_balance=(user_balance-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}

		$query='UPDATE stock_trades SET '.$mysql_fields.' WHERE trade_ref="'.$row['trade_ref'].'"';
		$db->rq($query);

		$link='sellref='.$row['trade_ref'];

		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Stock Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Sell edited '.($row['trade_ref']+0).' ('.$tradesSellStatuses[$_POST['trade_status']].')');
	}
}
$db->close();

if($_POST['trade_status']==1) {
	header('Location: mails_singleuser.php?uid='.$_POST['user_account_num'].'&'.$link.'');
}else{
	header('Location: strades.php');
}
exit();

?>