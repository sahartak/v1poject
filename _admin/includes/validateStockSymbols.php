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
	$validateStock=$db->string_escape($_GET['symbol']);
	$query='SELECT stocks_id FROM stocks WHERE stocks_symbol="'.$validateStock.'" LIMIT 1';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if ($num_rows==0){
		$valid = 'true';
	}else{
		$row=$db->fetch($res);
        
		if($row['stocks_id'] > 0 && isset($_SESSION['admin']['uedit']) && $row['stocks_id'] == $_SESSION['admin']['uedit']) {
			$valid = 'true';
		}else{
			$valid = 'false';
		}
	}
	$db->close();
echo $valid;
?>