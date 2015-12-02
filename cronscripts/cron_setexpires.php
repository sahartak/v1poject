<?php
require '../vendor/autoload.php';

require_once('../classes/db.class.php');
require_once('../includes/timefix.php');
set_time_limit(900);
$db=new DBConnection();
$today=date('Y-m-d', CUSTOMTIME);
$query='UPDATE trades SET trade_status=4 WHERE trade_expiry_date<"'.$today.'" AND trade_status=1';
$db->rq($query);

$query='SELECT user_account_num, user_lscp, user_lscp FROM users WHERE user_status=1';
$res=$db->rq($query);
while(($row=$db->fetch($res)) != FALSE) {
	$query2='SELECT MIN(trade_strikeprice) AS min_strike FROM trades WHERE trade_status=1 AND trade_option=1 AND user_account_num="'.$row['user_account_num'].'"';
	$res2=$db->rq($query2);
	$row2=$db->fetch($res2);
	
	if ($row2['min_strike']<$row['user_lscp']||$row['user_lscp']==0){
		$query3='UPDATE users SET user_lscp="'.($row2['min_strike']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
		WHERE user_account_num="'.$row['user_account_num'].'"';
		$db->rq($query3);
	}
	
	$query4='SELECT MAX(trade_strikeprice) AS max_strike FROM trades WHERE trade_status=1 AND trade_option=2 AND user_account_num="'.$row['user_account_num'].'"';
	$res4=$db->rq($query4);
	$row4=$db->fetch($res4);
	if ($row4['max_strike']>$row['user_hpsp']||$row['user_hpsp']==0){
		$query5='UPDATE users SET user_hpsp="'.($row4['max_strike']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
		WHERE user_account_num="'.$row['user_account_num'].'"';
		$db->rq($query5);
	}
	
	$query6='SELECT COUNT(trades_id) AS total_trades FROM trades WHERE trade_status=1 AND user_account_num="'.$row['user_account_num'].'"';
	$res6=$db->rq($query6);
	$row6=$db->fetch($res6);
	
	$query7='UPDATE users SET user_trades='.$row6['total_trades'].' WHERE user_account_num="'.$row['user_account_num'].'"';
	$db->rq($query7);
}
$db->close();
?>