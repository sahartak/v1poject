<?php
session_start();

require '../vendor/autoload.php';

if($_SESSION['user']['is_logged']!=1) {
	header('Location: index.php');
	exit();
}
usleep(150000);
require_once('../classes/db.class.php');
	$db=new DBConnection();
	$validateEmail=$db->string_escape($_GET['user_email']);
	$query='SELECT user_account_num FROM users WHERE user_email="'.$validateEmail.'" LIMIT 1';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if ($num_rows==0){
		$valid = 'true';
	}else{
		$row=$db->fetch($res);
		if($row['user_account_num']>0&&$row['user_account_num']==$_SESSION['user']['user_account_num']) {
			$valid = 'true';
		}else{
			$valid = 'false';
		}
	}
	$db->close();
echo $valid;
?>