<?php
require '../vendor/autoload.php';

require_once('../classes/db.class.php');
require_once('../includes/timefix.php');
include ('../includes/nomad_mimemail.inc.php');
set_time_limit(900);
$db=new DBConnection();
$today=date('Y-m-d', CUSTOMTIME);
$query='SELECT * FROM global_settings WHERE section="mail_settings"';
$res=$db->rq($query);
$max_mails=0;
$smtp_host=0;
$smtp_port=0;
$smtp_user=0;
$smtp_password=0;
while (($row=$db->fetch($res))!=FALSE){
	if ($row['variable']=='smtp_host'&&$row['variable_value']!='') $smtp_host=$row['variable_value'];
	if ($row['variable']=='smtp_port'&&$row['variable_value']!='') $smtp_port=$row['variable_value'];
	if ($row['variable']=='smtp_user'&&$row['variable_value']!='') $smtp_user=$row['variable_value'];
	if ($row['variable']=='smtp_password'&&$row['variable_value']!='') $smtp_password=$row['variable_value'];
	if ($row['variable']=='mails_per_cron'&&$row['variable_value']) $max_mails=($row['variable_value']+0);
}

$count=1;
$query='SELECT * FROM mail_queue WHERE is_sent=0 ORDER BY mail_queue_id';
$res=$db->rq($query);
while (($row=$db->fetch($res))!=FALSE){
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
	
	$mimemail->set_to($row['mail_to'], $row['mail_to_names']);
	
	$mimemail->set_smtp_host($smtp_host, $smtp_port);
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
		
		$mimemail->set_smtp_host($smtp_host, $smtp_port);
		$mimemail->set_smtp_auth($smtp_user, $smtp_password);
		$mimemail->send();
	}
		
	if ($mimemail->send()){
		$query3='DELETE FROM mail_queue WHERE mail_queue_id='.($row['mail_queue_id']+0).'';
		$db->rq($query3);
	}else{
		$query3='UPDATE mail_queue SET try_sent=(try_sent+1) WHERE mail_queue_id='.($row['mail_queue_id']+0).'';
		$db->rq($query3);
	}
	
	if($count==$max_mails) break;
	$count++;
}
		
$db->close();
?>