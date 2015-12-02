<?php

$db=new DBConnection();
$mysql_fields='';
$comma='';
$count=0;
foreach ($_POST as $k=>$x){
	if ($k!='tref'&&$k!='_submit'&&$k!='_form_submit'&&$k!='k'&&$k!='_add_short'){
		if ($count!=0) $comma=', ';
		if ($k=='stocks_id'){
			$explodeString=explode("_", $x);
			$x=$explodeString[0];
		}

		if ($k=='trade_price_share'||$k=='trade_value'||$k=='trade_fees'||$k=='trade_invoiced') $x=str_replace(',', '', $x);
		if ($k=="trade_shares") { $x = (-1)*$x; }

		$mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';
		$count++ ;
	}
}
global $tradesStatuses;
global $tradesBuyOptions;

if (!$_POST['tref']){
	$tradeRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;
	$query='INSERT INTO stock_trades SET '.$mysql_fields.', trade_shares_left='.($_POST['trade_shares']+0).', trade_type=4, trades_id="'.NID.'", trade_ref='.($tradeRef+0); //.', trade_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'"'
	$db->rq($query);

	if ($_POST['trade_status']==1){
		$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
		$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'", 
		user_trades=(user_trades+1) WHERE user_account_num="'.$_POST['user_account_num'].'"';
		$db->rq($query);
	}
	$link='buyref='.$tradeRef;

	$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
	addLog('Back-end','Stock Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Short Sell added '.($tradeRef+0).' ('.$tradesBuyOptions[$_POST['trade_option']].' @ '.$tradesStatuses[$_POST['trade_status']].')');
}else{
	$query='SELECT * FROM stock_trades WHERE trade_ref="'.$_POST['tref'].'" LIMIT 1';
	$res=$db->rq($query);
	$row=$db->fetch($res);

	$query='UPDATE stock_trades SET '.$mysql_fields.', trade_shares_left=0, trade_type=4 
	WHERE trade_ref="'.$_POST['tref'].'"'; //, trade_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'"
	$db->rq($query);

	$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);

	/*** FIX USERS's BALANCE IF NEEDED ***/
	if($fixPostValue==$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total are same, but status is different
		if ($_POST['trade_status']==1&&$row['trade_status']!=1&&$row['trade_status']!=4){
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif ($_POST['trade_status']==4&&$row['trade_status']!=1&&$row['trade_status']!=4){
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==1){
			$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==4){
			$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}
	}elseif($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']==$row['trade_status']&&($row['trade_status']==1||$row['trade_status']==4)){ // if new total and old total are different, but status is same (open or closed)
		$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'+'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
		$db->rq($query);
	}elseif ($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total different and also status is different
		if ($_POST['trade_status']==1&&$row['trade_status']!=1&&$row['trade_status']!=4){
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif ($_POST['trade_status']==4&&$row['trade_status']!=1&&$row['trade_status']!=4){
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==1){
			$query='UPDATE users SET user_balance=(user_balance-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==4){
			$query='UPDATE users SET user_balance=(user_balance-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}
	}

	/*** FIX TRADES COUNT IF NEEDED ***/
	if($_POST['trade_status']==1&&$row['trade_status']!=1) {
		$query='UPDATE users SET user_trades=(user_trades+1), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
		$db->rq($query);
	}elseif($_POST['trade_status']!=1&&$row['trade_status']==1) {
		$query='UPDATE users SET user_trades=(user_trades-1), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
		$db->rq($query);
	}

	$link='buyref='.$_POST['tref'];
	$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
	addLog('Back-end','Stock Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Short Sell edited '.($_POST['tref']+0).' ('.$tradesBuyOptions[$_POST['trade_option']].' @ '.$tradesStatuses[$_POST['trade_status']].')');
}

$db->close();
if($_POST['trade_status']==1) {
	header('Location: mails_singleuser.php?uid='.$_POST['user_account_num'].'&'.$link.'');
}else{
	header('Location: strades.php');
}
exit();

?>