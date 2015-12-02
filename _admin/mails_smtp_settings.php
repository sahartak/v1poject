<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab']=9;
unset($_SESSION['admin']['uedit']);

if(isset($_POST['_form_submit'])) {
    $connection = new DBConnection();
    $settings = new App\Model\Settings($connection, 'mail_settings');
    
    foreach ($_POST['options'] as $name => $value){
        $settings->update($name, $value);
    }
    
    header('Location: mails_smtp_settings.php');
    exit();
}

function mailForm(){
    $connection = new DBConnection();
	$settings = new App\Model\Settings($connection, 'mail_settings');
    $_POST = $settings->getAll();

    $pcontent='';
    $pcontent.='
<div class="mainHolder">
    <script type="text/javascript" src="js/forms/mailSettings.js"></script>

    <div class="hintHolder ui-state-default">
        <b>Editing Mail Settings</b>
    </div>
    
    <form name="addNewExpDate" method="POST" id="MainForms" action="">
        <fieldset class="mainFormHolder">
            <legend>Transport type</legend>
            <div class="formsLeft">Transport:</div>
            <div class="formsRight">
                <select class="text-input" name="options[mail_transport]" id="mail_transport">
                    <option value="smtp" ' . (array_get($_POST, 'mail_transport') == 'smtp' ? 'selected="selected"' : '') . '>SMTP</option>
                    <option value="mandrill" ' . (array_get($_POST, 'mail_transport') == 'mandrill' ? 'selected="selected"' : '') . '>Mandrill</option>
                </select>
            </div>
        </fieldset>

        <fieldset class="mainFormHolder options options-smtp">
            <legend>SMTP Settings</legend>
            
            <div class="formsLeft">SMTP Host:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_smtp_host]" id="mail_smtp_host" value="'.array_get($_POST, 'mail_smtp_host').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">SMTP User:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_smtp_user]" id="mail_smtp_user" value="'.array_get($_POST, 'mail_smtp_user').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">SMTP Password:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_smtp_password]" id="mail_smtp_password" value="'.array_get($_POST, 'mail_smtp_password').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">SMTP Port:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_smtp_port]" id="mail_smtp_port" value="'.array_get($_POST, 'mail_smtp_port').'" autocomplete="off" />
            </div>
        </fieldset>
        
        <fieldset class="mainFormHolder options options-mandrill">
            <legend>Mandrill Settings</legend>
            
            <div class="formsLeft">Host:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_mandrill_host]" id="mail_mandrill_host" value="'.array_get($_POST, 'mail_mandrill_host').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">Port:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_mandrill_port]" id="mail_mandrill_port" value="'.array_get($_POST, 'mail_mandrill_port').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">Username:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_mandrill_user]" id="mail_mandrill_user" value="'.array_get($_POST, 'mail_mandrill_user').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">API Key:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mail_mandrill_password]" id="mail_mandrill_password" value="'.array_get($_POST, 'mail_mandrill_password').'" autocomplete="off" />
            </div>
        </fieldset>
        
        <fieldset class="mainFormHolder">
            <legend>Sendwithus Settings</legend>
            
            <div class="formsLeft">API Key:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[sendwithus_key]" id="sendwithus_key" value="'.array_get($_POST, 'sendwithus_key').'" autocomplete="off" />
            </div>
            <br />
            <div class="formsLeft">Tags:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[sendwithus_tags]" id="sendwithus_tags" value="'.array_get($_POST, 'sendwithus_tags').'" autocomplete="off" />
            </div>
        </fieldset>
        
        <fieldset class="mainFormHolder">
            <legend>Other Settings</legend>
            
            <div class="formsLeft">Mails to send per script run:</div>
            <div class="formsRight">
                <input class="text-input" type="text" name="options[mails_per_cron]" id="mails_per_cron" value="'.array_get($_POST, 'mails_per_cron').'" autocomplete="off" />
            </div>
        </fieldset>
        
        <input type="hidden" name="_form_submit" value="1" />
        <input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />
        <input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'mails_smtp_settings.php\';" />
    </form>
</div>';
    return $pcontent;
}

page_header();
echo mailForm();
page_footer();
?>