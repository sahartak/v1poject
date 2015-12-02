<?php

require_once('common.php');
check_logged_in();


if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1) {
	$PageTitle=getLang('ptitle_logged');
}else{
	$PageTitle=getLang('ptitle_notlogged');
}

if (isset($_POST['_form_submit'])){
	$db=new DBConnection();
	$mysql_fields='';
	$comma='';
	$count=0;
	foreach ($_POST as $k=>$x) {
		if ($k!='usid'&&$k!='_submit'&&$k!='_form_submit'&&$k!='user_refid'&&$k!='user_password'&&$k!='user_password2'){
			if ($count!=0) $comma=', ';
			$mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';
			$count++ ;
		}
	}
	// echo $mysql_fields;
	if ($_SESSION['user']['user_passisset']!=1&&$_SESSION['user']['user_password']!=$_POST['user_password']){
		$mysql_fields.=', user_passisset=1';
		unset($_SESSION['user']['user_password']);
		$_SESSION['user']['user_passisset']=1;
	}
	// echo $mysql_fields;die;
	if($mysql_fields) {
		$query='UPDATE users SET '.$mysql_fields.' WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'"';
		$db->rq($query);
	}

	// echo $query;
	if(isset($_POST['user_password']) && $_POST['user_password']!=''&&$_POST['user_password']==$_POST['user_password2']) {
		$query='UPDATE users SET user_password="'.$_POST['user_password'].'" WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'"';
		$db->rq($query);
	}
	$db->close();
	// var_dump($db->error());
	$_SESSION['account_details_msg'] = 'Account details updated!';
	header('Location: account.php');
	exit;
}

$db=new DBConnection();
$query='SELECT user_firstname, trading_type,user_lastname,user_account_num FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';
$res=$db->rq($query);
$username=$db->fetch($res);

$userTitles=array(1=>'Mr.', 2=>'Mrs.', 3=>'Miss', 4=>'Dr.', 5=>'Pr.');
$userBankCodeTypes=array(1=>'SWIFT Code', 2=>'IBAN Code', 3=>'ABA #', 4=>'BSC Code');

$query='SELECT * FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'"';
$res=$db->rq($query);
$_POST=$db->fetch($res);


$query='SELECT country_full FROM countries ORDER BY country_full';
$res=$db->rq($query);
$countries = array();
while (($row=$db->fetch($res))!=FALSE){
	$countries[] = $row;
}

$db->close();

get_view('layouts/header', compact('username', 'PageTitle'));
get_view('layouts/sidebar', array('active' => 'account'));
get_view('account_view', compact('userTitles', 'countries', 'userBankCodeTypes'));
get_view('layouts/right_sidebar');
get_view('layouts/footer', null, null, array('jquery.validate.min', 'validation-init'));

