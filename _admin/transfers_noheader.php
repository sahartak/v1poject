<?php
require_once ('template.php');
if (!$_SESSION['admin']['is_logged']){
	header('Location: index.php');
	exit();
}
$_SESSION['admin']['selected_tab']=2;
unset($_SESSION['admin']['uedit']);

if (isset($_POST['_add_deposit'])){
	$db=new DBConnection();
	$mysql_fields='';
	$comma='';
	$count=0;
	foreach ($_POST as $k=>$x){
		if ($k!='trid'&&$k!='_submit'&&$k!='_add_deposit'&&$k!='k'){
			if ($count!=0) $comma=', ';
			
			if ($k=='tr_value'||$k=='tr_fees'||$k=='tr_total') $x=str_replace(',', '', $x);
			
			$mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';
			$count++ ;
		}
	}
	
	if ($_POST['trid']!=''){
		$getCurrentData=$db->getRow('transfers', 'tr_ref="'.$_POST['trid'].'"');
		
		$query='UPDATE transfers SET '.$mysql_fields.', tr_system_update="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE tr_ref="'.$_POST['trid'].'"';
		$db->rq($query);
		
		/*** FIX USERS's BALANCE IF NEEDED ***/
		$fixPostValue=str_replace(',', '', $_POST['tr_total']);
		if ($getCurrentData['tr_status']!=$_POST['tr_status']&&$getCurrentData['tr_total']==$fixPostValue){ // if status is different, but total is same
			if ($_POST['tr_status']==1){ // if new status is Transfered
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==2&&$getCurrentData['tr_status']==1){ // if new status is Pending
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==3&&$getCurrentData['tr_status']==1){ // if new status is Disabled
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}elseif ($getCurrentData['tr_status']==1&&$getCurrentData['tr_status']==$_POST['tr_status']&&$getCurrentData['tr_total']!=$fixPostValue){ // if old status is transfered and new status is same, but total is different
			$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'-'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif ($getCurrentData['tr_status']!=$_POST['tr_status']&&$getCurrentData['tr_total']!=$fixPostValue){ // if status and total are both different
			if ($_POST['tr_status']==1){ // if new status is Transfered
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==2&&$getCurrentData['tr_status']==1){ // if new status is Pending
				$query='UPDATE users SET user_balance=(user_balance-'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==3&&$getCurrentData['tr_status']==1){ // if new status is Disabled
				$query='UPDATE users SET user_balance=(user_balance-'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}
		
		$link='tdref='.$_POST['trid'];
		
		global $depositOptions;
		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Transfers',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Deposit edited '.($_POST['trid']+0).' ('.$depositOptions[$_POST['tr_status']].')');
	}else{
		$tradeRef=hexdec(substr(uniqid(''), 4, 13))-505050505;
		$query='INSERT INTO transfers SET '.$mysql_fields.', tr_type=1, transfers_id="'.NID.'", tr_ref='.($tradeRef+0).', tr_system_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'", tr_system_update="'.date('Y-m-d H:i:s', CUSTOMTIME).'"';
		$db->rq($query);
		
		if (($_POST['tr_status']+0)==1){
			$fixPostValue=str_replace(',', '', $_POST['tr_total']);
			$query2='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query2);
		}
		
		$link='tdref='.$tradeRef;
		
		global $depositOptions;
		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Transfers',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Deposit added '.($tradeRef+0).' ('.$depositOptions[$_POST['tr_status']].')');
	}
	
	$db->close();
	if($_POST['tr_status']==1) {
		header('Location: mails_singleuser.php?uid='.$_POST['user_account_num'].'&'.$link.'&noheader=1');
	}else{
		header('Location: /history.php');
	}
	exit();
}

if (isset($_POST['_add_withdraw'])){
	$db=new DBConnection();
	$mysql_fields='';
	$comma='';
	$count=0;
	foreach ($_POST as $k=>$x){
		if ($k!='trid'&&$k!='_submit'&&$k!='_add_withdraw'&&$k!='k'){
			if ($count!=0) $comma=', ';
			
			if ($k=='tr_value'||$k=='tr_fees'||$k=='tr_total') $x=str_replace(',', '', $x);
			
			$mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';
			$count++ ;
		}
	}
	
	if ($_POST['trid']!=''){
	$getCurrentData=$db->getRow('transfers', 'tr_ref="'.$_POST['trid'].'"');
		
		$query='UPDATE transfers SET '.$mysql_fields.', tr_system_update="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE tr_ref="'.$_POST['trid'].'"';
		$db->rq($query);
		
		/*** FIX USERS's BALANCE IF NEEDED ***/
		$fixPostValue=str_replace(',', '', $_POST['tr_total']);
		if ($getCurrentData['tr_status']!=$_POST['tr_status']&&$getCurrentData['tr_total']==$fixPostValue){ // if status is different, but total is same
			if ($_POST['tr_status']==1){ // if new status is Transfered
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==2&&$getCurrentData['tr_status']==1){ // if new status is Pending
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==3&&$getCurrentData['tr_status']==1){ // if new status is Disabled
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}elseif ($getCurrentData['tr_status']==1&&$getCurrentData['tr_status']==$_POST['tr_status']&&$getCurrentData['tr_total']!=$fixPostValue){ // if old status is transfered and new status is same, but total is different
			$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'+'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif ($getCurrentData['tr_status']!=$_POST['tr_status']&&$getCurrentData['tr_total']!=$fixPostValue){ // if status and total are both different
			if ($_POST['tr_status']==1){ // if new status is Transfered
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==2&&$getCurrentData['tr_status']==1){ // if new status is Pending
				$query='UPDATE users SET user_balance=(user_balance+'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['tr_status']==3&&$getCurrentData['tr_status']==1){ // if new status is Disabled
				$query='UPDATE users SET user_balance=(user_balance+'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}
		
		$link='twref='.$_POST['trid'];
		
		global $depositOptions;
		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Transfers',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Withdraw edited '.($_POST['trid']+0).' ('.$depositOptions[$_POST['tr_status']].')');
	}else{
		$tradeRef=hexdec(substr(uniqid(''), 4, 13))-505050505;
		$query='INSERT INTO transfers SET '.$mysql_fields.', tr_type=2, transfers_id="'.NID.'", tr_ref='.($tradeRef+0).', tr_system_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'", tr_system_update="'.date('Y-m-d H:i:s', CUSTOMTIME).'"';
		$db->rq($query);
		
		if (($_POST['tr_status']+0)==1){
			$fixPostValue=str_replace(',', '', $_POST['tr_total']);
			$query2='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query2);
		}
		
		$link='twref='.$tradeRef;
		
		global $depositOptions;
		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Transfers',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Withdraw added '.($tradeRef+0).' ('.$depositOptions[$_POST['tr_status']].')');
	}
	
	$db->close();
	if($_POST['tr_status']==1) {
		header('Location: mails_singleuser.php?uid='.$_POST['user_account_num'].'&'.$link.'&noheader=1');
	}else{
		header('Location: /history.php');
	}
	exit();
}

function addNewDeposit($transferID=0) {

	$db=new DBConnection();
	if ($transferID&&!$_POST['_form_submit']){
		$query='SELECT * FROM transfers WHERE tr_ref="'.$transferID.'"';
		$res=$db->rq($query);
		$_POST=$db->fetch($res);
	}
	$JSCripts=' onkeyup="setDetails();" onchange="setDetails();"';
	
	if ($_POST['tr_date']=='') $_POST['tr_date']=date('Y-m-d', CUSTOMTIME);
	if ($_POST['tr_fees']=='') $_POST['tr_fees']='0.00';
	
	global $depositOptions;
	
	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($transferID>0)?'Editing':'Adding New').' Deposit</b></div>
<script type="text/javascript" src="../js/jquery.metadata.js"></script> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/transfersDeposit.js"></script>
<form name="addNewDeposit" method="POST" id="MainForms" action="">

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Account</legend>
	<div class="formsRight">
		<select name="user_account_num" id="user_account_num" class="text-input-big" title="Please select user account!" validate="required:true">
		<option value="">Select account</option>';
	
	$query='SELECT user_account_num, user_firstname, user_lastname, user_balance FROM users ORDER BY user_firstname ASC, user_lastname ASC';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		$pcontent.='<option value="'.$row['user_account_num'].'"'.(($_GET['uid']==$row['user_account_num']||$_POST['user_account_num']==$row['user_account_num'])?' selected':'').'>'.$row['user_account_num'].' ('.$row['user_firstname'].' '.$row['user_lastname'].', $'.$row['user_balance'].')</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	</fieldset>
	
	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Notes</legend>
	<div class="formsRight" style="height:105px;">
		<textarea class="text-area-big" style="height:95px;" name="tr_notes" id="user_notes">'.$_POST['tr_notes'].'</textarea>
	</div>
	</fieldset>
</div>

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Transfer</legend>
	
	<div class="formsLeft">Deposit:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="tr_value" id="tr_value" value="'.$_POST['tr_value'].'"'.$JSCripts.' autocomplete="off" />
	</div>
	<br />
	<div class="formsLeft">Fees:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="tr_fees" id="tr_fees" value="'.$_POST['tr_fees'].'"'.$JSCripts.' />
	</div>
	<br />
	<div class="formsLeft">Total Deposit:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="tr_total" id="tr_total" value="'.$_POST['tr_total'].'" readonly />
	</div>
	<br />
	<div class="formsLeft">Value date:</div>
	<div class="formsRight"><input class="text-input" type="text" name="tr_date" id="trade_date" value="'.$_POST['tr_date'].'" /></div>
	<br />
	<div class="formsLeft">Status:</div>
	<div class="formsRight">
		<select name="tr_status" class="text-input">';
	
	foreach ($depositOptions as $StatusID=>$StatusName){
		$pcontent.='<option value="'.$StatusID.'"'.(($StatusID==$_POST['tr_status'])?' selected':'').'>'.$StatusName.'</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	</fieldset>
	
	<div class="clear"></div>
	
	<div class="mainFormHolder left btnsHolder">
	<input type="hidden" name="_add_deposit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
	if ($transferID){
		$pcontent.='
	<input type="hidden" name="trid" value="'.$transferID.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this deposit?\')) location=\'?action=delete_deposit&dtrid='.($_POST['tr_ref']).'\';" />';
	}
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="'.(($_GET['uid']>0&&$_GET['noheader']!=1)?'location=\'users.php\'':'location=\'/history.php\'').';" />
	</div>
</div>
</form>
</div>';
	$db->close();
	return $pcontent;
}

function addNewWithdraw($transferID=0) {

	$db=new DBConnection();
	if ($transferID&&!$_POST['_form_submit']){
		$query='SELECT * FROM transfers WHERE tr_ref="'.$transferID.'"';
		$res=$db->rq($query);
		$_POST=$db->fetch($res);
	}
	
	$JSCripts=' onkeyup="setDetails();" onchange="setDetails();"';
	
	if (($_GET['uid']+0)>0){
		$query='SELECT user_bank_online,user_bank_beneficiary,user_bank_address,user_bank_account,user_bank_name,user_bank_codetype,user_bank_code,
		user_bank_moredetails FROM users WHERE user_account_num="'.($_GET['uid']+0).'"';
		$res=$db->rq($query);
		$row=$db->fetch($res);
		foreach ($row as $Column=>$ColumnValue){
			$fixColumnName=str_replace('user_', 'tr_', $Column);
			$_POST[$fixColumnName]=$ColumnValue;
		}
	}
	
	if ($_POST['tr_fees']=='') $_POST['tr_fees']='0.00';
	if ($_POST['tr_date']=='') $_POST['tr_date']=date('Y-m-d', CUSTOMTIME);
	
	global $depositOptions;
	$userBankCodeTypes=array(1=>'SWIFT Code', 2=>'IBAN Code', 3=>'ABA #', 4=>'BSC Code');
	
	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($transferID>0)?'Editing':'Adding New').' Withdraw</b></div>
<script type="text/javascript" src="../js/jquery.metadata.js"></script> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/transfersWithdraw.js"></script>
<form name="addNewDeposit" method="POST" id="MainForms" action="">

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Account</legend>
	<div class="formsRight">
		<select name="user_account_num" id="user_account_num" class="text-input-big" title="Please select user account!" validate="required:true">
		<option value="">Select account</option>';
	
	$query='SELECT user_account_num, user_firstname, user_lastname, user_balance FROM users ORDER BY user_firstname ASC, user_lastname ASC';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		$pcontent.='<option value="'.$row['user_account_num'].'"'.(($_GET['uid']==$row['user_account_num']||$_POST['user_account_num']==$row['user_account_num'])?' selected':'').'>'.$row['user_account_num'].' ('.$row['user_firstname'].' '.$row['user_lastname'].', $'.$row['user_balance'].')</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Bank Details</legend>
	<br />
	<div class="formsLeft">Beneficiary:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="tr_bank_beneficiary" id="tr_bank_beneficiary" value="'.$_POST['tr_bank_beneficiary'].'" />
	</div>
	<br />
	<div class="formsLeft">Bank Address:</div>
	<div class="formsRight">
		<textarea class="text-area" name="tr_bank_address" id="tr_bank_address">'.$_POST['tr_bank_address'].'</textarea>
	</div>
	<br />
	<div class="formsLeft">Bank Account:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="tr_bank_account" id="tr_bank_account" value="'.$_POST['tr_bank_account'].'" />
	</div>
	<br />
	<div class="formsLeft">Bank Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="tr_bank_name" id="tr_bank_name" value="'.$_POST['tr_bank_name'].'" />
	</div>
	<br />
	<div class="formsLeft">
		<select name="tr_bank_codetype" class="select-medium">';
	
	foreach ($userBankCodeTypes as $BankCodeID=>$BankCodeType){
		$pcontent.='<option value="'.$BankCodeID.'"'.(($BankCodeID==$_POST['tr_bank_codetype'])?' selected':'').'>'.$BankCodeType.'</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="tr_bank_code" id="tr_bank_code" value="'.$_POST['tr_bank_code'].'" />
	</div>
	<br />
	<div class="formsLeft">More Bank Details:</div>
	<div class="formsRight">
	    <textarea class="text-area" name="tr_bank_moredetails" id="tr_bank_moredetails">'.$_POST['tr_bank_moredetails'].'</textarea>
	</div>
	</fieldset>
	
	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Notes</legend>
	<div class="formsRight" style="height:105px;">
		<textarea class="text-area-big" style="height:95px;" name="tr_notes" id="user_notes">'.$_POST['tr_notes'].'</textarea>
	</div>
	</fieldset>
</div>

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Transfer</legend>
	
	<div class="formsLeft">Withdraw:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="tr_value" id="tr_value" value="'.$_POST['tr_value'].'"'.$JSCripts.' autocomplete="off" />
	</div>
	<br />
	<div class="formsLeft">Fees:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="tr_fees" id="tr_fees" value="'.$_POST['tr_fees'].'"'.$JSCripts.' />
	</div>
	<br />
	<div class="formsLeft">Total Withdraw:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="tr_total" id="tr_total" value="'.$_POST['tr_total'].'" readonly />
	</div>
	<br />
	<div class="formsLeft">Value date:</div>
	<div class="formsRight"><input class="text-input" type="text" name="tr_date" id="trade_date" value="'.$_POST['tr_date'].'" /></div>
	<br />
	<div class="formsLeft">Status:</div>
	<div class="formsRight">
		<select name="tr_status" class="text-input">';
	
	foreach ($depositOptions as $StatusID=>$StatusName){
		$pcontent.='<option value="'.$StatusID.'"'.(($StatusID==$_POST['tr_status'])?' selected':'').'>'.$StatusName.'</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	</fieldset>
	
	<div class="clear"></div>
	
	<div class="mainFormHolder left btnsHolder">
	<input type="hidden" name="_add_withdraw" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
	if ($transferID){
		$pcontent.='
	<input type="hidden" name="trid" value="'.$transferID.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this withdraw?\')) location=\'?action=delete_withdraw&wtrid='.($_POST['tr_ref']).'\';" />';
	}
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="'.(($_GET['uid']>0&&$_GET['noheader']!=1)?'location=\'users.php\'':'location=\'/history.php\'').';" />
	</div>
</div>
</form>
</div>';
	$db->close();
	return $pcontent;
}

function listTransfers() {

	//global $depositOptions;
	//$types=array(1=>'Deposit',2=>'Withdraw');
	

	$pcontent='';
	$pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";

/* Overlay */
#simplemodal-overlay {background-color:#000; cursor: pointer;}
/* Container */
#simplemodal-container {height:320px; width:600px; color:#bbb; background-color:#333; border:4px solid #444; padding:12px;}
#simplemodal-container a {color:#ddd;}
#simplemodal-container a.modalCloseImg {background:url(./images/close.png) no-repeat; width:25px; height:29px; display:inline; z-index:3200; position:absolute; top:-15px; right:-16px; cursor:pointer;}
#simplemodal-container #basic-modal-content {padding:8px;}

</style>
<!--[if lt IE 7]>
<style type="text/css">
#simplemodal-container a.modalCloseImg {
	background:none;
	right:-14px;
	width:22px;
	height:26px;
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(
		src="../images/close.png", sizingMethod="scale"
	);
}
</style>
<![endif]-->
</style>
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_transfers.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Transfers</b></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="transfersTable">
	<thead>
	    <tr>
		<th><b>REF #</b></th>
		<th><b>Account</b></th>
		<th><b>First name</b></th>
		<th><b>Last name</b></th>
		<th><b>Type</b></th>
		<th><b>Date</b></th>
		<th><b>Value</b></th>
		<th><b>Status</b></th>
		<th><b>Actions</b></th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
		<td colspan="8" class="dataTables_empty">Loading data from server</td>
	    </tr>
	</tbody>
    </table>
</div>';
	
	return $pcontent;
}

if (isset($_GET['action'])){
	$cmd=($_GET['action']);
}else{
	$cmd='';
}

if (isset($_POST['_back'])) $cmd='';
$page_content='';
switch ($cmd) {
	case 'new_deposit' :
		$page_content=addNewDeposit();
		break;
	case 'edit_deposit' :
		$exp="/[^a-zA-Z0-9]/i";
		$check=preg_match($exp, $_GET['ref']);
		if (($check+0)==1){
			header('Location: /history.php');
			exit();
		}else{
			$page_content=addNewDeposit($_GET['ref']);
		}
		break;
	case 'delete_deposit' :
		if ($_SESSION['admin']['is_logged']==1){
			$exp="/[^a-zA-Z0-9]/i";
			$check=preg_match($exp, $_GET['dtrid']);
			if (($check+0)==1){
				header('Location: /history.php');
				exit();
			}
			$db=new DBConnection();
			
			$getCurrentData=$db->getRow('transfers', 'tr_ref="'.$_GET['dtrid'].'"');
			
			/*** FIX USERS's BALANCE IF CURRENT STATUS IS TRANSFERED ***/
			if ($getCurrentData['tr_status']==1){ // if new status is Transfered
				$query='UPDATE users SET user_balance=(user_balance-'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$getCurrentData['user_account_num'].'"';
				$db->rq($query);
			}
			
			$query='DELETE FROM transfers WHERE tr_ref="'.$_GET['dtrid'].'"';
			$db->rq($query);
			
			global $depositOptions;
			$uDetails=$db->getRow('users','user_account_num="'.$getCurrentData['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			addLog('Back-end','Transfers',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Deposit deleted '.($_GET['dtrid']+0).' ('.$depositOptions[$getCurrentData['tr_status']].')');
			
			$db->close();
			header('Location: /history.php');
			exit();
		}
		break;
	case 'new_withdraw' :
		$page_content=addNewWithdraw();
		break;
	case 'edit_withdraw' :
		$exp="/[^a-zA-Z0-9]/i";
		$check=preg_match($exp, $_GET['ref']);
		if (($check+0)==1){
			header('Location: /history.php');
			exit();
		}else{
			$page_content=addNewWithdraw($_GET['ref']);
		}
		break;
	case 'delete_withdraw' :
		if ($_SESSION['admin']['is_logged']==1){
			$exp="/[^a-zA-Z0-9]/i";
			$check=preg_match($exp, $_GET['wtrid']);
			if (($check+0)==1){
				header('Location: /history.php');
				exit();
			}
			$db=new DBConnection();
			
			$getCurrentData=$db->getRow('transfers', 'tr_ref="'.$_GET['wtrid'].'"');
			
			/*** FIX USERS's BALANCE IF CURRENT STATUS IS TRANSFERED ***/
			if ($getCurrentData['tr_status']==1){ // if new status is Transfered
				$query='UPDATE users SET user_balance=(user_balance+'.($getCurrentData['tr_total']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$getCurrentData['user_account_num'].'"';
				$db->rq($query);
			}
			
			$query='DELETE FROM transfers WHERE tr_ref="'.$_GET['wtrid'].'"';
			$db->rq($query);
			
			global $depositOptions;
			$uDetails=$db->getRow('users','user_account_num="'.$getCurrentData['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			addLog('Back-end','Transfers',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Withdraw deleted '.($_GET['wtrid']+0).' ('.$depositOptions[$getCurrentData['tr_status']].')');
			
			$db->close();
			header('Location: /history.php');
			exit();
		}
		break;
	default :
		$page_content=listTransfers();
		break;
}

page_header(0);
echo $page_content;
page_footer();
?>