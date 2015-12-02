<div id="nav_top" class="dropdown_menu clearfix round_top">
	<ul class="clearfix">		
	
		<li><a class="<?php echo $SelectedTab==1?'current':'' ?> pjax" href="index.php" ><img src="adminica/images/icons/small/grey/home.png"/> <span><?php echo getLang('menu_home')?></span></a></li>

		<?php if($username['trading_type']==2 || $username['trading_type']==3){?>
			<!-- Stocks Summary  <li><a class="pjax" href="stocks.php" class="pjax"><span><?php echo getLang('menu_stocks')?></span></a></li>
			 -->
			<li><a class="pjax" href="holdings.php" class="pjax"><span><?php echo getLang('menu_holdings')?></span></a></li>
			
		<?php	}?>
		<li><a class="pjax" href="charts.php"><span><?php echo getLang('menu_charts')?></span></a></li>
		<li><a class="pjax" href="history.php"><span><?php echo getLang('menu_history')?></span></a></li>
		<li><a class="pjax" href="deposit.php"><span><?php echo getLang('menu_deposit')?></span></a></li>
		<li><a class="pjax" href="withdraw.php"><span><?php echo getLang('menu_withdraw')?></span></a></li>
		<li><a class="pjax" href="account.php"><span><?php echo getLang('menu_details')?></span></a></li>
		

		<?php
		if($_SESSION['admin']['is_logged']==1) {
    		echo '<li class="pjax><a href="logview.php">'.getLang('menu_logs').'</a></li>';
    	}?>
		
		<li class="small light send_right div_icon has_text" style="float:right;margin-right: -1px" >
            <a href="#" title="Print this page" onclick="window.print()" style="padding: 0px 8px">
                <span class="ui-icon ui-icon-print" style="padding:0px;margin: 8px 0px"></span>
            </a>
        </li>

	</ul>

	<div id="mobile_nav">
		<div class="main"></div>
		<div class="side"></div>
	</div>

</div><!-- #nav_top -->
