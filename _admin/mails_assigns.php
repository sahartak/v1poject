<?php
require_once('template.php');
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
        if($k!='_submit'&&$k!='_form_submit') {
            $k=str_replace('Assign','',$k);
            $query='UPDATE global_settings SET variable_value="'.$x.'" WHERE global_settings_id='.($k+0).'';
            $db->rq($query);
            echo $query.'<br />';
        }
    }
    
    $db->close();
    header('Location: mails_assigns.php');
    exit();
}

function mailForm(){
	$db=new DBConnection();
	$templates=array();
	$templates[0]='Select template to use';
	$query='SELECT mail_templates_id, mail_template_title FROM mail_templates ORDER BY mail_template_title';
	$res=$db->rq($query);
	while(($row=$db->fetch($res)) != FALSE) {
		$templates[$row['mail_templates_id']]=$row['mail_template_title'];
	}
	
    $pcontent='';
    $pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>Editing Mail Settings</b></div> 
<form name="addNewExpDate" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder" style="width:400px;">
	<legend>SMTP Settings</legend>';
	
    $query='SELECT * FROM global_settings WHERE section="mail_assigns"';
	$res=$db->rq($query);
	while(($row=$db->fetch($res)) != FALSE) {
		$pcontent.='
	<div class="formsLeft" style="width:150px;">'.$row['variable'].':</div>
	<div class="formsRight">
		<select name="Assign'.$row['global_settings_id'].'" class="text-input">';
		
		foreach ($templates AS $TemplateID=>$TemplateName) {
			$pcontent.='<option value="'.$TemplateID.'"'.(($TemplateID==$row['variable_value'])?' selected':'').'>'.$TemplateName.'</option>';
		}
		
		$pcontent.='
		</select>
	</div>
	<br />';
	}
	
	
	$pcontent.='
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'mails_assigns.php\';" />
	</fieldset>
</form>
</div>';
	
	$db->close();
    return $pcontent;
}

page_header();
echo mailForm();
page_footer();
?>