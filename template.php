<?php
require 'vendor/autoload.php';

define('PROJECT_PATH', dirname(__FILE__) . '/');
define('SRC_PATH', PROJECT_PATH . 'src/');

require_once('common.php');

//*********EDIT
//this line written by ahmetsali, to prevent unwanted notice messages!
error_reporting(E_ALL ^ E_NOTICE);
//****************

function page_header($SelectedTab=0){
    if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1) {
    $PageTitle=getLang('ptitle_logged');
    }else{
    $PageTitle=getLang('ptitle_notlogged');
    }

    echo '<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en-us" class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html lang="en-us" class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html lang="en-us" class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html lang="en-us" class="no-js ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us" class="no-js"> <!--<![endif]-->
<head>
<title>'.$PageTitle.'</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="X-UA-Compatible" content="IE=100" />
<meta http-equiv="content-language" content="en" />
<meta name="language" content="en" />
';

    $db = new DBConnection();
    $settings = new App\Model\Settings($db);

    $segmentKey = $settings->get('segment_write_key', '7thysyub7i');

    echo '
    <link href="adminica/styles/adminica/reset.css" media="all" rel="stylesheet" type="text/css" />
    <link href="adminica/styles/plugins/all/plugins.css" media="all" rel="stylesheet" type="text/css" />
    <link href="adminica/styles/adminica/all.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="adminica/styles/themes/layout_switcher.php?default=layout_fixed.css" >
    <link rel="stylesheet" href="adminica/styles/themes/nav_switcher.php?default=nav_top.css" >
    <link rel="stylesheet" href="adminica/styles/themes/skin_switcher.php?default=skin_light.css" >
    <link rel="stylesheet" href="adminica/styles/themes/theme_switcher.php?default=theme_blue.css" >
    <link rel="stylesheet" href="adminica/styles/themes/bg_switcher.php?default=bg_white_wall.css" >
    <link rel="stylesheet" href="adminica/styles/adminica/colours.css">
    <link rel="stylesheet" href="css/custom.css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">




<script type="text/javascript" src="adminica/scripts/plugins-min.js"></script>
<script type="text/javascript" src="adminica/scripts/adminica/adminica_all-min.js"></script>

<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>-->
<script type="text/javascript" src="js/underscore-min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
    window.analytics||(window.analytics=[]),window.analytics.methods=["identify","track","trackLink","trackForm","trackClick","trackSubmit","page","pageview","ab","alias","ready","group","on","once","off"],window.analytics.factory=function(t){return function(){var a=Array.prototype.slice.call(arguments);return a.unshift(t),window.analytics.push(a),window.analytics}};for(var i=0;window.analytics.methods.length>i;i++){var method=window.analytics.methods[i];window.analytics[method]=window.analytics.factory(method)}window.analytics.load=function(t){var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=("https:"===document.location.protocol?"https://":"http://")+"d2dq2ahtl5zl1z.cloudfront.net/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(a,n)},window.analytics.SNIPPET_VERSION="2.0.8",
    window.analytics.load("' . $segmentKey . '");
    window.analytics.page();
</script>
';

    if($SelectedTab==2) {
        echo '
        <link href="css/jquery.jqplot.css" media="all" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/excanvas.min.js"></script>
        <script type="text/javascript" src="js/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.dateAxisRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.canvasTextRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.barRenderer.js"></script>
        ';
    }
    echo '
    <style>
    .xLabel
    {
        display: inline-block;
        width: 50%;
    }
    .errors{
        color:#900;
    }
    .r_left
    {
        float:left;
    }
    .grid_50
    {
        line-height:16px;
    }
    </style>
</head>

<body>
<div id="pjax">';
include('includes/custom_header.php'); 
    if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1)
    {
         echo '<div id="main_container" class="main_container container_16 clearfix">';
                include 'adminica/includes/components/navigation.php';
    }
    else   
    {
        $db=new DBConnection();

        $UserIP=GetHostByName($_SERVER["REMOTE_ADDR"]);
        $query='SELECT banned_ips_id FROM banned_ips WHERE banned_ip="'.$UserIP.'" LIMIT 1';
        $res=$db->rq($query);
        $num_rows=$db->num_rows($res);      
        
        $db->close();
        if($num_rows>0) {
            echo '</div><div class="LoginContainer"><h3>'.getLang('lform_publicbanmessage').'</h3></div>';
        }else{
            include('parts/login_box.php');
        
        }
    }            
 } 

function page_header_simple($redirect=0){
   if($_SESSION['user']['is_logged']==1) {
    $PageTitle=getLang('ptitle_logged');
    }else{
    $PageTitle=getLang('ptitle_notlogged');
    }

    echo '<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en-us" class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html lang="en-us" class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html lang="en-us" class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html lang="en-us" class="no-js ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us" class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>'.$PageTitle.'</title>
<meta http-equiv="content-type" content="application/xhtml+xml" />
<meta http-equiv="X-UA-Compatible" content="IE=100" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1;">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />


';
    
    echo '
    <link href="adminica/styles/adminica/reset.css" media="all" rel="stylesheet" type="text/css" />
    <link href="adminica/styles/plugins/all/plugins.css" media="all" rel="stylesheet" type="text/css" />
    <link href="adminica/styles/adminica/all.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="adminica/styles/themes/layout_switcher.php?default=layout_fixed.css" >
    <link rel="stylesheet" href="adminica/styles/themes/nav_switcher.php?default=nav_top.css" >
    <link rel="stylesheet" href="adminica/styles/themes/skin_switcher.php?default=skin_light.css" >
    <link rel="stylesheet" href="adminica/styles/themes/theme_switcher.php?default=theme_blue.css" >
    <link rel="stylesheet" href="adminica/styles/themes/bg_switcher.php?default=bg_white_wall.css" >
    <link rel="stylesheet" href="adminica/styles/adminica/colours.css">
    <link rel="stylesheet" href="css/custom.css">

<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

<link href="css/validationEngine.jquery.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="adminica/scripts/plugins-min.js"></script>
<script type="text/javascript" src="adminica/scripts/adminica/adminica_all-min.js"></script>

<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>-->
<script type="text/javascript" src="js/scripts.js"></script>';
    
    if($SelectedTab==2) {
        echo '
        <link href="css/jquery.jqplot.css" media="all" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/excanvas.min.js"></script>
        <script type="text/javascript" src="js/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.dateAxisRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.canvasTextRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="js/plugins/jqplot.barRenderer.js"></script>
        ';
    }
    echo '
    <style>
    .xLabel
    {
        display: inline-block;
        width: 50%;
    }
    

    </style>
</head>

<body>
<div id="pjax">';
include('includes/custom_header.php'); 
    if($_SESSION['user']['is_logged']==1)
    {
         echo '<div id="main_container" class="main_container container_16 clearfix">';
                include 'adminica/includes/components/navigation.php';
    }
    else   
    {
        $db=new DBConnection();

        $UserIP=GetHostByName($_SERVER["REMOTE_ADDR"]);
        $query='SELECT banned_ips_id FROM banned_ips WHERE banned_ip="'.$UserIP.'" LIMIT 1';
        $res=$db->rq($query);
        $num_rows=$db->num_rows($res);      
        
        $db->close();
        if($num_rows>0) {
            echo '</div><div class="LoginContainer"><h3>'.getLang('lform_publicbanmessage').'</h3></div>';
        }else{
            //include('parts/login_box.php');
        
        }
    }          
}

function page_footer($wait=0){
    echo "</div>";
    
    if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1):
    	if(isset($_SESSION['user']) && $_SESSION['user']['dosuuser']){
        	echo '<div class="main_container container_16 clearfix ui-sortable" style="display: none;">';
    	}else{
    		echo '<div class="main_container container_16 clearfix ui-sortable">';
    	}
        //echo "<div class='grid_16'><div class='isotope_holder indented_area'>";
        include('includes/custom_footer.php');
        //echo "</div></div>";
        echo "</div>";
    endif;
    echo '
    
    <div class="clear"></div>';

    /*
    if($_SESSION['admin']['is_logged']==1&&$_SESSION['user']['is_logged']==1&&$wait!=1) {
    echo '
    <div class="TabsHolder clear">
        <br />
        <div class="ui-state-error bold" style="width:780px; padding:5px; text-align: center;">
        Shortcuts for admins only
    </div>
    <div id="AdminsTabs">
        <div class="topMenu ui-state-default"><a href="/'.getLang('site_admin_folder').'/trades_noheader.php?action=new_buy&uid='.$_SESSION['user']['user_account_num'].'&noheader=1">Add Buy Trade</a></div>
        <div class="topMenu ui-state-default"><a href="/'.getLang('site_admin_folder').'/trades_noheader.php?action=list_open&noheader=1">Add Sell Trade</a></div>
        <div class="topMenu ui-state-default"><a href="/'.getLang('site_admin_folder').'/transfers_noheader.php?action=new_deposit&uid='.$_SESSION['user']['user_account_num'].'&noheader=1">Add Deposit</a></div>
        <div class="topMenu ui-state-default"><a href="/'.getLang('site_admin_folder').'/transfers_noheader.php?action=new_withdraw&uid='.$_SESSION['user']['user_account_num'].'&noheader=1">Add Withdraw</a></div>
        <div class="topMenu ui-state-default"><a href="/'.getLang('site_admin_folder').'/mails_singleuser.php?uid='.$_SESSION['user']['user_account_num'].'&noheader=1">Send mail</a></div>
        <div class="topMenu ui-state-default"><a href="logview.php">User Logs</a></div>
    </div>
    </div>';
    }
    */

/* bottom bar to show template options edit this
    include('adminica/includes/components/template_options.php');
 */

echo '
</body>
</html>';
}
?>