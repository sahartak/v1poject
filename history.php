<?php
require_once('common.php');
check_logged_in();


if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1) {
	$PageTitle=getLang('ptitle_logged');
}else{
	$PageTitle=getLang('ptitle_notlogged');
}
$db=new DBConnection();
$userModel = new App\Model\User($db);
$user = $userModel->getUserByUid($_SESSION['user']['user_account_num']);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$db=new DBConnection();

	$view = new App\View\View('mail/trade_request');
	$view->form = $_POST;
	$view->user = $user;

	$to = getLang('site_notification');

	$message = \Swift_Message::newInstance('Trade Request from ' . $user['user_account_name']);
	$message
		->setFrom($to)
		->setTo($to)
		->setBody($view->render(), 'text/html');

	$mailer = new App\Utility\Mailer($db);
	$mailer->send($message);
	$_SESSION['history_msg'] = 'Request was send';
	header('Location: history.php');
	exit;
}

$query='SELECT user_firstname, trading_type,user_lastname,user_account_num FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';
$res=$db->rq($query);
$username=$db->fetch($res);

$buyStatuses = array(1=>'Open', 2=>'Pending', 3=>'Disabled', 4=>'Closed');
$sellStatuses = array(1=>'Closed', 2=>'Pending', 3=>'Disabled');
$tradesBuyOptions = array(1=>'CALL', 2=>'PUT');

$query='SELECT * FROM trades WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" ORDER BY trade_date DESC, trade_action_date DESC, trades_id DESC';
$res=$db->rq($query);
if($user['trading_type'] == 1 || $user['trading_type'] == 3) {
	$hist_trade_head = array();
	while(($row=$db->fetch($res))) {
		if($row['trade_type']==1) {
			$row['status'] = $buyStatuses[$row['trade_status']];
		} else{
			$row['status'] = $sellStatuses[$row['trade_status']];
		}
		$hist_trade_head[] = $row;
	}
}

if($user['trading_type'] == 2 || $user['trading_type'] == 3) {
	$query='SELECT * FROM stock_trades WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" ORDER BY trade_date DESC, trades_id DESC';
	$res=$db->rq($query);
	$hist_stock_head = array();
	while(($row=$db->fetch($res))) {
		switch($row['trade_type']) {
			case 1:
				$row['status'] = 'Buy';
			break;
			case 2:
				$row['status'] = 'Sell';
			break;
			case 3:
				$row['status'] = 'Buy to Cover';
			break;
			case 4:
				$row['status'] = 'Short Sell';
			break;
		}
		$hist_stock_head[] = $row;
	}
}

$depositOptions=array(1=>'Transferred', 2=>'Pending', 3=>'Disabled');
$transfersOptions=array(1=>'Deposit', 2=>'Withdraw');

$query='SELECT * FROM transfers WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" ORDER BY tr_date DESC, tr_system_update DESC, transfers_id DESC';
$res=$db->rq($query);
$hist_fund_head = array();
while(($row=$db->fetch($res))!=FALSE) {
	$hist_fund_head[] = $row;
}

$db->close();

get_view('layouts/header', compact('username', 'PageTitle'), array('data-tables/DT_bootstrap', 'advanced-datatable/css/demo_page', 'advanced-datatable/css/demo_table'));
get_view('layouts/sidebar', array('active' => 'history'));
get_view('history_view', compact('hist_trade_head', 'hist_stock_head', 'depositOptions', 'transfersOptions', 'hist_fund_head', 'user', 'buyStatuses', 'sellStatuses', 'tradesBuyOptions'));
get_view('layouts/right_sidebar');
get_view('layouts/footer', null, null, array('advanced-datatable/js/jquery.dataTables', 'data-tables/DT_bootstrap', 'dynamic_table_init', 'jquery.validate.min', 'validation-init'));

