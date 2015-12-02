<?php
require '../vendor/autoload.php';
require_once('common.php');

function page_header($showbuttons=1){
    if (array_get($_SESSION['admin'], 'is_logged') == 1) {
        $PageTitle = getLang('atitle_logged');
    } else {
        $PageTitle = getLang('atitle_notlogged');
    }

    echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>'.$PageTitle.'</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="content-language" content="en" />
<meta name="language" content="en" />';
    
    if(array_get($_SESSION['admin'], 'is_logged') == true) {
    echo '
<link href="../themes/smoothness/jquery-ui-1.7.2.custom.css" media="all" rel="stylesheet" type="text/css" />
<link href="../css/validationEngine.jquery.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../js/underscore-min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">

var AJAX_URL = "' . $_SERVER['REQUEST_URI'] . '";
    
jQuery(document).ready(function($){
    var $tabs = $("#tabs").tabs({
        select: function(event, ui){
            var url = $.data(ui.tab, "load.tabs");
            var tabid = ui.panel.id;
            
            if(url) {
                location.href = url;
                return false;
            }
       	
           	return true;
        }
    });

    $("#tabs").tabs("select", '.($_SESSION['admin']['selected_tab']+0).');
    $("div.TabsHolder").show();

    $("#Tab0, #Tab1, #Tab2, #Tab3, #Tab5, #Tab6, #Tab7, #Tab10").click(function() {
        location.href = $(this).attr("rel");
        return false;
    });

    $("#expiry_date, #trade_date, #tr_date, #user_app_date, #date_value").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
});
</script>';
    }
    echo '
<link href="css/styles.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
</head>
	
<body>
<div class="wrapper">';
    if(array_get($_SESSION['admin'], 'is_logged') == true) {
    	$mailsToSend='';
    	$db=new DBConnection();
    	if($showbuttons==1) {
	    $query='SELECT COUNT(*) AS total_mails FROM mail_queue WHERE is_sent=0';
	    $res=$db->rq($query);
	    $row=$db->fetch($res);
	    if($row['total_mails']>0){
            $mailsToSend=' ('.$row['total_mails'].')';
        }

	    $usersActive='';
	    $usersPending='';
	    $usersDisabled='';
	    $usersTrades0='';
	    $usersTrades1='';
	    $usersTrades2='';
        
	    $query='SELECT COUNT(*) AS total_num FROM users WHERE user_status=1';
	    $res=$db->rq($query);
	    $row=$db->fetch($res);
	    if($row['total_num']>0){
            $usersActive=' ('.$row['total_num'].')';
        }

	    $query='SELECT COUNT(*) AS total_num FROM users WHERE user_status=2';
	    $res=$db->rq($query);
	    $row=$db->fetch($res);
	    if($row['total_num']>0){
            $usersPending=' ('.$row['total_num'].')';
        }

	    $query='SELECT COUNT(*) AS total_num FROM users WHERE user_status=3';
	    $res=$db->rq($query);
	    $row=$db->fetch($res);
	    if($row['total_num']>0){
            $usersDisabled=' ('.$row['total_num'].')';
        }

	    $query='SELECT COUNT(trades_id) AS total_num FROM users
	    LEFT JOIN trades ON users.user_account_num=trades.user_account_num
	    GROUP BY users.user_account_num
	    HAVING total_num>=2';
	    $res=$db->rq($query);
	    $num_rows=$db->num_rows($res);
	    if($num_rows>0){
            $usersTrades2=' ('.$num_rows.')';
        }

	    $query='SELECT COUNT(trades_id) AS total_num FROM users
	    LEFT JOIN trades ON users.user_account_num=trades.user_account_num
	    GROUP BY users.user_account_num
	    HAVING total_num=1';
	    $res=$db->rq($query);
	    $num_rows=$db->num_rows($res);
	    if($num_rows>0){
            $usersTrades1=' ('.$num_rows.')';
        }

	    $query='SELECT COUNT(trades_id) AS total_num FROM users
	    LEFT JOIN trades ON users.user_account_num=trades.user_account_num
	    GROUP BY users.user_account_num
	    HAVING total_num=0';
	    $res=$db->rq($query);
	    $num_rows=$db->num_rows($res);
	    if($num_rows>0){
            $usersTrades0=' ('.$num_rows.')';
        }
        
        $adminType = array_get($_SESSION['admin'], 'type');

	echo '
    <div class="TabsHolder">
	<div id="tabs">
	    <ul>
		<li><a href="#TC-10" id="Tab0" rel="users.php?view=active">Accounts</a></li>
		<li><a href="#TC-50" id="Tab1" rel="trades.php">Option Trades</a></li>
		<li><a href="#TC-60" id="Tab2" rel="strades.php">Stock Trades</a></li>
		<li><a href="#TC-70" id="Tab3" rel="transfers.php">Transfers</a></li>
		<li><a href="#TC-65" id="Tab7" rel="stocks.php">Stock Management</a></li>
		<li' . ($adminType == 'owner' ? '' : ' style="display: none;"') . '><a href="#TC-80" id="Tab4">Back-end Settings</a></li>
		<li' . ($adminType == 'owner' ? '' : ' style="display: none;"') . '><a href="#TC-81" id="Tab8">Front-end Settings</a></li>
		<li><a href="#TC-85" id="Tab5" rel="users_advisors.php">Advisors</a></li>
		<li' . ($adminType == 'owner' ? '' : ' style="display: none;"') . '><a href="#TC-90" id="Tab6" rel="users_admins.php">Backend users</a></li>
		<li' . ($adminType == 'owner' ? '' : ' style="display: none;"') . '><a href="#TC-92" id="Tab9">Mails</a></li>
		<li><a href="#TC-93" id="Tab10" rel="logs_show.php">Logs</a></li>
		<li><a href="index.php?logout=true">Sign out</a></li>
	    </ul>
	
	    <div id="TC-10">
		<a href="users.php">List all</a> |
		<a href="users.php?action=new">Add new</a> |
		<a href="users.php?view=active">Active'.$usersActive.'</a> |
		<a href="users.php?view=disabled">Disabled'.$usersPending.'</a> |
		<a href="users.php?view=pending">Pending'.$usersDisabled.'</a> |
		<a href="users.php?view=trades2">2+ trades'.$usersTrades2.'</a> |
		<a href="users.php?view=trades1">1 trade'.$usersTrades1.'</a> |
		<a href="users.php?view=trades0">0 trades'.$usersTrades0.'</a>
	    </div>
			
	    <div id="TC-50">
		<a href="trades.php?action=new_buy">New BUY order</a> | 
		<a href="trades.php?action=list_open">New SELL order</a> | 
		<a href="trades.php">View all orders</a>
	    </div>
		
		<div id="TC-60">
		<a href="strades.php?action=new_buy">New BUY order</a> | 
		<a href="strades.php?action=list_open">New SELL order</a> | 
		<a href="strades.php?action=new_short">New SHORT order</a> | 
		<a href="strades.php?action=new_cover">New COVER order</a> | 
		<a href="strades.php">View all orders</a>
		</div>
		
		<div id="TC-65">
		<a href="stocks.php?action=new_value">Add New Values</a> | 
		<a href="stocks.php?action=list_dates">Edit Values</a> | 
		<a href="stocks_edit.php">Edit All Values</a> | 
		<a href="stocks.php?action=new_stock">Add New Stock</a> | 
		<a href="stocks.php">List all stocks</a> | 
		<a href="stocks.php?action=force_update">Force Update Values</a>
		</div>
			
	    <div id="TC-70">
		<a href="transfers.php?action=new_deposit">Add new Deposit</a> | 
		<a href="transfers.php?action=new_withdraw">Add new Withdraw</a> | 
		<a href="transfers.php">View all transfers</a>
	    </div>
		
	    <div id="TC-85">
		<a href="users_advisors.php">List all</a> | 
		<a href="users_advisors.php?action=new">Add new</a>
	    </div>
	    
	    <div id="TC-93">
			<a href="logs_show.php">Overview</a> 
	    </div>';
    
    if ($adminType == 'owner') {
        echo '
            <div id="TC-80">
                <a href="settings_css.php">CSS Styles</a> | 
                <a href="settings_translations.php">Translations</a> |
                <a href="commodities.php">Commodities</a> | 
                <a href="commodities_groups.php">Commodities - groups</a> | 
                <a href="expiry_dates.php">Commodities - exp. dates</a> |
                <a href="settings_pdf.php">PDF Settings</a> |
                <a href="pdf_templates.php">PDF Templates</a>
            </div>

            <div id="TC-81">
                <a href="settings_header_front.php">Custom Header</a> | 
                <a href="settings_footer_front.php">Custom Footer</a> | 
                <a href="settings_css_front.php">CSS Styles</a> | 
                <a href="settings_translations_front.php">Translations</a> |
                <a href="settings_deposit_text.php">Deposit\'s Text</a> |
                <a href="settings_other.php">Other settings</a> 
            </div>
            
            <div id="TC-90">
                <a href="users_admins.php">List all</a> | 
                <a href="users_admins.php?action=new">Add new</a>
            </div>

            <div id="TC-92">
                <a href="mails_smtp_settings.php">Mail Settings</a> | 
                <a href="mails_templates.php">Templates</a> |
                <a href="mails_assigns.php">Mail Assigns</a> |  
                <a href="mails_mass.php">Mass mail</a> | 
                <a href="mails_outbox.php">Outbox Queue'.$mailsToSend.'</a>
            </div>
        ';
    }
    
    echo '
	</div>
    </div>';
    
    	}
	echo '
    <div class="MainContainer">';
    }else{
	$db=new DBConnection();

	$UserIP=GetHostByName($_SERVER["REMOTE_ADDR"]);
	$query='SELECT banned_ips_id FROM banned_ips WHERE banned_ip="'.$UserIP.'" LIMIT 1';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	$db->close();
	if($num_rows>0) {
	    echo '<div class="LoginContainer"><h3>'.getLang('lform_publicbanmessage').'</h3></div>';
	}else{
	    echo '
	<div class="LoginContainer">
	    <h3>'.getLang('aform_title').'</h3>
	    '.((array_get($_GET, 'error') == 1)?'<div class="errorsHolder">Invalid username or password</div>':'').'
	    <form name="login_form" method="post">
		<div style="float:left;">
		    <div class="labels">'.getLang('lform_username').':</div><br />
		    <div class="labels">'.getLang('lform_password').':</div>
		</div>

		<div style="float:left;">
		    <input type="text" name="l_username" class="tinputs"><br />
		    <input type="password" name="l_password" class="tinputs">
		</div>
        
        <input type="hidden" id="nonce" name="nonce" value="'. ulNonce::Create('login') .'" />

		<br />
		<input type="submit" name="_login" class="submitBtn" value="'.getLang('lform_submitbtn').'">
	    </form>';
	}
    }
}

function page_header_simple(){
    $PageTitle=getLang('atitle_notlogged');

    echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>'.$PageTitle.'</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="content-language" content="en" />
<meta name="language" content="en" />
<meta http-equiv="refresh" content="3;url=users.php" />
<link href="css/styles.css" media="screen" rel="stylesheet" type="text/css" />
</head>
	
<body>
<div class="wrapper" id="top">
    <div class="LoginContainer">';
}

function page_footer(){
    echo '
    </div>
</div>

<div style="clear: both;"></div>
</body>
</html>';
}
?>