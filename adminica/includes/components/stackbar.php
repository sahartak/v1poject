<div id="stackbar" class="stackbar">	
	<div class="user_box dark_box clearfix">
		<!-- change login icon -->
		<img src="adminica/images/icons/large/grey/globe.png" width="55" alt="Profile Pic" />
		<h2><?php echo getLang('site_welcome')?></h2>
		<h3><a class="text_shadow" ><?php echo $username[user_account_name]?></a></h3>
		<ul>
				<li><a href="index.php?logout=true" ><?php echo getLang('site_signout')?></a></li>
		</ul>
	</div>
	<ul class="">
		<li>
			<a href="index.php"><img src="adminica/images/icons/large/grey/home.png"/><span><?php echo getLang('menu_home')?></span></a>
			
		</li>
		<?php if($username['trading_type']==2 || $username['trading_type']==3){?>

			<li><a  href="stocks.php" ><span><?php echo getLang('menu_stocks')?></span></a></li>
			<li><a  href="holdings.php" ><span><?php echo getLang('menu_holdings')?></span></a></li>
			<li><a  href="charts.php" ><span><?php echo getLang('menu_charts')?></span></a></li>
		<?php	}?>
		<li><a href="history.php" ><span><?php echo getLang('menu_history')?></span></a></li>
		<li><a  href="deposit.php" ><span><?php echo getLang('menu_deposit')?></span></a></li>
		<li><a  href="withdraw.php" ><span><?php echo getLang('menu_withdraw')?></span></a></li>
		<li><a  href="account.php" ><span><?php echo getLang('menu_details')?></span></a></li>
		<?php
		if($_SESSION['admin']['is_logged']==1) {
    		echo '<li class="pjax><a href="logview.php">'.getLang('menu_logs').'</a></li>';
    	}?>
	</ul>
</div>

