<div class="isolate">
	<div class="center narrow">
		<div class="main_container full_size container_16 clearfix">
			<div class="box">
				<div class="block">
					<div class="section">
						<div class="alert dismissible alert_light">
							<img width="24" height="24" src="adminica/images/icons/small/grey/locked.png">
							<strong><?php echo getLang('rform_title')?></strong>
						</div>
						<?php if(isset($message) and $message){?>
						<div class="alert dismissible alert_red error">
							<?php echo $message ?>
						</div>
						<?php }?>
					</div>
					<form name="login_form" method="post">
					<fieldset class="label_side top">
						<label for="rform_email"><?php echo getLang('rform_email')?>:</label>
						<div>
							<input type="hidden" name="_reqpass" value="1">
							<input type="text" id="rform_email" name="rform_email" class="rform_email">
						</div>aa
					</fieldset>
					
					<div class="button_bar clearfix">
						<button class="wide" type="submit">
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