<?php
require '../../vendor/autoload.php';

require_once('ulogin/config/all.inc.php');
require_once('ulogin/main.inc.php');
require_once('auth.php');

if($_SESSION['admin']['is_logged']!=1) {
	header('Location: index.php');
	exit();
}
usleep(150000);
require_once('../../classes/db.class.php');
	$db=new DBConnection();
	$validateUser=$db->string_escape($_GET['username']);
	$query='SELECT id FROM ul_logins WHERE username="'.$validateUser.'" LIMIT 1';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if ($num_rows==0){
		$valid = 'true';
	}else{
		$row=$db->fetch($res);
		if($row['id'] > 0 && $row['id'] == $_SESSION['admin']['uedit']) {
			$valid = 'true';
		}else{
			$valid = 'false';
		}
	}
	$db->close();
echo $valid;
?>