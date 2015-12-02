<?php
require_once('template.php');
require_once('sendwithus/lib/API.php');
use sendwithus\API;

if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab']=9;
unset($_SESSION['admin']['uedit']);

if((isset($_POST['_submit']) || isset($_POST['_preview']))&&$_POST['mail_subject']!=''&&$_POST['mail_html']) {
    $db=new DBConnection();

    $referenceNumber = '';
    $whatmail='';
	if ($_GET['buyref']!=''){
		$whatmail='Trade buy details';
        $referenceNumber = $_GET['buyref'];
	}elseif ($_GET['sellref']!=''){
		$whatmail='Trade sell details';
        $referenceNumber = $_GET['sellref'];
	}elseif ($_GET['tdref']!=''){
		$whatmail='Transfer deposit details';
        $referenceNumber = $_GET['tdref'];
	}elseif ($_GET['twref']!=''){
		$whatmail='Transfer withdraw details';
        $referenceNumber = $_GET['twref'];
	}else{
		$whatmail='Other';
	}

    foreach ($_POST as $k => $x){
        $_POST[$k] = $db->string_escape($x);
    }

    $mysql_fields='';
    $comma='';
    $count=0;
    foreach ($_POST as $k => $x) {
        if($k != '_submit' && $k != '_preview' && $k != '_form_submit' && $k != 'mail_templates_id' && $k != 'user_account_num' && $k != 'mail_html' && $k != 'mail_plain') {
            if($count != 0){
                $comma=', ';
            }
            
            $mysql_fields.=''.$comma.''.$k.'="'.($x).'"';
            $count++;
        }
    }

    $query='SELECT u.*, ua1.advisor_names as user_advisor1, ua2.advisor_names as user_advisor2 FROM users u
    	left join users_advisors ua1 on u.user_advisor1 = ua1.users_advisors_id
    	left join users_advisors ua2 on u.user_advisor2 = ua2.users_advisors_id
    	WHERE u.user_account_num="'.$_POST['user_account_num'].'"';
    $res=$db->rq($query);
    while(($row=$db->fetch($res)) != FALSE) {
        $mail_merges = $row;

        /*$possible='0123456789abcdfghjklmnopqrstuvwxyzABCDFGHJKLMNOPQRSTUVWXYZ';
		$newpass='';
		$i=0;
		for($i=0; $i<8; $i++ ){
			$newpass.=substr($possible, mt_rand(0, strlen($possible)-1), 1);
		}
		
		$pattern=('{user_password}');
		$check=preg_match($pattern, $_POST['mail_html']);
		if ($check==1){
			$query2='UPDATE users SET user_password="'.$newpass.'", user_passisset=0 WHERE users_id='.($row['users_id']+0).'';
			$db->rq($query2);
            $mail_merges['user_password'] = $newpass;
		}*/

		$search_for = array('{user_first_name}', '{user_last_name}', '{user_username}', '{user_password}', '{user_password_org}', '{user_account_num}', '{user_balance}', '{thanks}', '{company_name}', '{site_url}',
			'{user_account_name}',
			'{user_admin_ref}',
			'{user_phone}',
			'{user_email}',
			'{user_mailing_address}',
			'{user_city}',
			'{user_state}',
			'{user_postal}',
			'{user_country}',
			'{user_advisor1}',
			'{user_advisor2}',
			'{user_app_date}'
		);
		$replace_with = array(
            $row['user_firstname'], $row['user_lastname'], $row['user_username'], $row['user_password'], $row['user_password'],
            array_get($row, 'user_account_num'), number_format($row['user_balance'], 2),
            $lang['mails_thanks'], $lang['site_long_name'], $lang['site_url'],
            $row['user_account_name'],
			$row['user_ref'],
			$row['user_phone'],
			$row['user_email'],
			$row['user_mailing_address'],
			$row['user_city'],
			$row['user_state'],
			$row['user_postal'],
			$row['user_country'],
			$row['user_advisor1'],
			$row['user_advisor2'],
			$row['user_app_date']
		);
		$mail_html=str_replace($search_for, $replace_with, $_POST['mail_html']);
		$mail_plain=str_replace($search_for, $replace_with, $_POST['mail_plain']);
		
		$pattern=('{account_statement}');
		$check=preg_match($pattern, $_POST['mail_html']);
		$account_statement='';
		$account_statement_plain='';
		if ($check==1){
			$account_statement.='
			<h2>Trading Overview</h2>
			<table cellspacing="1" cellpadding="1" border="1">
				<tr>
	    			<td><b>Date</b></td>
	    			<td><b>REF #</b></td>
	    			<td><b>Details</b></td>
	    			<td><b>Opt</b></td>
	    			<td><b>Expiry</b></td>
	    			<td><b>Premium</b></td>
	    			<td><b>Strike Price</b></td>
	    			<td><b>Fees</b></td>
	    			<td><b>Price</b></td>
	    			<td><b>Status</b></td>
				</tr>';
			
			$account_statement_plain.="
Trading Overview\n\n
Date | REF # | Details | Opt | Expiry | Premium | Strike Price | Fees | Price | Status";

			$buyStatuses=array(1=>'Open',2=>'Pending',3=>'Disabled', 4=>'Closed');
			$sellStatuses=array(1=>'Closed',2=>'Pending',3=>'Disabled');
			$tradesBuyOptions=array(1=>'CALL',2=>'PUT');
			
			$query3='SELECT * FROM trades WHERE user_account_num="'.$_POST['user_account_num'].'" ORDER BY trade_date DESC, trade_action_date DESC, trades_id DESC';
			$res3=$db->rq($query3);
			while(($row3=$db->fetch($res3))!=FALSE) {
				if($row3['trade_type']==1){
					$status=$buyStatuses[$row3['trade_status']];
				}else{
					$status=$sellStatuses[$row3['trade_status']];
				}
				$account_statement.='
				<tr>
	    			<td>'.date('d M Y',strtotime($row3['trade_date'])).'</td>
	    			<td>'.$row3['trade_ref'].'</td>
	    			<td>'.$row3['trade_details'].'</td>
		    		<td>'.$tradesBuyOptions[$row3['trade_option']].'</td>
		    		<td>'.date('d M Y',strtotime($row3['trade_expiry_date'])).'</td>
		    		<td>$'.number_format($row3['trade_premium_price'],4).'</td>
		    		<td>$'.number_format($row3['trade_strikeprice'],2).'</td>
		    		<td>$'.number_format($row3['trade_fees'],2).'</td>
		    		<td>$'.number_format($row3['trade_value'],2).'</td>
		    		<td>'.$status.'</td>
				</tr>';
				
				$account_statement_plain.="
".date('d M Y',strtotime($row3['trade_date']))." | ".$row3['trade_ref']." | ".$row3['trade_details']." | ".$tradesBuyOptions[$row3['trade_option']]." | ".date("d M Y",strtotime($row3['trade_expiry_date']))." | $".number_format($row3['trade_premium_price'],4)." | $".number_format($row3['trade_strikeprice'],2)." | $".number_format($row3['trade_fees'],2)." | $".number_format($row3['trade_value'],2)." | ".$status."";
			}

				$account_statement.='
    		</table>';
				
				$account_statement_plain.="\n\n\n";
				
			$account_statement.='<h2>Funding Overview</h2>
			<table cellspacing="1" cellpadding="1" border="1">
				<tr>
	    			<td><b>Date</b></td>
	    			<td><b>REF #</b></td>
	    			<td><b>Type</b></td>
	    			<td><b>Value Date</b></td>
	    			<td><b>Amount</b></td>
	    			<td><b>Fees</b></td>
	    			<td><b>Withdraw</b></td>
	    			<td><b>Status</b></td>
	    			<td><b>Notes</b></td>
				</tr>';
			
			$account_statement_plain.="
Funding Overview\n\n
Date | REF # | Type | Value Date | Amount | Fees | Withdraw | Status | Notes";
				$depositOptions=array(1=>'Transfered',2=>'Pending',3=>'Disabled');
				$transfersOptions=array(1=>'Deposit',2=>'Withdraw');
				
				$query3='SELECT * FROM transfers WHERE user_account_num="'.$_POST['user_account_num'].'" ORDER BY tr_date DESC, tr_system_update DESC, transfers_id DESC';
				$res3=$db->rq($query3);
				while(($row3=$db->fetch($res3))!=FALSE) {
					$account_statement.='
				<tr class="'.$depositOptions[$row3['tr_status']].'">
	    			<td>'.date('d M Y',strtotime($row3['tr_date'])).'</td>
	    			<td>'.$row3['tr_ref'].'</td>
	    			<td>'.$transfersOptions[$row3['tr_type']].'</td>
	    			<td>'.date('d M Y',strtotime($row3['tr_date'])).'</td>
	    			<td>$'.number_format($row3['tr_value'],2).'</td>
	    			<td>$'.number_format($row3['tr_fees'],2).'</td>
	    			<td>$'.number_format($row3['tr_total'],2).'</td>
	    			<td>'.$depositOptions[$row3['tr_status']].'</td>
	    			<td>'.$row3['tr_notes'].'&nbsp;</td>
				</tr>';
					
				$account_statement_plain.="
".date("d M Y",strtotime($row3['tr_date']))." | ".$row3['tr_ref']." | ".$transfersOptions[$row3['tr_type']]." | ".date('d M Y',strtotime($row3['tr_date']))." | $".number_format($row3['tr_value'],2)." | $".number_format($row3['tr_fees'],2)." | $".number_format($row3['tr_total'],2)." | ".$depositOptions[$row3['tr_status']]." | ".$row3['tr_notes']."";
				}
				
				$account_statement.='
    		</table>';
				
			$mail_html=str_replace('{account_statement}', $db->string_escape($account_statement), $mail_html);
			$mail_plain=str_replace('{account_statement}', $db->string_escape($account_statement_plain), $mail_plain);
		}
		

		if(!isset($_POST['_preview'])){
	    	$query2='INSERT INTO mail_queue SET '.$mysql_fields.', admins_id='.($_SESSION['admin']['adminid']+0).', 
	    	time_to_send="'.date('Y-m-d H:i:s', CUSTOMTIME).'", create_time="'.date('Y-m-d H:i:s', CUSTOMTIME).'", mail_to="'.$db->string_escape($row['user_email']).'", 
	    	mail_to_names="'.$row['user_firstname'].' '.$row['user_lastname'].'", mail_html="'.$mail_html.'", mail_plain="'.$mail_plain.'"';
	    	$db->rq($query2);
	    	$MailID=$db->last_id();
	        
	        $query = 'SELECT * FROM mail_queue WHERE mail_queue_id='.($MailID+0).' AND is_sent=0';
	    	$res = $db->rq($query);
			$row = $db->fetch($res);
		}
    	
        // Settings
    	$settingsModel = new App\Model\Settings($db, 'mail_settings');
        $settings = $settingsModel->getAll();
        
        $transport = $settings['mail_transport'];
        /*
       $smtp_host = $settings['mail_' . $transport . '_host'];
       $smtp_port = $settings['mail_' . $transport . '_port'];
       $smtp_user = $settings['mail_' . $transport . '_user'];
       $smtp_password = $settings['mail_' . $transport . '_password'];


       include ('../includes/nomad_mimemail.inc.php');
       $mimemail = new nomad_mimemail();

       $mimemail->set_charset("UTF-8");

       if(isset($row['mail_from']) && !empty($row['mail_from'])) {
           $mimemail->set_from($row['mail_from_mail'], $row['mail_from']);
           $mimemail->set_reply_to($row['mail_from_mail'], $row['mail_from']);
       }else{
           $mimemail->set_from(array_get($row, 'mail_from_mail'));
           $mimemail->set_reply_to(array_get($row, 'mail_from_mail'));
       }

       $mimemail->set_subject(array_get($row, 'mail_subject'));
       $mimemail->set_html(array_get($row, 'mail_html'));
       $mimemail->set_text(array_get($row, 'mail_plain'));

       $mimemail->set_to(array_get($row, 'mail_to'), array_get($row, 'mail_to_names'));

       //$mimemail->set_smtp_log(true); // If you need debug SMTP connection
       $mimemail->set_smtp_host($smtp_host,$smtp_port);
       $mimemail->set_smtp_auth($smtp_user, $smtp_password);
       */

        $buyStatuses=array(1=>'Open',2=>'Pending',3=>'Disabled', 4=>'Closed');
        $sellStatuses=array(1=>'Closed',2=>'Pending',3=>'Disabled');
        $stockTradeRow = $db->getRow('stock_trades','trade_ref="'.$referenceNumber.'"','trade_details,trade_date,trade_status,trade_value');
        $templateRow = $db->getRow('mail_templates','mail_templates_id="'.$_POST['mail_templates_id'].'"','mail_template_title,mail_subject,mail_external_id');
        $transferRow = $db->getRow('transfers','tr_ref="'.$referenceNumber.'"');
        $templateKey = $templateRow["mail_external_id"];
        /*
        switch($templateRow['mail_template_title'])
        {
            case 'Welcome Mail':
                $templateKey = 'tem_XtBjuHMBA7zNeERjSN5bqX';
                break;
            case 'Buy Details':
                $templateKey = 'tem_duZh4bauJTG2zbjakpCuKd';
                break;
            case 'Deposit Details':
                $templateKey = 'tem_BbcTM9r25T755QSszZxHb6';
                break;
            case 'Request Password':
                $templateKey = 'tem_yJKADSmHAEwN6yVGXiHXXE';
                break;
            case 'Sell Details':
                $templateKey = 'tem_W4rsavHG7kFZ2AcJnkstVR';
                break;
            case 'Statement of Account':
                $templateKey = 'tem_BfLWuFAjaLtHKfzLXgtxPK';
                break;
            case 'Withdraw Details':
                $templateKey = 'tem_X4ptoqriNsaGHtT5LbyE6d';
                break;
            case 'Funding Details':
                $templateKey = '';
                break;
        }
        */

        /**/
        $depositOptions=array(1=>'Transfered',2=>'Pending',3=>'Disabled');
        $transfersOptions=array(1=>'Deposit',2=>'Withdraw');

        $query3='SELECT * FROM transfers WHERE user_account_num="'.$_POST['user_account_num'].'" ORDER BY tr_date DESC, tr_system_update DESC, transfers_id DESC';
        $res3=$db->rq($query3);
        $fundingOverviews = array();
        while(($row3=$db->fetch($res3))!=FALSE) {
            $fundingOverview = array(
                'date' => date('d M Y',strtotime($row3['tr_date'])),
                'ref' => $row3['tr_ref'],
	    		'type' => $transfersOptions[$row3['tr_type']],
	    		'value_date' => date('d M Y',strtotime($row3['tr_date'])),
	    		'amount' => number_format($row3['tr_value'],2),
	    		'fees' => number_format($row3['tr_fees'],2),
	    		'withdraw' => number_format($row3['tr_total'],2),
	    		'status' => $depositOptions[$row3['tr_status']],
	    		'note' => $row3['tr_notes']
				);
            $fundingOverviews[] = $fundingOverview;
        }


        $buyStatuses=array(1=>'Open',2=>'Pending',3=>'Disabled', 4=>'Closed');
        $sellStatuses=array(1=>'Closed',2=>'Pending',3=>'Disabled');
        $tradesBuyOptions=array(1=>'CALL',2=>'PUT');

        $query3='SELECT * FROM trades WHERE user_account_num="'.$_POST['user_account_num'].'" ORDER BY trade_date DESC, trade_action_date DESC, trades_id DESC';
        $res3=$db->rq($query3);
        $tradingOverviews = array();
        while(($row3=$db->fetch($res3))!=FALSE) {
            if($row3['trade_type']==1){
                $status=$buyStatuses[$row3['trade_status']];
            }else{
                $status=$sellStatuses[$row3['trade_status']];
            }
            $tradingOverview = array(
                'date' => date('d M Y',strtotime($row3['trade_date'])),
	    		'ref' => $row3['trade_ref'],
                'details' => $row3['trade_details'],
		    	'opt' => $tradesBuyOptions[$row3['trade_option']],
                'expiry' => date('d M Y',strtotime($row3['trade_expiry_date'])),
		    	'premium' => number_format($row3['trade_premium_price'],4),
                'strike_price' => number_format($row3['trade_strikeprice'],2),
		    	'fees' => number_format($row3['trade_fees'],2),
                'price' => number_format($row3['trade_value'],2),
		    	'status' => $status
            );
            $tradingOverviews[] = $tradingOverview;

        }

        $email_params = array(
        	'email_data' =>
				array(
					'mail_template_title' => $templateRow['mail_template_title'],
					'user_first_name' => $mail_merges['user_firstname'],
				   	'user_username' => $mail_merges['user_username'],
					'user_last_name' => $mail_merges['user_lastname'],
					'user_account_num' => $mail_merges['user_account_num'],
					'user_password' => $mail_merges['user_password'],
					'user_password_org' => $mail_merges['user_password'],
					'user_account_name' => $mail_merges['user_account_name'],
					'user_admin_ref' => $mail_merges['user_ref'],
					'user_phone' => $mail_merges['user_phone'],
					'user_email' => $mail_merges['user_email'],
					'user_mailing_address' => $mail_merges['user_mailing_address'],
					'user_city' => $mail_merges['user_city'],
					'user_state' => $mail_merges['user_state'],
					'user_postal' => $mail_merges['user_postal'],
					'user_country' => $mail_merges['user_country'],
					'user_advisor1' => $mail_merges['user_advisor1'],
					'user_advisor2' => $mail_merges['user_advisor2'],
					'user_app_date' => $mail_merges['user_app_date'],
					'trade_details' => $stockTradeRow['trade_details'],
					'trade_date' => $stockTradeRow['trade_date'],
					'trade_sell_status' => $sellStatuses[$stockTradeRow['trade_status']],
					'trade_buy_status' => $buyStatuses[$stockTradeRow['trade_status']],
					'trade_value' => $stockTradeRow['trade_value'],
				
					'transfer_value' => number_format($transferRow['tr_value'],2),
					'transfer_date' =>  $transferRow['tr_date'],
				
					'thanks' => $lang['mails_thanks'],
					'company_name' => $lang['site_long_name'],
					'site_url' => $lang['site_url'],
				
					'funding_overviews' => $fundingOverviews,
					'trading_overviews' => $tradingOverviews ,
					'trade_ref' => $referenceNumber
				)
        );

	    $API_KEY = $settings['sendwithus_key'];
        $options = array();
        $api = new API($API_KEY, $options);
        
        if(isset($_POST['_preview'])){
        	$response = $api->render($templateKey, Array('template_data' => $email_params['email_data']));
        	
        	$db=new DBConnection();
			$userDetails=$db->getRow('users','user_account_num="'.$_GET['uid'].'"','user_email, user_firstname, user_lastname, user_username, user_account_num, user_balance');
        	
			$post_back_data = '';
			foreach( $_POST as $key => $val ){
				if($key == '_preview'){
					continue;
				}
                $post_back_data .= '<input type="hidden" name="'.htmlSpecialChars( $key, ENT_COMPAT, 'UTF-8' ).'" value="'.htmlSpecialChars( $val, ENT_COMPAT, 'UTF-8' ).'" />';
			}
			
        	page_header();
        	echo '<div class="mainHolder">
			<div class="hintHolder ui-state-default"><b>Preview Mail to User '.$userDetails['user_firstname'].' '.$userDetails['user_lastname'].' - '.$_GET['uid'].' ('.$userDetails['user_email'].')</b></div>
			<fieldset class="mainFormHolder" style="width:800px;">
				<legend>Preview</legend>
				<form name="addNewMailTemplate" method="POST" id="MainForms" action="">
				'.$post_back_data.'
				<input type="submit" name="_back" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" />
				</form>
				<br />';
        	echo $response->html;
        	echo '</fieldset></div></div>';
        	page_footer();
        	exit();
        }else{
        	$recipient = array(
	        	'name' =>  $row['mail_to_names'],
				'address' => $row['mail_to']
	        );
	        
	        $email_params = array_merge($email_params, 
	        	array('sender' =>
					array(
						'name' => $row['mail_from'],
						'address' => $row['mail_from_mail']
					)
				)
			);
        	$response = $api->send($templateKey, $recipient, $email_params);

        	if ($response->success){
				$query3='DELETE FROM mail_queue WHERE mail_queue_id='.($MailID+0).'';
				$db->rq($query3);
			}else{
				$query3='UPDATE mail_queue SET try_sent=(try_sent+1) WHERE mail_queue_id='.($MailID+0).'';
				$db->rq($query3);
			}
	
			if ($row['mail_bcc']){
	            /*
				$mimemail=new nomad_mimemail();
				
				$mimemail->set_charset("UTF-8");
				
				if ($row['mail_from']!=''){
					$mimemail->set_from($row['mail_from_mail'], $row['mail_from']);
					$mimemail->set_reply_to($row['mail_from_mail'], $row['mail_from']);
				}else{
					$mimemail->set_from($row['mail_from_mail']);
					$mimemail->set_reply_to($row['mail_from_mail']);
				}
				
				$mimemail->set_subject($row['mail_subject']);
				$mimemail->set_html($row['mail_html']);
				$mimemail->set_text($row['mail_plain']);
				
				$mimemail->set_to($row['mail_bcc']);
				
				$mimemail->set_smtp_host($smtp_host, $smtp_port);
				$mimemail->set_smtp_auth($smtp_user, $smtp_password);
				$mimemail->send();
	            */
			}
			
	    	$uDetails=$db->getRow('users','user_email="'.$row['user_email'].'"','user_firstname, user_lastname, user_account_num');
			addLog('Back-end','Mails',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Mail Sent ('.$whatmail.')');
        }
   	}
    
    $db->close();
    if($_GET['noheader']==1) {
    	header('Location: /history.php');
    }else{
    	header('Location: users.php');
    }
    exit();
}

if(array_get($_GET, 'noheader')==1) {
	page_header(0);
}else{
	page_header();
}

$db=new DBConnection();
$userDetails=$db->getRow('users','user_account_num="'.$_GET['uid'].'"','user_email, user_firstname, user_lastname, user_username, user_account_num, user_balance');
if(isset($_GET['buyref'])) {
	$query='SELECT mail_templates_id FROM mail_templates mt LEFT JOIN global_settings gs ON mt.mail_templates_id=gs.variable_value WHERE variable="Buy Confirmation"';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if($num_rows>0) {
		$row=$db->fetch($res);
		$_POST['mail_templates_id']=$row['mail_templates_id'];
	}
}elseif(isset($_GET['sellref'])) {
	$query='SELECT mail_templates_id FROM mail_templates mt LEFT JOIN global_settings gs ON mt.mail_templates_id=gs.variable_value WHERE variable="Sell Confirmation"';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if($num_rows>0) {
		$row=$db->fetch($res);
		$_POST['mail_templates_id']=$row['mail_templates_id'];
	}
}elseif(isset($_GET['tdref'])) {
	$query='SELECT mail_templates_id FROM mail_templates mt LEFT JOIN global_settings gs ON mt.mail_templates_id=gs.variable_value WHERE variable="Deposit Confirmation"';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if($num_rows>0) {
		$row=$db->fetch($res);
		$_POST['mail_templates_id']=$row['mail_templates_id'];
	}
	
}elseif(isset($_GET['twref'])) {
	$query='SELECT mail_templates_id FROM mail_templates mt LEFT JOIN global_settings gs ON mt.mail_templates_id=gs.variable_value WHERE variable="Withdrawal Confirmation"';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if($num_rows>0) {
		$row=$db->fetch($res);
		$_POST['mail_templates_id']=$row['mail_templates_id'];
	}
}

if (array_get($_POST, 'mail_templates_id', 0) > 0){
	$query = 'SELECT * FROM mail_templates WHERE mail_templates_id='.($_POST['mail_templates_id']+0).' LIMIT 1';
	$res   = $db->rq($query);
	if(!isset($_POST['_back'])){
		$_POST = $db->fetch($res);
	}

    //
    $templateRow = $db->getRow('mail_templates','mail_templates_id="'.$_POST['mail_templates_id'].'"','mail_external_id, mail_template_title, mail_templates_id');
    $templateId = $templateRow["mail_external_id"];
    
	$settingsModel = new App\Model\Settings($db, 'mail_settings');
    $settings = $settingsModel->getAll();
    
	if(!$templateId){
		echo '<p>Sendwithus theme is not defined for this template "'.$templateRow['mail_template_title'].'"</p>';
		echo '<p><a href=\'mails_templates.php?action=edit&mtid='.$templateRow['mail_templates_id'].'\'>Go to edit</a></p>';
		exit();
	}

    $API_KEY = $settings['sendwithus_key'];
    $options = array();
    $api = new API($API_KEY, $options);
    $response = $api->get_template($templateId);
    $response = $api->get_template($templateId,$response->versions[0]->id);

    $_POST["mail_html"] = $response->html;
    $_POST["mail_plain"] = $response->text;
    //
}else{
	$_POST = array();
}

if(isset($_GET['buyref']) || isset($_GET['sellref']) || isset($_GET['tdref']) || isset($_GET['twref'])) {
	$traderef='';
	if(isset($_GET['buyref'])) {
		$traderef = $_GET['buyref'];
		$tradeDetails = $db->getRow('trades','trade_ref="'.$traderef.'"');
		$BuySellStatuses = array(1=>'Open',2=>'Pending',3=>'Disabled', 4=>'Closed');
	}elseif(isset($_GET['sellref'])) {
		$traderef = $_GET['sellref'];
		$tradeDetails = $db->getRow('trades','trade_ref="'.$traderef.'"');
		$BuySellStatuses = array(1=>'Closed',2=>'Pending',3=>'Disabled');
	}elseif(isset($_GET['tdref'])) {
		$traderef = $_GET['tdref'];
		$tradeDetails = $db->getRow('transfers','tr_ref="'.$traderef.'"');
		$depositOptions = array(1=>'Transfered',2=>'Pending',3=>'Disabled');
        $BuySellStatuses = array();
	}elseif(isset($_GET['twref'])) {
		$traderef = $_GET['twref'];
		$tradeDetails = $db->getRow('transfers','tr_ref="'.$traderef.'"');
		$depositOptions = array(1=>'Transfered',2=>'Pending',3=>'Disabled');
        $BuySellStatuses = array();
	}
    
    if (!is_array($tradeDetails)) {
        $tradeDetails = array();
    }
	/* replacement process will be done in sendwithus
	$search_for=array('{user_first_name}', '{user_last_name}', '{user_username}', '{user_account_num}', '{trade_ref}', '{trade_value}', 
	'{trade_expiry}', '{trade_details}', '{trade_date}','{trade_fees}', '{trade_invoiced}', '{trade_status}', '{trade_positions}', 
	'{user_balance}','{transfer_ref}', 
	'{transfer_value}', '{transfer_fees}', '{transfer_total}', '{transfer_date}', '{transfer_status}');
	
	$replace_with = array($userDetails['user_firstname'], $userDetails['user_lastname'], $userDetails['user_username'], $userDetails['user_account_num'],
	array_get($tradeDetails, 'trade_ref'), number_format(array_get($tradeDetails, 'trade_value', 0), 2), array_get($tradeDetails, 'trade_expiry_date'), array_get($tradeDetails, 'trade_details'), 
	array_get($tradeDetails, 'trade_date'), number_format(array_get($tradeDetails, 'trade_fees', 0), 2), number_format(array_get($tradeDetails, 'trade_invoiced', 0), 2), array_get($BuySellStatuses, array_get($tradeDetails, 'trade_status')), 
	array_get($tradeDetails, 'trade_positions'), number_format(array_get($userDetails, 'user_balance', 0), 2),
	array_get($tradeDetails, 'tr_ref'), number_format(array_get($tradeDetails, 'tr_value', 0), 2), number_format(array_get($tradeDetails, 'tr_fees', 0), 2), number_format(array_get($tradeDetails, 'tr_total', 0), 2), array_get($tradeDetails, 'tr_date'), array_get($depositOptions, array_get($tradeDetails, 'tr_status')));
	
	$_POST['mail_html']=str_replace($search_for, $replace_with, $_POST['mail_html']);
	$_POST['mail_plain']=str_replace($search_for, $replace_with, $_POST['mail_plain']);
	*/
}

if(empty($userDetails)){
	echo '<p>Cannot send email, recipient is not defined!</p>';
	exit();
}

echo '
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>Sending Mail to User '.$userDetails['user_firstname'].' '.$userDetails['user_lastname'].' - '.$_GET['uid'].' ('.$userDetails['user_email'].')</b></div> 
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
        theme : "advanced",
        editor_selector : "mceEditor",
        readonly : true,
        visual: false
});
</script>
<form name="addNewMailTemplate" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder" style="width:800px;">
	<legend>Mail information</legend>';

	if(!isset($_GET['buyref']) && !isset($_GET['sellref']) && !isset($_GET['tdref']) && !isset($_GET['twref'])) {
	echo '
	<div class="formsLeft">Use template?</div>
	<div class="formsRight">
		<select name="mail_templates_id" class="text-input" onchange="this.form.submit();">
			<option value="0">Select template to use</option>';
	
	$query='SELECT mail_templates_id, mail_template_title FROM mail_templates WHERE mail_single=1 ORDER BY mail_template_title';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		echo '<option value="'.$row['mail_templates_id'].'"'.(($row['mail_templates_id']==$_POST['mail_templates_id'])?' selected':'').'>'.$row['mail_template_title'].'</option>';
	}

	echo '
		</select>
	</div>
	<br />';
	}else{
        echo '<input type="hidden" name="mail_templates_id" value="'.$_POST['mail_templates_id'].'" />';
    }
	
	echo '
	<div class="formsLeft">Mail From:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_from_mail" id="mail_from_mail" value="'.array_get($_POST, 'mail_from_mail').'" />
		(ex: noreply@site.com)
	</div>
	
	<br />
	<div class="formsLeft">Mail BCC:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_bcc" id="mail_bcc" value="'.array_get($_POST, 'mail_bcc').'" />
		(ex: noreply@site.com)
	</div>
	
	<br />
	<div class="formsLeft">Mail From Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_from" id="mail_from" value="'.array_get($_POST, 'mail_from').'" />
		(ex: John Doe)
	</div>
	
	<br />
	<div class="formsLeft">Mail Subject:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_subject" id="mail_subject" value="'.array_get($_POST, 'mail_subject').'" />
	</div>
	
	<br />
	<div class="formsLeft">HTML Content:</div>
	<div class="formsRight">
		<br />
		<textarea name="mail_html" style="width:100%" class="mceEditor">'.array_get($_POST, 'mail_html').'</textarea>
	</div>
	
	<br />
	<div class="formsLeft">Plain Text Content:</div>
	<div class="formsRight">
		<br />
		<textarea name="mail_plain" style="width:100%" class="mailTArea">'.array_get($_POST, 'mail_plain').'</textarea>
	</div>
	
	<input type="hidden" name="_form_submit" value="1" />
	<input type="hidden" name="user_account_num" value="'.$_GET['uid'].'" />
	<input type="submit" name="_submit" value="'.getLang('sform_sendbtn').'" class="submitBtn ui-state-default" />
	<input type="submit" name="_preview" value="'.getLang('sform_previewbtn').'" class="submitBtn ui-state-default" />';

	if(array_get($_GET, 'noheader')==1) {
    	echo '<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'/history.php\';" />';
    }else{
    	echo '<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'mails_mass.php\';" />';
    }
    echo '
	</fieldset>
</form>
</div>';


page_footer();
?>