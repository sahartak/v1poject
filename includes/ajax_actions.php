<?php
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
class AjaxActions {

	/**
	 * Database connection
	 * @var \DBConnection
	 */
	protected $connection;

	public function __construct(DBConnection $connection) {
		$this->connection = $connection;
	}

	/**
	 * Adds stock to the watch list
	 */
	public function addStockwatch() {
		$return = array();

		if (isset($_POST['stock'])) {
			$watchlist = new App\Model\Watchlist($this->connection);

			$data = array(
				'stock_name' => $_POST['stock'],
				'stock_exch' => $_POST['exch'],
				'user_account_num' => $_SESSION['user']['user_account_num']
			);

			if (false !== ($id = $watchlist->insert($data))) {
				$return['success'] = true;
				$return['id']      = $id;
				$return['name']    = $data['stock_name'];
			}
			else {
				$return['success'] = false;
			}
		}
		else {
			$return['success'] = false;
		}

		echo json_encode($return);
	}

	/**
	 * Removes stochwatch
	 */
	public function removeStockwatch() {
		$return = array();

		if (isset($_POST['id'])) {
			$watchlist = new App\Model\Watchlist($this->connection);

			if ($watchlist->delete($_POST['id'])) {
				$return['success'] = true;
			}
			else {
				$return['success'] = false;
			}
		}
		else {
			$return['success'] = false;
		}

		echo json_encode($return);
	}

	public function resetPassword() {
		$db=new DBConnection();
		$return = array();
		$query='SELECT * FROM users WHERE user_email="'.$db->string_escape($_POST['rform_email']).'" LIMIT 1';

		$res=$db->rq($query);

		$row=$db->fetch($res);

		if(!isset($row['user_secret_question'])) {
			$return['error'] = getLang('reset_noquest');
		}else{
			$return['question_msg'] = getLang('reset_secret_title');
			$return['question'] = $row['user_secret_question'];
		}
		echo json_encode($return);
	}

	public function resetPasswordAnswer() {
		$db = new DBConnection();
		$return = array();
		$query = 'SELECT * FROM users WHERE user_email="'.$db->string_escape($_POST['rform_email']).'" LIMIT 1';
		$res = $db->rq($query);
		$row = $db->fetch($res);

		if (!isset($row['user_secret_answer'])) {
			$return['error'] = getLang('reset_noansw');
		} else{

			if(strtolower(trim($_POST['rform_answer']))==strtolower(trim($row['user_secret_answer']))) {
				$pattern=('/^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/i');
				$check=preg_match($pattern,$_POST['rform_email']);
				if($check==0) {
					$return['error'] = getLang('reset_invalid_email');
				} else{

					$db=new DBConnection();
					$query='SELECT u.*, ua1.advisor_names as user_advisor1, ua2.advisor_names as user_advisor2 FROM users u
							left join users_advisors ua1 on u.user_advisor1 = ua1.users_advisors_id
							left join users_advisors ua2 on u.user_advisor2 = ua2.users_advisors_id
							WHERE u.user_email="'.$_POST['rform_email'].'" LIMIT 1';
					$res=$db->rq($query);
					$num_rows=$db->num_rows($res);

					if($num_rows>0) {
						$row=$db->fetch($res);
						addLog('Front-end', 'Login', ''.$row['user_firstname'].' '.$row['user_lastname'].' ('.$row['user_account_num'].')', 0, 'Password reset request.');

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

							include ('nomad_mimemail.inc.php');

							$mimemail=new nomad_mimemail();
							$mimemail->set_charset("UTF-8");

							if ($row3['mail_from']!=''){
								$mimemail->set_from($row3['mail_from_mail'], $row3['mail_from']);
								$mimemail->set_reply_to($row3['mail_from_mail'], $row3['mail_from']);
							} else{

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
							$t_replace_with_html=array(getLang('mails_thanks_html'));
							$t_replace_with_plain=array(getLang('mails_thanks_plain'));
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


						$return['success'] = getLang('rform_newpass');
					} else{
						$return['error'] = getLang('reset_noemail');
					}
				}
			} else{
				$return['error'] = getLang('reset_wrong');
			}
		}
        if(isset($return['error']))
            $return['error'] = strip_tags($return['error']);
		echo json_encode($return);
	}
}