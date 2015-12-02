<?php

require_once ('template.php');
page_header(6);?>
<script>
  $(function() {
    $( ".datepicker2" ).datepicker({
    	dateFormat:"yy-mm-dd",
    	goCurrent:true
    });
  });
  </script>


<?php if (isset($_POST['_add_withdraw'])){

	$db=new DBConnection();

	$mysql_fields='';

	$comma='';

	$count=0;

	foreach ($_POST as $k=>$x){

		if ($k!='depid'&&$k!='_submit'&&$k!='_add_withdraw'&&$k!='k'){

			if ($count!=0) $comma=', ';

			

			if ($k=='tr_value'||$k=='tr_fees'||$k=='tr_total') $x=str_replace(',', '', $x);

			

			$mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';

			$count++ ;

		}

	}

	

	$query='SELECT user_balance FROM users WHERE user_account_num='.($_SESSION['user']['user_account_num']+0).'';

	$res=$db->rq($query);

	$row=$db->fetch($res);

	$fixPostTotal=str_replace(',', '', $_POST['tr_total']);

	if ($row['user_balance']>=$fixPostTotal){

		$tradeRef=hexdec(substr(uniqid(''), 4, 13))-505050505;

		$query='INSERT INTO transfers SET '.$mysql_fields.', tr_type=2, transfers_id="'.NID.'", tr_ref='.($tradeRef+0).', tr_system_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'", 

	tr_status=2, user_account_num='.($_SESSION['user']['user_account_num']+0).'';

		$db->rq($query);

		

		addLog('Front-end', 'Withdraw', ''.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].' ('.$_SESSION['user']['user_account_num'].')', 0, 'Users request withdraw '.($tradeRef+0));

		

		$db->close();

		

		
	$success=true;
	$message=getLang('rw_sent');

	}else{

		

	$success=false;
	$message=getLang('rw_sent');

	}

}





if ($_SESSION['user']['is_logged']==1){

	echo '<div class="flat_area grid_16" style="opacity: 1;">
    <h2>'.getLang('rw_head').'
        </h2>
    </div>';
    $pcontent='<div class="col_100">';

			if(isset($message) and $message)
			{
				$pcontent.= "<div class='alert dismissible alert_green' ><div class='section'>";
				$pcontent.= '<p>'.$message.'</p>';
				$pcontent.= "</div></div>";

			}

			if(isset($message) and $message==false)
			{
				$pcontent.= "<div class='alert dismissible alert_red' ><div class='section'>";
				$pcontent.= '<p>'.$message.'</p>';
				$pcontent.= "</div></div>";
			}

			$pcontent.='</div>';
	$db=new DBConnection();

	$JSCripts=' onkeyup="setDetails();" onchange="setDetails();"';

	

	$query='SELECT user_balance, user_bank_online,user_bank_beneficiary,user_bank_address,user_bank_account,user_bank_name,user_bank_codetype,user_bank_code,

		user_bank_moredetails FROM users WHERE user_account_num="'.($_SESSION['user']['user_account_num']+0).'"';

	$res=$db->rq($query);

	$row=$db->fetch($res);

	foreach ($row as $Column=>$ColumnValue){

		$fixColumnName=str_replace('user_', 'tr_', $Column);

		$_POST[$fixColumnName]=$ColumnValue;

	}

	

	if ($_POST['tr_fees']=='') $_POST['tr_fees']='0.00';

	if ($_POST['trade_date']=='') $_POST['trade_date']=date('Y-m-d', CUSTOMTIME);

	

	$currentBalance=$row['user_balance'];

	$PendingMoney='';

	$query2='SELECT SUM(tr_total) AS total_pending FROM transfers WHERE tr_status=2 AND user_account_num="'.($_SESSION['user']['user_account_num']+0).'"';

	$res2=$db->rq($query2);

	$row2=$db->fetch($res2);

	if($row2['total_pending']>0) {

		$PendingMoney='<br />($'.$row2['total_pending'].' '.getLang('rw_in_pending').')';

		$currentBalance=$row['user_balance'];

	}

	

	if ($currentBalance<0){

		$currentBalance=number_format($currentBalance, 2);

		$currentBalance=str_replace('-', '-$', $currentBalance);

		$currentBalance='<span class="errors">'.$currentBalance.'</span>';

	}else{

		$currentBalance='<span class="positive">$'.number_format($currentBalance, 2).'</span>';

	}

	

	global $depositOptions;

	$userBankCodeTypes=array(1=>'SWIFT Code', 2=>'IBAN Code', 3=>'ABA #', 4=>'BSC Code');

	$date_today=isset($_POST['tr_date'])?$_POST['tr_date']:date('Y-m-d');

	// $pcontent='';

	$pcontent.='

<div class="box grid_16 no_titlebar">

<!--<script type="text/javascript" src="js/jquery.validate.js"></script>-->

<script type="text/javascript" src="js/forms/transfersWithdraw.js"></script>


	<form name="requestNewWithdraw" method="POST" class="" id="MainForms">
		<div class="container_16">
			<div class="grid_8">
				<h2 class="section">'.getLang('bank_details').'</h2>
				<fieldset class="label_side top">
						<label for="tr_bank_beneficiary">'.getLang('bank_benef').'</label>
						<div class="clearfix">
							<!--<input class="required" type="text" name="tr_bank_beneficiary" id="tr_bank_beneficiary" value="'.$_POST['tr_bank_beneficiary'].'" />-->
							<span>'.$_POST['tr_bank_beneficiary'].'</span>
						</div>
					</fieldset>

				<fieldset class="label_side top">
						<label for="tr_bank_name">'.getLang('bank_name').'</label>
						<div class="clearfix">
							<!--<input class="required" type="text" name="tr_bank_name" id="tr_bank_name" value="'.$_POST['tr_bank_name'].'" />-->
							'.$_POST['tr_bank_name'].'
							
						</div>
					</fieldset>

				<fieldset class="label_side top">
						<label for="tr_bank_address">'.getLang('bank_address').'</label>
						<div class="clearfix">
							<!--<textarea id="tr_bank_address" name="tr_bank_address" class="autogrow">'.$_POST['tr_bank_address'].'</textarea>-->
							'.$_POST['tr_bank_address'].'

						</div>
					</fieldset>
				<fieldset class="label_side top">
						<label for="tr_bank_account">'.getLang('bank_acc').'</label>
						<div class="clearfix">
							<!--<input class="required" type="text" name="tr_bank_account" id="tr_bank_account" value="'.$_POST['tr_bank_account'].'" />-->
							<p>'.$_POST['tr_bank_account'].'</p>
							<p>'.$_POST['tr_bank_codetype'].'</p>

							<!--<select name="tr_bank_codetype" class="select-medium uniform fullwidth">';

							foreach ($userBankCodeTypes as $BankCodeID=>$BankCodeType){

								$pcontent.='<option value="'.$BankCodeID.'"'.(($BankCodeID==$_POST['tr_bank_codetype'])?' selected':'').'>'.$BankCodeType.'</option>';

							}

							

							$pcontent.='

								</select>-->
								<p>'.$_POST['tr_bank_code'].'</p>
							<!--<input class="text-input" type="text" name="tr_bank_code" id="tr_bank_code" value="'.$_POST['tr_bank_code'].'" />-->

						</div>
					</fieldset>

					<fieldset class="label_side top">
						<label for="tr_bank_moredetails">'.getLang('bank_more').'</label>
						<div class="clearfix">
							<!--<textarea id="tr_bank_moredetails" name="tr_bank_moredetails" class="autogrow">'.$_POST['tr_bank_moredetails'].'</textarea>-->
							<p>'.$_POST['tr_bank_moredetails'].'</p>

						</div>
					</fieldset>
			</div>

			<div class="grid_8">
				<h2 class="section">Transfer</h2>
				<fieldset class="label_side top">
					<label for="tr_bank_moredetails">'.getLang('rw_balance').'</label>
					<div class="clearfix">
						'.$currentBalance.' '.$PendingMoney.'
					</div>
				</fieldset>

				<fieldset class="label_side top">
					<label for="tr_value">'.getLang('rw_withdrawal').'</label>
					<div class="clearfix">
						<input  class="required" onkeyup="setDetails();" onchange="setDetails();" type="text" name="tr_value" id="tr_value" value="'.$_POST['tr_value'].'" />
						

					</div>
				</fieldset>
			
			<fieldset class="label_side top">
					<label for="tr_fees">'.getLang('rw_fees').'</label>
					<div class="clearfix">
						<input  onkeyup="setDetails();" onchange="setDetails();" type="text" name="tr_fees" id="tr_fees" value="'.$_POST['tr_fees'].'" />
						
						
					</div>
				</fieldset>

		<fieldset class="label_side top">
					<label for="tr_total">'.getLang('rw_totalw').'</label>
					<div class="clearfix">
						<input  type="text" name="tr_total" id="tr_total" value="'.$_POST['tr_total'].'" />
						

					</div>
				</fieldset>

			

			<fieldset class="label_side top">
					<label for="tr_date">'.getLang('rw_valdate').'</label>
					<div class="clearfix">
						<input class="required datepicker2" type="text" name="tr_date" id="rw_valdate" value="'.$date_today.'" />
						

					</div>
				</fieldset>

			<fieldset class="label_side top">
					<label for="tr_notes">'.getLang('rw_notes_head').'</label>
					<div class="clearfix">
						<textarea id="tr_notes" name="tr_notes" class="autogrow">'.$_POST['tr_notes'].'</textarea>
						

					</div>
				</fieldset>	
			</div>
			
	<div class="button_bar clearfix">
		<input type="submit" name="_add_withdraw" value="'.getLang('rw_btnRequest').'" class="button green" />
		<input type="button" name="_cancel" value="'.getLang('rw_btnReload').'" class="button green" onclick="location=\'withdraw.php\';" />

	</div>
	<div class="block" style="opacity: 1;">
		<div class="section">
			<div class="alert alert_light">
			'.getLang('rw_notes').'
			</div>
			
		</div>
	</div>
	
	</div><!--End container_16-->
</form>

</div>';

	$db->close();

	

	echo $pcontent;

}



page_footer();

?>
<style>
.positive
{
	color: #393;
	font-weight: bold;
}
fieldset.label_side div
{
	line-height: 16px;
}

</style>