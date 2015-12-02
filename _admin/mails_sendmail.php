<?php
require_once('template.php');

if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab'] = 7;
unset($_SESSION['admin']['uedit']);
set_time_limit(900);

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Sending Mails</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="content-language" content="en" />
<meta name="language" content="en" />
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<link href="/css/styles.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="top">
    <div style="text-align:center;margin: 10px auto;color:#000000;width:300px;" id="BaseHolder">
		<img src="/images/lploader.gif" border="0"><br />
		<b>Attempting to send mails, please wait...</b>
	</div>';

$db=new DBConnection();

if($_GET['action']=='single'&&($_GET['mailid']+0)>0) { 
	$query='SELECT * FROM mail_queue WHERE mail_queue_id='.($_GET['mailid']+0).' AND is_sent=0';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if($num_rows>0) {
		$row=$db->fetch($res);
		
        $settingsModel = new App\Model\Settings($db, 'mail_settings');
        $settings = $settingsModel->getAll();
        
        $transport = $settings['mail_transport'];
        
        $smtp_host = $settings['mail_' . $transport . '_host'];
        $smtp_port = $settings['mail_' . $transport . '_port'];
        $smtp_user = $settings['mail_' . $transport . '_user'];
        $smtp_password = $settings['mail_' . $transport . '_password'];
		
		include ('../includes/nomad_mimemail.inc.php');
		$mimemail = new nomad_mimemail();
		
		$mimemail->set_charset("UTF-8");
		
		if($row['mail_from']!='') {
			$mimemail->set_from($row['mail_from_mail'], $row['mail_from']);
			$mimemail->set_reply_to($row['mail_from_mail'], $row['mail_from']);
		}else{
			$mimemail->set_from($row['mail_from_mail']);
			$mimemail->set_reply_to($row['mail_from_mail']);
		}
		
		$mimemail->set_subject($row['mail_subject']); 
		$mimemail->set_html($row['mail_html']);
		$mimemail->set_text($row['mail_plain']);
		
		$mimemail->set_to($row['mail_to'], $row['mail_to_names']);
		
		//$mimemail->set_smtp_log(true); // If you need debug SMTP connection
		$mimemail->set_smtp_host($smtp_host,$smtp_port);
		$mimemail->set_smtp_auth($smtp_user, $smtp_password);
		
		if ($row['mail_bcc']){
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
			
			//$mimemail->set_smtp_log(true); // If you need debug SMTP connection
			$mimemail->set_smtp_host($smtp_host, $smtp_port);
			$mimemail->set_smtp_auth($smtp_user, $smtp_password);
			$mimemail->send();
		}
		
		if ($mimemail->send()){
			$query3='DELETE FROM mail_queue WHERE mail_queue_id='.($_GET['mailid']+0).'';
			$db->rq($query3);
			echo '
	<div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
		<b>'.$num_rows.' mail'.(($num_rows>1)?'s were':' was').' sent successfully...</b>
	</div>';
		}else{
			$query3='UPDATE mail_queue SET try_sent=(try_sent+1) WHERE mail_queue_id='.($_GET['mailid']+0).'';
			$db->rq($query3);
		echo '
	<div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
		<b>An error has occurred,'.(($num_rows>1)?' mails were':' mail was').' not sent!</b>
	</div>';
		}
		//echo "<br><br><textarea cols=80 rows=30>" . $mimemail->get_smtp_log() . "</textarea>"; // If you need debug SMTP connection
	}else{
		echo '
	<div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
		<b>No mail with such id or mail is already sent!</b>
	</div>';
	}
}elseif($_GET['action']=='sendall') { 
	$query='SELECT * FROM mail_queue WHERE is_sent=0';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	if($num_rows>0) {
		$query2='SELECT * FROM global_settings WHERE section="mail_settings"';
		$res2=$db->rq($query2);
		while(($row2=$db->fetch($res2)) != FALSE) {
			if($row2['variable']=='smtp_host'&&$row2['variable_value']!='') $smtp_host=$row2['variable_value'];
			if($row2['variable']=='smtp_port'&&$row2['variable_value']!='') $smtp_port=$row2['variable_value'];
			if($row2['variable']=='smtp_user'&&$row2['variable_value']!='') $smtp_user=$row2['variable_value'];
			if($row2['variable']=='smtp_password'&&$row2['variable_value']!='') $smtp_password=$row2['variable_value'];
		}
		include ('includes/nomad_mimemail.inc.php');
		
		while(($row=$db->fetch($res)) != FALSE) {
			$mimemail = new nomad_mimemail();
		
			$mimemail->set_charset("UTF-8");
		
			if($row['mail_from']!='') {
				$mimemail->set_from($row['mail_from_mail'], $row['mail_from']);
				$mimemail->set_reply_to($row['mail_from_mail'], $row['mail_from']);
			}else{
				$mimemail->set_from($row['mail_from_mail']);
				$mimemail->set_reply_to($row['mail_from_mail']);
			}
		
			$mimemail->set_subject($row['mail_subject']); 
			$mimemail->set_html($row['mail_html']);
			$mimemail->set_text($row['mail_plain']);
		
			$mimemail->set_to($row['mail_to'], $row['mail_to_names']);
		
			//$mimemail->set_smtp_log(true); // If you need debug SMTP connection
			$mimemail->set_smtp_host($smtp_host,$smtp_port);
			$mimemail->set_smtp_auth($smtp_user, $smtp_password);
			if ($mimemail->send()){
				$query3='DELETE FROM mail_queue WHERE mail_queue_id='.($row['mail_queue_id']+0).'';
				$db->rq($query3);
			echo '
	<div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
		<b>'.$num_rows.' mail'.(($num_rows>1)?'s were':' was').' sent successfully...</b>
	</div>';
			}else{
				$query3='UPDATE mail_queue SET try_sent=(try_sent+1) WHERE mail_queue_id='.($row['mail_queue_id']+0).'';
				$db->rq($query3);
		echo '
	<div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
		<b>An error has occurred,'.(($num_rows>1)?' mails were':' mail was').' not sent!</b>
	</div>';
			}
		//echo "<br><br><textarea cols=80 rows=30>" . $mimemail->get_smtp_log() . "</textarea>"; // If you need debug SMTP connection
		}
	}else{
		echo '
	<div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
		<b>No mail with such id or mail is already sent!</b>
	</div>';
	}
}

$db->close();
		echo '
<script type="text/javascript">
	$("#BaseHolder").hide();
	$("#EndHolder").show();
</script>
</div>
</body>
</html>';
?>