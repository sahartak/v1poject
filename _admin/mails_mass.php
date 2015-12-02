<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}
$_SESSION['admin']['selected_tab']=9;
unset($_SESSION['admin']['uedit']);

if(isset($_POST['_submit'])&&$_POST['mail_subject']!=''&&$_POST['mail_html']) {
    $db=new DBConnection();
    foreach ($_POST AS $k=>$x) $_POST[$k]=$db->string_escape($x);
    $mysql_fields='';
    $comma='';
    $count=0;
    foreach ($_POST AS $k=>$x) {
        if($k!='_submit'&&$k!='_form_submit'&&$k!='mail_templates_id'&&$k!='mail_html'&&$k!='mail_plain') {
            if($count!=0) $comma=', ';
            $mysql_fields.=''.$comma.''.$k.'="'.($x).'"';
            $count++;
        }
    }

    set_time_limit(900);
    $query='SELECT u.*, ua1.advisor_names as user_advisor1, ua2.advisor_names as user_advisor2 FROM users u 
    	left join users_advisors ua1 on u.user_advisor1 = ua1.users_advisors_id
    	left join users_advisors ua2 on u.user_advisor2 = ua2.users_advisors_id
    	WHERE u.user_email!="" AND u.user_status=1';
    $res=$db->rq($query);
    while(($row=$db->fetch($res)) != FALSE) {
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
		}*/
		
		$search_for=array('{user_first_name}', '{user_last_name}', '{user_username}', '{user_password}', '{user_password_org}', '{user_account_num}', '{thanks}', '{company_name}', '{site_url}',
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
		$replace_with=array($row['user_firstname'], $row['user_lastname'], $row['user_username'], $row['user_password'], $row['user_password'], $row['user_account_num'], $lang['mails_thanks'], $lang['site_long_name'], $lang['site_url'],
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
	
    	$query2='INSERT INTO mail_queue SET '.$mysql_fields.', admins_id='.($_SESSION['admin']['adminid']+0).', 
    	time_to_send="'.date('Y-m-d H:i:s', CUSTOMTIME).'", create_time="'.date('Y-m-d H:i:s', CUSTOMTIME).'", mail_to="'.$row['user_email'].'", 
    	mail_to_names="'.$row['user_firstname'].' '.$row['user_lastname'].'", mail_html="'.$mail_html.'", mail_plain="'.$mail_plain.'"';
    	$db->rq($query2);
    	
		addLog('Back-end','Mails',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Mass Mail Added');
    }
    
    $db->close();
    header('Location: mails_mass.php');
    exit();
}

page_header();

echo '
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>Sending Mass Mail (to all active clients)</b></div> 
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	editor_selector : "mceEditor",
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : "/css/styles.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",
});
</script>
<form name="addNewMailTemplate" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder" style="width:800px;">
	<legend>Mail information</legend>
	<div class="formsLeft">Use template?</div>
	<div class="formsRight">
		<select name="mail_templates_id" class="text-input" onchange="this.form.submit();">
			<option value="0">Select template to use</option>';

	$db=new DBConnection();
	
	if(($_POST['mail_templates_id']+0)>0) {
		$query='SELECT * FROM mail_templates WHERE mail_templates_id='.($_POST['mail_templates_id']+0).' LIMIT 1';
		$res=$db->rq($query);
		$_POST=$db->fetch($res);
	}else{
		$_POST='';
	}
	
	$query='SELECT mail_templates_id, mail_template_title FROM mail_templates WHERE mail_single=1 ORDER BY mail_template_title';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		echo '<option value="'.$row['mail_templates_id'].'"'.(($row['mail_templates_id']==$_POST['mail_templates_id'])?' selected':'').'>'.$row['mail_template_title'].'</option>';
	}

	echo '
		</select>
	</div>
	
	<br />
	<div class="formsLeft">Mail From:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_from_mail" id="mail_from_mail" value="'.$_POST['mail_from_mail'].'" />
		(ex: noreply@site.com)
	</div>
	
	<br />
	<div class="formsLeft">Mail BCC:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_bcc" id="mail_bcc" value="'.$_POST['mail_bcc'].'" />
		(ex: noreply@site.com)
	</div>
	
	<br />
	<div class="formsLeft">Mail From Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_from" id="mail_from" value="'.$_POST['mail_from'].'" />
		(ex: John Doe)
	</div>
	
	<br />
	<div class="formsLeft">Mail Subject:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_subject" id="mail_subject" value="'.$_POST['mail_subject'].'" />
	</div>
	
	<br />
	<div class="formsLeft">HTML Content:</div>
	<div class="formsRight">
		<br />
		<textarea name="mail_html" style="width:100%" class="mceEditor">'.$_POST['mail_html'].'</textarea>
	</div>
	
	<br />
	<div class="formsLeft">Plain Text Content:</div>
	<div class="formsRight">
		<br />
		<textarea name="mail_plain" style="width:100%" class="mailTArea">'.$_POST['mail_plain'].'</textarea>
	</div>
	
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_sendbtn').'" class="submitBtn ui-state-default" />
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'mails_mass.php\';" />
	</fieldset>
</form>
</div>';

page_footer();
?>