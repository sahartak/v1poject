<?php

session_cache_limiter ('private, must-revalidate'); //by Bizarski
session_cache_expire(60); // in minutes, by Bizarski

session_start();

require '../vendor/autoload.php';

//session fix by Bizarski
if(!$_SESSION['admin']['is_logged']) {
	if(isset($_SESSION['user']['user_lastloginip'])) {
		$UserIP=GetHostByName($_SERVER["REMOTE_ADDR"]); 
		if($_SESSION['user']['user_lastloginip'] != $UserIP) {
			unset($_SESSION['user']);
			unset($_SESSION['UserSessionTime']);
			session_regenerate_id();
			session_destroy();
			exit();
		}
	} 
}
//end of session fix

DEFINE('MAX_SESSION_TIME', 3600); // Define the max session lifetime (in seconds) - 3600 == 1 hour

if (!isset($_SESSION['UserSessionTime'])){
	$_SESSION['UserSessionTime']=time()+MAX_SESSION_TIME;
}else{
	if ($_SESSION['UserSessionTime']<time()){
		unset($_SESSION['user']);
		unset($_SESSION['UserSessionTime']);
		session_regenerate_id();
		session_destroy();
		exit();
	}else{
		$_SESSION['UserSessionTime']=time()+MAX_SESSION_TIME;
	}
}

if($_SESSION['user']['is_logged']!=1) {
	header('Location: index.php');
	exit();
}
usleep(150000);
require_once('../classes/db.class.php');
	$db=new DBConnection();
	$validateBalance=$db->string_escape($_GET['tr_value']);
	$validateBalance=str_replace(',','',$validateBalance);
	$query='SELECT user_balance FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	if ($row['user_balance']>=$validateBalance){
		$valid = 'true';
	}else{
		$valid = 'false';
	}
	$db->close();
echo $valid;
?>