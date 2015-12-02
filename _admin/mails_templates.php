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
if(isset($_POST['_form_submit'])) {
    $db=new DBConnection();
    foreach ($_POST AS $k=>$x) $_POST[$k]=$db->string_escape($x);
    $mysql_fields='';
    $comma='';
    $count=0;
    foreach ($_POST AS $k=>$x) {
        if($k!='mtid'&&$k!='_submit'&&$k!='_form_submit'&&$k!='template_version'&&$k!='mail_html'&&$k!='mail_pain' &&$k!= 'template_name') {
            if($count!=0) $comma=', ';
            $mysql_fields.=''.$comma.''.$k.'="'.($x).'"';
            $count++;
        }
    }

    if($_POST['mtid']!='') {
        $query='UPDATE mail_templates SET '.$mysql_fields.' WHERE mail_templates_id="'.$_POST['mtid'].'"';
        $db->rq($query);
    }else {
        $query='INSERT INTO mail_templates SET '.$mysql_fields.'';
        $db->rq($query);
    }
    
    $db->close();

    header('Location: mails_templates.php');
    exit();
}

function addNewMailTemplate($mail_templates_id=0) {
	$db=new DBConnection();
	
    if($mail_templates_id&&!$_POST['_form_submit']) {
        $_SESSION['admin']['uedit']=$mail_templates_id;
        
        $query='SELECT * FROM mail_templates WHERE mail_templates_id='.($mail_templates_id+0).'';
        $res=$db->rq($query);
        foreach ($db->fetch($res) AS $RowName=>$RowValue) {
            $_POST[$RowName]=$RowValue;
        }
    }

	$settingsModel = new App\Model\Settings($db, 'mail_settings');
    $settings = $settingsModel->getAll();

    $API_KEY = $settings['sendwithus_key'];
    $options = array();
    $api = new API($API_KEY, $options);
    $response = $api->emails();
    $tags = explode(',', trim($settings['sendwithus_tags']));
    
    $selectTemplateHtml = '<option value="">Empty</option>';
    foreach($response as $template)
    {
    	$matched = count(array_filter($tags)) == 0;
    	foreach($tags as $tag){
    		if (isset($template->tags) && in_array(trim($tag), $template->tags)) {
				$matched = true;
				break;
			}
    	}
    	
    	if($matched){
    		$selectTemplateHtml .= "<option value='". $template->id ."' ".(isset($_POST['mail_external_id']) && $_POST['mail_external_id'] == "$template->id" ? "selected='selected'" : "") .">". $template->name ."</option>";
		}
    }
    // End
    
    $db->close();
    
	$templateVariables = Array(
    	'mail_template_title',
		'user_first_name',
       	'user_username',
		'user_last_name',
        'user_account_num',
    	'user_password',
		'user_password_org',
		'trade_details',
 		'trade_date',
      	'trade_sell_status',
 		'trade_buy_status',
 		'trade_value',
		'transfer_value',
		'transfer_date',
		'thanks',
		'company_name',
		'site_url',
		'funding_overviews',
		'trading_overviews',
		'trade_ref',
		'user_account_name',
		'user_admin_ref',
		'user_phone',
		'user_email',
		'user_mailing_address',
		'user_city',
		'user_state',
		'user_postal',
		'user_country',
		'user_advisor1',
		'user_advisor2',
		'user_app_date'
    );
    
    sort($templateVariables);
    
    $templateVariablesContent = '';
    
    if(count($templateVariables) == 0){
    	$templateVariablesContent = '<p>Variables are not defined for this template type.</p>';
   	}else{
   		$templateVariablesContent .= '<ul class="variable_list">';
   		foreach($templateVariables as $var){
   			$templateVariablesContent .= "<li>{{$var}}</li>";
   		}
   		$templateVariablesContent .= '</ul>';
   	}

    $pcontent='';
    $pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($mail_templates_id>0)?'Editing':'Creating New').' Mail Template</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<link type="text/css" href="css/basic.css" rel="stylesheet" media="screen" />

<script type="text/javascript">

jQuery(function ($) {
	$(".basic").click(function (e) {
		var themeId  = $("#MailTemplate").val();
		var contentBody = tinyMCE.get("mail_html").getContent();
		
		$.ajax({
		  type:"post",
		  url: "ajax_theme.php",
		  data: {action: "GetTemplateById" ,themeId : themeId, contentBody:contentBody },
		  success: function(data) {
		  	$(".mailTArea").html(data);
		  	tinyMCE.get("mail_html").setContent(data);
          }
		})
		
		return false;
	});

});

$(document).ready(function(){
    ShowTemplate();
});

$(document).ready(function(){
    $("#MailTemplate").change(function(){
        tinyMCE.get("mail_html").setContent("loading...", {format : "raw"});
        $(".mailTArea").html("loading...");
        ShowTemplate();
    });
});

function ShowTemplate(){
     var externalId = $("#MailTemplate").val();

        $.ajax({
		  type:"post",
		  url: "ajax_theme.php",
		  dataType: "json",
		  data: {action: "GetTemplateById" ,templateId : externalId },
		  success: function(data) {
            tinyMCE.get("mail_html").setContent(data.html, {format : "raw"});
            $(".mailTArea").html(data.text);
            $("#template_name").val(data.name);
            $("#template_version").val(data.id);
          }
		});
}

tinyMCE.init({
	// General options
	mode : "textareas",
        theme : "advanced",
        editor_selector : "mceEditor",
        readonly : true,
        visual: false
});
</script>

<div id="basic-modal-content" style="display:none">
</div>
		
<form name="addNewMailTemplate" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder left" style="width:800px;">
	<legend>Template information</legend>
	<div class="formsLeft">Title:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="mail_template_title" id="mail_template_title" value="'.$_POST['mail_template_title'].'" />
		(used in admin area only)
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
	<div class="formsLeft">Auto Mail?:</div>
	<div class="formsRight">
		<select name="mail_single" class="text-input">
			<option value="1"'.(($_POST['mail_single']==1)?' selected':'').'>No</option>
			<option value="0"'.(($_POST['mail_single']==0)?' selected':'').'>Yes</option>
		</select>
	</div>
	
	<br />
	<div class="formsLeft">Theme:</div>
	<div class="formsRight">
		<select name="mail_external_id" id="MailTemplate" class="text-input">'.$selectTemplateHtml.'</select>
	</div>

	<br />
	<div class="formsLeft">HTML Content:</div>
	<div class="formsRight">
		<br />
		<textarea name="mail_html" style="width:100%" class="mceEditor">Loading...</textarea>
	</div>
	
	<br />
	<div class="formsLeft">Plain Text Content:</div>
	<div class="formsRight">
		<br />
		<textarea name="mail_plain" style="width:100%" class="mailTArea">Loading...</textarea>
	</div>
	<input type="hidden" id="template_name" name="template_name" value="" />
	<input type="hidden" id="template_version" name="template_version" value="" />
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
    if($mail_templates_id) {
        $pcontent.='
	<input type="hidden" name="mtid" value="'.$mail_templates_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this mail template?\')) location=\'?action=delete&mtid='.($_POST['mail_templates_id']+0).'\';" />';
    }
    $pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'mails_templates.php\';" />
	</fieldset>
	
	<fieldset class="mainFormHolder left" style="width: 300px;">
    	<legend>Variables</legend>
        '.$templateVariablesContent.'
	</fieldset>
	<br class="clear" />
</form>
</div>';
    return $pcontent;
}

function listMailTemplates() {
    $pcontent='';
    $pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_mail_templates.js"></script>
<div class="mainHolderSmaller">
    <div class="hintHolder ui-state-default"><b>List All Mail Templates</b></div>
    <div class="simpleHolder">Actions: <a href="'.THISPAGE.'?action=new">add new</a></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
        <thead>
            <tr>
                <th><b>#</b></th>
                <th><b>Template Title</b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="dataTables_empty">Loading data from server</td>
            </tr>
        </tbody>
    </table>
</div>';

    return $pcontent;
}

if (isset($_GET['action'])) {
    $cmd=($_GET['action']);
}else {
    $cmd='';
}

if (isset($_POST['_back']))	$cmd='';
$page_content='';
switch	($cmd) {
    case 'new':
        $page_content=addNewMailTemplate();
        break;
    case 'edit':
        $page_content=addNewMailTemplate($_GET['mtid']+0);
        break;
    case 'delete'	:
        if($_SESSION['admin']['is_logged']==1) {
            $db=new DBConnection();
            $query='DELETE FROM mail_templates WHERE mail_templates_id='.($_GET['mtid']+0);
            $db->rq($query);

            $db->close();
            header('Location: mails_templates.php');
            exit();
        }
        break;
    default	:
        $page_content=listMailTemplates();
        break;
}

page_header();
echo $page_content;
page_footer();
?>