<?php
//by ahmetsali - login information

    	$db=new DBConnection();

    	$query='SELECT user_account_name, trading_type FROM users WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" LIMIT 1';

    	$res=$db->rq($query);

    	$username=$db->fetch($res);

    	$userProfile = '';?>
<div id="sidebar" class="sidebar pjax_links">
	<div class="cog">+</div>

	<a href="index.php" class="logo"><span>Adminica</span></a>

	<div class="user_box dark_box clearfix">
		<img src="adminica/images/interface/profile.jpg" width="55" alt="Profile Pic" />
		<h2><?php echo getLang('site_welcome')?></h2>
		<h3><a class="text_shadow" ><?php echo $username[user_account_name]?></a></h3>
		<ul>

				<!-- <li><a href="#">profile</a><span class="divider">|</span></li>

				<li><a href="#">settings</a><span class="divider">|</span></li> -->

				<li><a href="index.php?logout=true" ><?php echo getLang('site_signout')?></a></li>

			</ul>
	</div><!-- #user_box -->

	<ul class="side_accordion" id="nav_side"> <!-- add class 'open_multiple' to change to from accordion to toggles -->
		<li class="icon_only"><a class="<?php echo $SelectedTab==1?'current':'' ?> pjax" href="index.php" ><img src="adminica/images/icons/small/grey/home.png"/> <span><?php echo getLang('menu_home')?></span></a></li>

		<?php if($username['trading_type']==2 || $username['trading_type']==3){?>

			<li><a class="pjax" href="stocks.php" class="pjax"><span><?php echo getLang('menu_stocks')?></span></a></li>
			<li><a class="pjax" href="holdings.php" class="pjax"><span><?php echo getLang('menu_holdings')?></span></a></li>
		<?php	}?>
		<li><a class=" pjax" href="history.php" class="pjax"><span><?php echo getLang('menu_history')?></span></a></li>
		<li><a class="pjax" href="deposit.php" class="pjax"><span><?php echo getLang('menu_deposit')?></span></a></li>
		<li><a class=" pjax" href="withdraw.php" class="pjax"><span><?php echo getLang('menu_withdraw')?></span></a></li>
		<li><a class=" pjax" href="account.php" ><span><?php echo getLang('menu_details')?></span></a></li>
		<?php
		if($_SESSION['admin']['is_logged']==1) {
    		echo '<li class="pjax><a href="logview.php">'.getLang('menu_logs').'</a></li>';
    	}?>
	</ul>

	
</div><!-- #sidebar -->
