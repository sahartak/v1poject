<?php
	if(!isset($active)) {
		$active = '';
	}
?>
<aside>
	<div id="sidebar" class="nav-collapse">
		<!-- sidebar menu start-->
		<div class="leftside-navigation">
			<ul class="sidebar-menu" id="nav-accordion">
				<li>
					<a href="index.php" <?php if($active == 'index') echo 'class="active"'?>>
						<i class="fa fa-home"></i>
						<span><?php echo getLang('menu_home')?></span>
					</a>
				</li>
				<li>
					<a href="holdings.php" <?php if($active == 'holdings') echo 'class="active"'?>>
						<i class="fa fa-suitcase"></i>
						<span><?php echo getLang('menu_holdings')?></span>
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-list-alt"></i>
						<span><?php echo getLang('menu_charts')?></span>
					</a>
				</li>
				<li>
					<a href="history.php" <?php if($active == 'history') echo 'class="active"'?>>
						<i class="fa fa-book"></i>
						<span><?php echo getLang('menu_history')?></span>
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-money"></i>
						<span><?php echo getLang('menu_deposit')?></span>
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-dollar"></i>
						<span><?php echo getLang('menu_withdraw')?></span>
					</a>
				</li>
				<li>
					<a href="account.php" <?php if($active == 'account') echo 'class="active"'?>>
						<i class="fa fa-user"></i>
						<span><?php echo getLang('menu_details')?></span>
					</a>
				</li>
			</ul></div>
		<!-- sidebar menu end-->
	</div>
</aside>
<!--sidebar end-->

<section id="main-content">
	<section class="wrapper">
		<!-- page start-->

		<div class="row">
			<div class="col-sm-12">