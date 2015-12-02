<?php

require_once('common.php');
check_logged_in();

$PageTitle=getLang('ptitle_logged');

$db=new DBConnection();
$query='SELECT user_firstname, trading_type,user_lastname,user_account_num FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';
$res=$db->rq($query);
$username=$db->fetch($res);

$total_change = 0;
$total_cost = 0;
$total_value = 0;
$total_profit = 0;
$total_pps_a = 0;
$total_pps_b = 0;


$query='SELECT * FROM stock_trades WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" AND (trade_type="1" OR trade_type="3") AND trade_status="1" ORDER BY trade_date DESC';
$res=$db->rq($query);

$result = array();
while($row=$db->fetch($res)) {
	$subq=$db->rq("SELECT * FROM stocks WHERE stocks_id='".$row['stocks_id']."' LIMIT 1");
	$row['stock'] = $db->fetch($subq);
	$subq=$db->rq("SELECT * FROM stock_details WHERE stocks_id='".$row['stocks_id']."' ORDER BY date DESC LIMIT 1");
	$row['details'] = $db->fetch($subq);

	$total_pps_b += $row['trade_price_share'];
	$total_pps_a += $row['details']['value'];
	$total_cost += $row['trade_value'];

	$row['cur_value'] = $row['details']['value'] * $row['trade_shares_left'];
	$total_value += $row['cur_value'];

	$row['profit'] = ((($row['cur_value'] - $row['trade_value']) / $row['trade_value']) * 100);
	if($row['profit'] > 0) {
		$row['profit_class'] = ' class="text-success"';
	} else if($row['profit'] < 0) {
		$row['profit_class'] = ' class="text-danger"';
	} else {
		$row['profit_class'] = '';
	}

	$row['details']['value_change'] = number_format($row['details']['value_change'],2);
	if($row['details']['value_change'] < 0) {
		$row['details']['value_change'] = '<span class="icon loss"></span>'.(-1*$row['details']['value_change']).'%';
	} else if($row['details']['value_change'] > 0) {
		$row['details']['value_change'] = '<span class="icon win"></span>'.$row['details']['value_change'].'%';
	} else {
		$row['details']['value_change'] = $row['details']['value_change'].'%';
	}

	$result[] = $row;
}

if($total_pps_b) {
	$total_change = number_format(((($total_pps_a - $total_pps_b)/$total_pps_b)*100), 2);
} else {
	$total_change = 0;
}

if($total_change < 0) {
	$total_change = '<span class="icon loss"></span>'.(-1*$total_change).'%';
} else if($total_change > 0) {
	$total_change = '<span class="icon win"></span>'.$total_change.'%';
} else {
	$total_change = $total_change.'%';
}

if($total_cost) {
	$total_profit = (($total_value-$total_cost)/$total_cost)*100;
} else {
	$total_profit = 0;
}

if($total_profit > 0) {
	$profit_class = ' class="text-success"';
} else if($total_profit < 0) {
	$profit_class = ' class="text-danger"';
} else {
	$profit_class = '';
}

get_view('layouts/header', compact('username', 'PageTitle'), array('data-tables/DT_bootstrap', 'advanced-datatable/css/demo_page', 'advanced-datatable/css/demo_table'));
get_view('layouts/sidebar', array('active' => 'holdings'));
get_view('holdings_view', compact('result', 'total_change', 'total_profit', 'profit_class', 'total_cost', 'total_value'));
get_view('layouts/right_sidebar');
get_view('layouts/footer', null, null, array('advanced-datatable/js/jquery.dataTables', 'data-tables/DT_bootstrap', 'dynamic_table_init'));