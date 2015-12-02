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
						
						<div class="alert dismissible error">

						    <?php echo getLang('reset_secret_title') ?>

						</div>

						<?php if(isset($message) and $message){?>
						<div class="alert dismissible alert_red error">
							<?php echo $message ?>
						</div>
						<?php }?>
					</div>
					<form name="login_form" method="post">
					<fieldset class="label_side top">
						<label for="rform_answer"><?php echo $SecretQuestion?>?</label>
						<div>
							<input type="text" id="rform_answer" name="rform_answer" class="rform_answer">
						</div>
					</fieldset>
					
					<div class="button_bar clearfix">
					<input type="hidden" name="rform_email" value="<?php echo $_POST['rform_email']; ?>"><br />

					<input type="hidden" name="_pwdreset1" value="1">
						<button class="wide" type="submit">
							<img src="adminica/images/icons/small/white/key_2.png">
							
							<span>Submit</span>
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