<?php
	require_once('common.php');
	check_logged_in();


	if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1) {
		$PageTitle=getLang('ptitle_logged');
	}else{
		$PageTitle=getLang('ptitle_notlogged');
	}
	$db=new DBConnection();

	$query='SELECT user_firstname, trading_type,user_lastname,user_account_num FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';
	$res=$db->rq($query);
	$username=$db->fetch($res);

	$userProfile = '';

//---------------------------------------------
	$total_trading=0;
	$total_trading2=0;
	$total_total_fees=0;
	$total_purchase=0;
	$total_sales=0;
	$total_fees=0;
	$query='SELECT SUM(trade_value) AS total_purchase FROM trades WHERE trade_type=1 AND trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading-=$row['total_purchase'];
	$total_trading2-=$row['total_purchase'];
	$total_purchase+=$row['total_purchase'];

	$query='SELECT SUM(trade_value) AS total_purchase FROM stock_trades WHERE trade_type=1 AND trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading-=$row['total_purchase'];
	$total_trading2-=$row['total_purchase'];
	$total_purchase+=$row['total_purchase'];

	$query='SELECT SUM(trade_value) AS total_purchase FROM stock_trades WHERE trade_type=3 AND trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading-=$row['total_purchase'];
	$total_trading2-=$row['total_purchase'];
	$total_purchase+=$row['total_purchase'];

	$query='SELECT SUM(trade_value) AS total_sales FROM trades WHERE trade_type=2 AND trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading+=$row['total_sales'];
	$total_trading2+=$row['total_sales'];
	$total_sales+=$row['total_sales'];

	$query='SELECT SUM(trade_value) AS total_sales FROM stock_trades WHERE trade_type=2 AND trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading+=$row['total_sales'];
	$total_trading2+=$row['total_sales'];
	$total_sales+=$row['total_sales'];

	$query='SELECT SUM(trade_value) AS total_sales FROM stock_trades WHERE trade_type=4 AND trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading+=$row['total_sales'];
	$total_trading2+=$row['total_sales'];
	$total_sales+=$row['total_sales'];

	$query='SELECT SUM(trade_fees) AS total_fees FROM trades WHERE trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading-=$row['total_fees'];
	$total_total_fees+=$row['total_fees'];
	$total_fees+=$row['total_fees'];

	$query='SELECT SUM(trade_fees) AS total_fees FROM stock_trades WHERE trade_status IN (1,4) AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_trading-=$row['total_fees'];
	$total_total_fees+=$row['total_fees'];
	$total_fees+=$row['total_fees'];

	if($total_trading<0) {
		$total_trading=number_format($total_trading,2);
		$total_trading=str_replace('-','$',$total_trading);
		$total_trading='<b class="text-danger">'.$total_trading.'</b>';
	}else{
		$total_trading='<b class="text-success">$'.number_format($total_trading,2).'</b>';
	}

//----------------------------


	$total_funding=0;
	$total_funding2=0;
	$query='SELECT SUM(tr_value) AS total_deposit FROM transfers WHERE tr_type=1 AND tr_status=1 AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_funding+=$row['total_deposit'];
	$total_funding2+=$row['total_deposit'];
	$total_deposit=number_format($row['total_deposit'],2);

	$query='SELECT SUM(tr_value) AS total_withdraw FROM transfers WHERE tr_type=2 AND tr_status=1 AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_funding-=$row['total_withdraw'];
	$total_funding2-=$row['total_withdraw'];
	$total_withdraw=number_format($row['total_withdraw'],2);

	$query='SELECT SUM(tr_fees) AS total_fees2 FROM transfers WHERE tr_status=1 AND user_account_num="'.$_SESSION['user']['user_account_num'].'"';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$total_funding-=$row['total_fees2'];
	$total_total_fees+=$row['total_fees2'];
	$total_fees2=number_format($row['total_fees2'],2);

	if($total_funding<0) {
		$total_funding=number_format($total_funding,2);
		$total_funding=str_replace('-','-$',$total_funding);
		$total_funding='<b class="text-danger">'.$total_funding.'</b>';
	}else{
		$total_funding='<b class="text-success">$'.number_format($total_funding,2).'</b>';
	}
//----------------------------------------------------------------

	$account_balance=0;
	$query='SELECT * FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	$userTitles=array(1=>'Mr.',2=>'Mrs.',3=>'Miss',4=>'Dr.',5=>'Pr.');
	$account_num_short=explode('-',$row['user_fullref']);
	$account_balance=$row['user_balance'];

	if($total_trading2<0) {
		$total_trading2=number_format($total_trading2,2);
		$total_trading2=str_replace('-','-$',$total_trading2);
		$total_trading2='<b class="text-danger">'.$total_trading2.'</b>';
	}else{
		$total_trading2='<b class="text-success">$'.number_format($total_trading2,2).'</b>';
	}

	if($total_funding2<0) {
		$total_funding2=number_format($total_funding2,2);
		$total_funding2=str_replace('-','-$',$total_funding2);
		$total_funding2='<b class="text-danger">'.$total_funding2.'</b>';
	}else{
		$total_funding2='<b class="text-success">$'.number_format($total_funding2,2).'</b>';
	}

	$total_total_fees='<b class="text-danger">$'.number_format($total_total_fees,2).'</b>';

	if($account_balance<0) {
		$account_balance=number_format($account_balance,2);
		$account_balance=str_replace('-','-$',$account_balance);
		$account_balance='<b class="text-danger">'.$account_balance.'</b>';
	}else{
		$account_balance='<b class="text-success">$'.number_format($account_balance,2).'</b>';
	}

// ------------------------------------

if($row['user_advisor1']>0) {
	$query2 = 'SELECT * FROM users_advisors WHERE users_advisors_id=' . ($row['user_advisor1'] + 0) . ' LIMIT 1';
	$res2 = $db->rq($query2);
	$row2 = $db->fetch($res2);
} else {
	$row2 = false;
}

if($row['user_advisor2']>0&&$row['user_advisor1']!=$row['user_advisor2']) {
	$query2 = 'SELECT * FROM users_advisors WHERE users_advisors_id=' . ($row['user_advisor2'] + 0) . ' LIMIT 1';
	$res2 = $db->rq($query2);
	$row3 = $db->fetch($res2);
} else {
	$row3 = false;
}

$line_script = "<script type=\"text/javascript\">
	analytics.identify('{$row['user_account_num']}', {
	email   : '{$row['user_email']}',
	firm    : '{$row2['advisor_firm']}',
	name : '{$row['user_account_name']}'
});
analytics.track('Signed In');
analytics.page('WP Login');
</script>";

	$active = 'index';

	get_view('layouts/header', compact('username', 'PageTitle'));
	get_view('layouts/sidebar', compact('active'));
	get_view('index_view', compact('row3', 'row2', 'userTitles', 'row', 'total_trading2', 'total_funding2', 'total_total_fees', 'account_balance', 'total_purchase', 'total_sales', 'total_fees', 'total_trading', 'total_deposit', 'total_withdraw', 'total_fees2', 'total_funding'));
	get_view('layouts/right_sidebar');
	get_view('layouts/footer', compact('line_script'));