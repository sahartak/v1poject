<div class="isolate">
	<div class="center narrow">
		<div class="main_container full_size container_16 clearfix">
			<div class="box">
				<div class="block">
					<div class="section">
						<div class="alert dismissible alert_light">
							<img width="24" height="24" src="adminica/images/icons/small/grey/locked.png">
							<strong><?php echo getLang('lform_title')?></strong>
						</div>
						<?php if(isset($_GET['error']) and $_GET['error']==1){?>
						<div class="alert dismissible alert_light error">
							<?php echo getLang('lform_invalid') ?>
						</div>
						<?php }?>
					</div>
					<form action="" class="validate_form" method="post">
					<fieldset class="label_side top">
						<label for="l_username"><?php echo getLang('lform_username')?></label>
						<div>
							<input type="text" id="l_username" name="l_username" class="required">
						</div>
					</fieldset>
					<fieldset class="label_side bottom">
						<label for="l_password"><?php echo getLang('lform_password') ?><span><a href="pwdreset.php"><?php echo getLang('lform_forgotpword') ?></a></span></label>
						<div>
							<input type="password" id="l_password" name="l_password" class="required">
						</div>
					</fieldset>
					<div class="button_bar clearfix">
						<button class="btn" type="submit">
							<img src="adminica/images/icons/small/white/key_2.png">
							
							<span><?php echo getLang('lform_submitbtn') ?></span>
						</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		<a href="index.php" id="login_logo"><span>Adminica</span></a>
		<!-- <button data-dialog="dialog_register" class="dialog_button send_right" style="margin-top:10px;">
			<img src="images/icons/small/white/user.png">
			<span>Not Registered ?</span>
		</button> -->
	</div>