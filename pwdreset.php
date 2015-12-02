<?php

require_once('template.php');

//unset($_SESSION['admin']);

if($_SESSION['user']||$_SESSION['admin']) {

	header('Location: index.php');

	exit();

}



page_header_simple();



$SendPassword=0;

$message='';

if ($_POST['_pwdreset1']==1) {

	$db = new DBConnection();

	$query = 'SELECT * FROM users WHERE user_email="'.$db->string_escape($_POST['rform_email']).'" LIMIT 1';

	$res = $db->rq($query);

	$row = $db->fetch($res);

	if (!$row['user_secret_answer']) {

		$message = getLang('reset_noansw');

	}else{

		if(strtolower(trim($_POST['rform_answer']))==strtolower(trim($row['user_secret_answer']))) {

			$SendPassword=1;

		}else{

			$message = getLang('reset_wrong');

		}

	}

}



if($SendPassword==1) {

	$pattern=('/^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/i');

	$check=preg_match($pattern,$_POST['rform_email']);

	if($check==0) {

		$message = getLang('reset_invalid_email');

	}else{

		$db=new DBConnection();

		$query='SELECT u.*, ua1.advisor_names as user_advisor1, ua2.advisor_names as user_advisor2 FROM users u
	    	left join users_advisors ua1 on u.user_advisor1 = ua1.users_advisors_id
	    	left join users_advisors ua2 on u.user_advisor2 = ua2.users_advisors_id
	    	WHERE u.user_email="'.$_POST['rform_email'].'" LIMIT 1';
		$res=$db->rq($query);

		$num_rows=$db->num_rows($res);

		if($num_rows>0) {

			$row=$db->fetch($res);

			addLog('Front-end', 'Login', ''.$row['user_firstname'].' '.$row['user_lastname'].' ('.$row['user']['user_account_num'].')', 0, 'Password reset request.');

			

			/*$possible = '0123456789abcdfghjklmnopqrstuvwxyzABCDFGHJKLMNOPQRSTUVWXYZ';

			$newpass = '';

        	$i = 0;

        	for($i=0;$i<8;$i++) {

        		$newpass.= substr($possible, mt_rand(0, strlen($possible)-1), 1);

        	}

			$query2='UPDATE users SET user_password="'.$newpass.'", user_passisset=0 WHERE users_id='.($row['users_id']+0).'';

			$db->rq($query2);
			*/

			

			$query3='SELECT * FROM mail_templates mt LEFT JOIN global_settings gs ON mt.mail_templates_id=gs.variable_value WHERE variable="Forgot password"';

			$res3=$db->rq($query3);

			$num_rows3=$db->num_rows($res3);

			if($num_rows3>0) {

				$row3=$db->fetch($res3);

				

				$query4='SELECT * FROM global_settings WHERE section="mail_settings"';

				$res4=$db->rq($query4);

				while (($row4=$db->fetch($res4))!=FALSE){

					if ($row4['variable']=='mail_mandrill_host'&&$row4['variable_value']!='') $smtp_host=$row4['variable_value'];

					if ($row4['variable']=='mail_mandrill_port'&&$row4['variable_value']!='') $smtp_port=$row4['variable_value'];

					if ($row4['variable']=='mail_mandrill_user'&&$row4['variable_value']!='') $smtp_user=$row4['variable_value'];

					if ($row4['variable']=='mail_mandrill_password'&&$row4['variable_value']!='') $smtp_password=$row4['variable_value'];

				}

		

				include ('includes/nomad_mimemail.inc.php');

				$mimemail=new nomad_mimemail();

				

				$mimemail->set_charset("UTF-8");

				

				if ($row3['mail_from']!=''){

					$mimemail->set_from($row3['mail_from_mail'], $row3['mail_from']);

					$mimemail->set_reply_to($row3['mail_from_mail'], $row3['mail_from']);

				}else{

					$mimemail->set_from($row3['mail_from_mail']);

					$mimemail->set_reply_to($row3['mail_from_mail']);

				}

				
				$search_for=array('{user_first_name}', '{user_last_name}', '{user_username}', '{user_password}', '{user_password_org}', '{user_account_num}',
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

				$replace_with=array($row['user_firstname'], $row['user_lastname'], $row['user_username'], $row['user_password'], $row['user_password'], $row['user_account_num'],
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

				$row3['mail_html']=str_replace($search_for,$replace_with,$row3['mail_html']);

				$row3['mail_plain']=str_replace($search_for,$replace_with,$row3['mail_plain']);

				

				$t_search_for=array('{thanks}');

				$t_replace_with_html=array($lang['mails_thanks_html']);

				$t_replace_with_plain=array($lang['mails_thanks_plain']);

				$row3['mail_html']=str_replace($t_search_for, $t_replace_with_html, $row3['mail_html']);

				$row3['mail_plain']=str_replace($t_search_for, $t_replace_with_plain, $row3['mail_plain']);

				

				$mimemail->set_subject($row3['mail_subject']);

				$mimemail->set_html($row3['mail_html']);

				$mimemail->set_text($row3['mail_plain']);

				

				$mimemail->set_to($_POST['rform_email'], ''.$row['user_firstname'].' '.$row['user_lastname'].'');

				

				if($row3['mail_bcc']) $mimemail->set_bcc($row3['mail_bcc']);

				

				$mimemail->set_smtp_host($smtp_host, $smtp_port);

				$mimemail->set_smtp_auth($smtp_user, $smtp_password);

				$mimemail->send();

			}

			

			$db->close();

		

			echo '<h3>'.getLang('rform_newpass').'</h3>';

			page_footer();

			exit();

		}else{

			$message = getLang('reset_noemail');

		}

	}

}



$ShowQuestionForm=0;

$SecretQuestion='';

if($_POST['_reqpass']==1||$_POST['_pwdreset1']==1) {

	$pattern=('/^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/i');

	$check=preg_match($pattern,$_POST['rform_email']);

	if($check==0) {

		$_POST['rform_email']='';

		$message='Invalid email';

	}else{

		$db=new DBConnection();

		$query='SELECT * FROM users WHERE user_email="'.$db->string_escape($_POST['rform_email']).'" LIMIT 1';

		$res=$db->rq($query);

		$row=$db->fetch($res);

		if(!$row['user_secret_question']) {

			$message = getLang('reset_noquest');

		}else{

			$SecretQuestion=$row['user_secret_question'];

			$ShowQuestionForm=1;

		}

	}

}



// $ShowQuestionForm=1;
if($ShowQuestionForm==1) {
	include('parts/show_question.php');

}else{
	include('parts/forgot_box.php');


}



page_footer();

?>