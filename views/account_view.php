<div class="col-md-12">
	<?php if(isset($_SESSION['account_details_msg'])):?>
		<div class="alert alert-success fade in">
			<button data-dismiss="alert" class="close close-sm" type="button">
				<i class="fa fa-times"></i>
			</button>
			<?php echo $_SESSION['account_details_msg']?>
		</div>
	<?php unset($_SESSION['account_details_msg']); endif;?>
	<section class="panel">
		<header class="panel-heading tab-bg-dark-navy-blue">
			<ul class="nav nav-tabs nav-justified ">
				<li class="active">
					<a data-toggle="tab" href="#account">
					   <?php echo getLang('acc_details') ?>
					</a>
				</li>
				<li>
					<a data-toggle="tab" href="#bank">
						<?php echo getLang('bank_details') ?>
					</a>
				</li>
				<li>
					<a data-toggle="tab" href="#private">
						<?php echo getLang('acc_private_set') ?>
					</a>
				</li>
			</ul>
		</header>
		<div class="panel-body">
			<div class="tab-content tasi-tab">

				<div id="account" class="tab-pane active">
					<div class="panel-body">
						<div class=" form">
							<form class="cmxform valid_form form-horizontal " method="post">
								<div class="form-group ">
									<label for="user_title" class="control-label col-lg-3"><?php echo getLang('acc_contact_title') ?></label>
									<div class="col-lg-6">
										<select name="user_title" class="form-control" required="required">
										<?php foreach ($userTitles as $TitleID=>$TitleName) {
											$selected='';
											if ($_POST['user_title']==$TitleID) $selected=' selected';
											echo '<option value="',$TitleID,'"',$selected,'>',$TitleName,'</option>';
										} ?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="user_firstname" class="control-label col-lg-3"><?php echo getLang('acc_contact_fname')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_firstname']?>" id="user_firstname" type="text" name="user_firstname" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_middlename" class="control-label col-lg-3"><?php echo getLang('acc_contact_mname')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_middlename']?>" id="user_middlename" type="text" name="user_middlename"  />
									</div>
								</div>

								<div class="form-group">
									<label for="user_lastname" class="control-label col-lg-3"><?php echo getLang('acc_contact_lname')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_lastname']?>" id="user_lastname" type="text" name="user_lastname" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_account_name" class="control-label col-lg-3"><?php echo getLang('acc_contact_full_name')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_account_name']?>" id="user_account_name" type="text" name="user_account_name" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_email" class="control-label col-lg-3"><?php echo getLang('acc_contact_email')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_email']?>" id="user_email" type="email" name="user_email" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_phone" class="control-label col-lg-3"><?php echo getLang('acc_contact_phone')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_phone']?>" id="user_phone" type="text" name="user_phone" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_mailing_address" class="control-label col-lg-3"><?php echo getLang('acc_contact_maddress')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_mailing_address']?>" id="user_mailing_address" type="text" name="user_mailing_address" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_postal" class="control-label col-lg-3"><?php echo getLang('acc_contact_zip')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_postal']?>" id="user_postal" type="text" name="user_postal" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_city" class="control-label col-lg-3"><?php echo getLang('acc_contact_city')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_city']?>" id="user_city" type="text" name="user_city" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_state" class="control-label col-lg-3"><?php echo getLang('acc_contact_state')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_state']?>" id="user_state" type="text" name="user_state" required />
									</div>
								</div>

								<div class="form-group ">
									<label for="user_country" class="control-label col-lg-3"><?php echo getLang('acc_contact_country') ?></label>
									<div class="col-lg-6">
										<select name="user_country" id="user_country" class="form-control" required="required">
											<?php foreach ($countries as $country) {
												$selected='';
												if ($_POST['user_country']==$country['country_full']) $selected=' selected';
												echo '<option value="'.$country['country_full'].'"'.$selected.'>'.$country['country_full'].'</option>';
											} ?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="user_fax" class="control-label col-lg-3"><?php echo getLang('acc_contact_fax')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_fax']?>" id="user_fax" type="text" name="user_fax"  />
									</div>
								</div>

								<div class="form-group">
									<label for="user_email2" class="control-label col-lg-3"><?php echo getLang('acc_contact_email2')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_email2']?>" id="user_email2" type="email" name="user_email2"  />
									</div>
								</div>

								<div class="form-group">
									<label for="user_company" class="control-label col-lg-3"><?php echo getLang('acc_contact_firm')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_company']?>" id="user_company" type="text" name="user_company"  />
									</div>
								</div>

								<div class="form-group">
									<label for="user_web" class="control-label col-lg-3"><?php echo getLang('acc_contact_web')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_web']?>" id="user_web" type="url" name="user_web"  />
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-6">
										<input type="submit" class="btn btn-primary" name="_form_submit" value="<?php echo getLang('sform_savebtn') ?>">
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>

				<div id="bank" class="tab-pane ">
					<div class="panel-body">
						<div class=" form">
							<form class="cmxform valid_form form-horizontal " method="post">

								<div class="form-group">
									<label for="user_bank_beneficiary" class="control-label col-lg-3"><?php echo getLang('bank_benef')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_bank_beneficiary']?>" id="user_bank_beneficiary" type="text" name="user_bank_beneficiary" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_bank_address" class="control-label col-lg-3"><?php echo getLang('bank_address')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_bank_address']?>" id="user_bank_address" type="text" name="user_bank_address" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_bank_account" class="control-label col-lg-3"><?php echo getLang('bank_acc')?></label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_bank_account']?>" id="user_bank_account" type="text" name="user_bank_account" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_bank_name" class="control-label col-lg-3"><?php echo getLang('bank_name') ?></label>
									<div class="col-lg-6">
										<input type="text" class="form-control" id="user_bank_name" name="user_bank_name" value="<?php echo $_POST['user_bank_name']?>" required="required">
									</div>
								</div>

								<div class="form-group">
									<label for="user_bank_codetype" class="control-label col-lg-3">Bank code type</label>
									<div class="col-lg-6">
										<select name="user_bank_codetype" id="user_bank_codetype" class="form-control" required="required">
											<?php
											foreach ($userBankCodeTypes as $BankCodeID=>$BankCodeType){
												echo '<option value="'.$BankCodeID.'"'.(($BankCodeID==$_POST['user_bank_codetype'])?' selected':'').'>'.$BankCodeType.'</option>';
											}
											?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="user_bank_code" class="control-label col-lg-3">Bank code</label>
									<div class="col-lg-6">
										<input class="form-control" value="<?php echo $_POST['user_bank_code']?>" id="user_bank_code" type="text" name="user_bank_code" required />
									</div>
								</div>

								<div class="form-group">
									<label for="user_bank_moredetails" class="control-label col-lg-3"><?php echo getLang('bank_more')?></label>
									<div class="col-lg-6">
										<textarea class="form-control" id="user_bank_moredetails" name="user_bank_moredetails"><?php echo $_POST['user_bank_moredetails']?></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-6">
										<input type="submit" class="btn btn-primary" name="_form_submit" value="<?php echo getLang('sform_savebtn') ?>">
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>

				<div id="private" class="tab-pane ">
					<div class="panel-body">
						<div class="form">
							<form class="cmxform form-horizontal" id="private_form" method="post">

								<div class="form-group">
									<label for="user_password" class="control-label col-lg-3"><?php echo getLang('acc_private_pass')?></label>
									<div class="col-lg-6">
										<input class="form-control" id="user_password" type="password" name="user_password" value=""  />
									</div>
								</div>

								<div class="form-group">
									<label for="user_password2" class="control-label col-lg-3"><?php echo getLang('acc_private_pass2')?></label>
									<div class="col-lg-6">
										<input class="form-control" id="user_password2" type="password" name="user_password2" value=""  />
									</div>
								</div>

								<div class="form-group">
									<label for="user_secret_question" class="control-label col-lg-3"><?php echo getLang('acc_private_quest')?></label>
									<div class="col-lg-6">
										<input class="form-control" id="user_secret_question" type="text" name="user_secret_question" value="<?php echo $_POST['user_secret_question']?>" required="required" />
									</div>
								</div>

								<div class="form-group">
									<label for="user_secret_answer" class="control-label col-lg-3"><?php echo getLang('acc_private_answ')?></label>
									<div class="col-lg-6">
										<input class="form-control" id="user_secret_answer" type="text" name="user_secret_answer" value="<?php echo $_POST['user_secret_answer']?>" required="required" />
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-6">
										<input type="submit" class="btn btn-primary" name="_form_submit" value="<?php echo getLang('sform_savebtn') ?>">
									</div>
								</div>

							</form>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
</div>