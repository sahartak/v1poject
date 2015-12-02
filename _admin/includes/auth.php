<?php

function isAppLoggedIn(){
	return isset($_SESSION['admin']) && isset($_SESSION['admin']['is_logged']) && ($_SESSION['admin']['is_logged']===true);
}

/**
 * 
 * @param type $uid
 * @param type $username
 * @param \uLogin $ulogin
 */
function appLogin($uid, $username, $ulogin){
	$_SESSION['admin']['adminid'] = $uid;
	$_SESSION['admin']['username'] = $username;
	$_SESSION['admin']['is_logged'] = true;
    
    $db = new \DBConnection();
    $adminModel = new \App\Model\Admin($db);
    $admin = $adminModel->getAdmin($uid);
    
    $_SESSION['admin']['refnum'] = $admin['ref'];
    $_SESSION['admin']['name']   = $admin['name'];
    $_SESSION['admin']['email']  = $admin['email'];
    $_SESSION['admin']['type']   = $admin['type'];
    
    addLog('Back-end', 'Login', ''.$admin['name'].' ('.$admin['ref'].')',''.$admin['name'].' ('.$admin['ref'].')','Successfully logged in');

	if (isset($_SESSION['appRememberMeRequested']) && ($_SESSION['appRememberMeRequested'] === true))
	{
		// Enable remember-me
		if ( !$ulogin->SetAutologin($username, true)) {
			echo "cannot enable autologin<br>";
        }

		unset($_SESSION['appRememberMeRequested']);
	}
	else
	{
		// Disable remember-me
		if ( !$ulogin->SetAutologin($username, false)) {
            echo 'cannot disable autologin<br>';
        }
	}
    
    page_header_simple();
    echo '<img src="../images/lploader.gif" border="0"><br /><b>System is loading, please wait...</b>';
    page_footer();
    exit();
}

function appLoginFail($uid, $username, $ulogin){
	echo 'login failed<br>';
    
    header('Location: index.php?error=1');
}

/**
 * @var \uLogin
 */
$ulogin = new uLogin('appLogin', 'appLoginFail');

if (isAppLoggedIn()) {
   if (isset($_GET['logout'])){
       $ulogin->Logout($_SESSION['admin']['adminid']);
       
       //addLog('Back-end', 'Login', ''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')', ''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')', 'Admin logged out.');
    
       unset($_SESSION['admin']);
       
       header('Location: ../index.php?logout=true&redirect_to=admin');
       exit();
   }
}
else {
    if (isset($_POST['_login'])){
        if (isset($_POST['nonce']) && ulNonce::Verify('login', $_POST['nonce'])){
            if (isset($_POST['autologin'])){
                $_SESSION['appRememberMeRequested'] = true;
            }
            else {
                unset($_SESSION['appRememberMeRequested']);
            }

			$ulogin->Authenticate($_POST['l_username'], $_POST['l_password']);
			if ($ulogin->IsAuthSuccess()){
				// Since we have specified callback functions to uLogin,
				// we don't have to do anything here.
			}
		} else {
            $msg = 'invalid nonce';
        }
    }
}

//ulLog::ShowDebugConsole();