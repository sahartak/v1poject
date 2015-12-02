<?php
//get admin session
session_name('SSESID');
session_start();
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}
session_write_close();

//set user session
session_name('PHPSESSID');
session_start();
session_regenerate_id(false);
$_SESSION = Array();

require_once ('src/App/Utility/Config.php');
require_once ('classes/db.class.php');
$db=new DBConnection();
$query='SELECT * FROM users WHERE user_account_num="'.($_GET['uid']+0).'" AND user_status=1 LIMIT 1';
$res=$db->rq($query);
$row=$db->fetch($res);

//validate presense of user
if($row['users_id']<=0){
	echo 'User not found!';
	exit();
}

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
$_SESSION['user']['user_lastlogin']=$row['user_lastlogin'];
$_SESSION['user']['user_lastloginip']=$row['user_lastloginip'];
$_SESSION['user']['dosuuser'] = true;
header('Location: index.php');
exit();
page_header_simple(1);
echo '<img src="images/lploader.gif" border="0"><br /><b>Loading user details, please wait...</b>';
page_footer(1);
?>