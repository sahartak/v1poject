<?php

require 'vendor/autoload.php';

define('PROJECT_PATH', dirname(__FILE__) . '/');
define('SRC_PATH', PROJECT_PATH . 'src/');

session_cache_limiter ('private, must-revalidate'); //by Bizarski
session_cache_expire(60); // in minutes, by Bizarski

session_start();

//session fix by Bizarski
if(isset($_SESSION['admin']['is_logged']) and !$_SESSION['admin']['is_logged']) {
	if(isset($_SESSION['user']['user_lastloginip'])) {
		$UserIP=GetHostByName($_SERVER["REMOTE_ADDR"]); 
		if($_SESSION['user']['user_lastloginip'] != $UserIP) {
			unset($_SESSION['user']);
			unset($_SESSION['UserSessionTime']);
			session_regenerate_id();
			session_destroy();
			header('Location: index.php');
		}
	} 
}
//end of session fix

require_once ('classes/db.class.php');
require_once ('includes/timefix.php');
require_once ('includes/global_funcs.php');

DEFINE('NID', round(hexdec(substr(uniqid(''), 0, 11))/100)-40505050500);
DEFINE('MAX_SESSION_TIME', 3600); // Define the max session lifetime (in seconds) - 3600 == 1 hour

if (!isset($_SESSION['UserSessionTime'])){
	$_SESSION['UserSessionTime']=time()+MAX_SESSION_TIME;
}else{
	if ($_SESSION['UserSessionTime']<time()){
		unset($_SESSION['user']);
		unset($_SESSION['UserSessionTime']);
		session_regenerate_id();
		session_destroy();
		header('Location: index.php');
		exit();
	}else{
		$_SESSION['UserSessionTime']=time()+MAX_SESSION_TIME;
	}
}

function check_logged_in() {
    if(!(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1)) {
        header('Location: login.php');
        exit;
    }
}

function get_view($name, $data=null, $css = null, $js = null) {
    if(is_array($data)) {
        extract($data);
    }
    include 'views/'.$name.'.php';
}

/**
 * Translation function
 *
 * @param $string		What to translate
 * @return mixed
 */
include ('lang/english.php');
function getLang($string) {

	global $lang;
	
	$display_translation=$lang[$string];
	
	/** Search if we need to replace something in the translation **/
	$search_for=array('{usernames}');
	$replace_with=array(''.array_get(array_get($_SESSION, 'user', array()), 'user_account_name').'');
	$display_translation=str_replace($search_for, $replace_with, $display_translation);
	
	return $display_translation;
}

/**
 * Used to clear the session and add a log
 */
if (isset($_SESSION['user']) && isset($_GET['logout']) && $_SESSION['user']['is_logged']==1){
	addLog('Front-end', 'Login', ''.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].' ('.$_SESSION['user']['user_account_num'].')', 0, 'User successfully logged out');
	
	unset($_SESSION['user']);
	if (!$_SESSION['admin']['is_logged']) session_destroy();
	if($_GET['redirect_to'] == 'admin'){
		header('Location: _admin/index.php');	
	}else{
		header('Location: index.php');
	}
	exit();
}else if(isset($_GET['redirect_to']) && $_GET['redirect_to'] == 'admin'){
	header('Location: _admin/index.php');	
	exit();
}

/**
 * Initialize the login
 */
if (!empty($_POST) && isset($_POST['l_username']) && isset($_POST['l_password']) && !(isset($_SESSION['user']['is_logged']) && $_SESSION['user']['is_logged'] != 1)){
	$db=new DBConnection();
	$UserIP=GetHostByName($_SERVER["REMOTE_ADDR"]);
	$username=$_POST['l_username'];
	$username=$db->string_escape($username);
	
	$password=$_POST['l_password'];
	$password=$db->string_escape($password);
	
	$query='SELECT * FROM users WHERE user_username="'.$username.'" AND user_status=1 AND user_password!="" LIMIT 1';
	$res=$db->rq($query);
	$row=$db->fetch($res);
    $validatePassword=FALSE;
    if($row) {
        $base_password=$row['user_password'];

        if ($password==$base_password) $validatePassword=TRUE;
    }

	if ($validatePassword==TRUE&&strtolower($row['user_username'])==strtolower($username)){ // if everything goes ok
		// page_header_simple(1);
		// echo '<img src="images/lploader.gif" border="0"><br /><b>Page is loading, please wait...</b>';
		// page_footer();
		$_SESSION['user']['is_logged']=1;
		$_SESSION['user']['user_account_num']=$row['user_account_num'];
		$_SESSION['user']['user_username']=$row['user_username'];
		$_SESSION['user']['user_fullref']=$row['user_fullref'];
		$_SESSION['user']['user_firstname']=$row['user_firstname'];
		$_SESSION['user']['user_middlename']=$row['user_middlename'];
		$_SESSION['user']['user_lastname']=$row['user_lastname'];
		$_SESSION['user']['user_account_name']=$row['user_account_name'];
		$_SESSION['user']['user_email']=$row['user_email'];
		if ($row['user_passisset']==0){
			$_SESSION['user']['user_passisset']=0;
			$_SESSION['user']['user_password']=$row['user_password'];
		}else{
			$_SESSION['user']['user_passisset']=1;
		}
		$_SESSION['user']['user_lastlogin']=date('d/m/Y @ H:i', CUSTOMTIME);
		$_SESSION['user']['user_lastloginip']=$UserIP;
		
		$query='UPDATE users SET user_lastlogin="'.date('Y-m-d H:i:s', CUSTOMTIME).'", user_lastloginip="'.$UserIP.'", user_loginscount=(user_loginscount+1) WHERE users_id='.($row['users_id']+0).'';
		$db->rq($query);
		
		addLog('Front-end', 'Login', ''.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].' ('.$_SESSION['user']['user_account_num'].')', 0, 'User successfully logged in');
		
		$db->close();
		unset($_SESSION['invalidlogins']);
        header('Location: index.php');
	}elseif (($row['users_id']+0)>0){
		addLog('Front-end', 'Login', ''.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].' ('.$_SESSION['user']['user_account_num'].')', 0, 'Invalid login. Valid username used. Invalid password used.');
		
		header('Location: login.php?error=1');
		exit();
	}else{ // if the password and username were invalid
		addLog('Front-end', 'Login', ''.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].' ('.$_SESSION['user']['user_account_num'].')', 0, 'Invalid login. Invalid username and password used.');
		header('Location: login.php?error=1');
		exit();
	}
}

/**
 * Common function to view arrays in good looking way
 * @param array		array to paste
 * @return mixed
 */
function pre($string) {

	echo '<pre>';
	print_r($string);
	echo '</pre>';
}

function geld($string) {

	$returnNum='';
	for($done=strlen($string); $done>3; $done-=3){
		$returnNum=','.substr($string, $done-3, 3).$returnNum;
	}
	return substr($string, 0, $done).$returnNum;
}