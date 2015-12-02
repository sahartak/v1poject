 <div id="wrapper" data-adminica-nav-top="<?php echo $SelectedTab ?>" data-adminica-side-top="<?php echo $SelectedTab ?>">

	 <!-- <div id="header">

	 	<div id="logo"></div>

	 	<div id="sitename">

	 		<h1><a href="index.php"><?php echo getLang('site_name'); ?></a></h1>

	 		<h3><?php echo getLang('site_subhead'); ?></h3>

	 	</div>

	 	

	 </div> -->
	 <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']){?>
	 <?php if(isset($_SESSION['user']) && $_SESSION['user']['dosuuser']){?>
	 <div id="topbar" class="clearfix" style="display: none;">
	 <?php }else{ ?>
	 <div id="topbar" class="clearfix">
	 <?php }?>



		<a href="index.php" class="logo"><span><?php echo getLang('site_name'); ?></span></a>



		<?php

		if($_SESSION['user']['is_logged']==1) {

    	

    	//by ahmetsali - login information

    	$db=new DBConnection();

    	$query='SELECT user_firstname, trading_type,user_lastname,user_account_num FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';

    	$res=$db->rq($query);
        global $username;
    	$username=$db->fetch($res);

    	$userProfile = '';

    

    	//echo '<div id="logged"><span id="welcome">'.getLang('site_welcome').'</span><br/> <span id="username"><a href="account.php">'.$username[user_account_name].'</a></span><br/> <a class="signout" href="index.php?logout=true">'.getLang('site_signout').'</a></div>';;

    	//end login information

    	?>
	
		<div class="user_box dark_box clearfix">
<!-- change login icon  <i class="fa fa-user fa-2x"></i> -->
			<img src="adminica/images/icons/large/white/globe.png" width="55" alt="Logo Pic" />

			<h2><?php echo getLang('site_welcome')?></h2>

			<h3><a class="text_shadow" ><?php echo array_get($username, 'user_firstname'); ?></a></h3>
        
			<ul>

				<!-- <li><a href="#">profile</a><span class="divider">|</span></li>

				<li><a href="#">settings</a><span class="divider">|</span></li> -->

				<li><a href="index.php?logout=true" ><?php echo getLang('site_signout')?></a></li>

			</ul>

		</div><!-- #user_box -->
        <div class="clear"></div>
<!--        <div class="" style="margin-right: 9px;">-->
<!--            <button class="small light send_right div_icon has_text" onclick="window.print()">-->
<!--                <div class="ui-icon ui-icon-print"></div>-->
<!--                <span>Print this page</span>-->
<!--            </button>-->
<!--        </div>-->

		<?php }?>



	</div><!-- #topbar -->


	<?php
		include 'adminica/includes/components/stackbar.php';

	} ?>






	  			