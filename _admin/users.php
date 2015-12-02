<?php
require_once('template.php');
if(!isAppLoggedIn()) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab']=0;
unset($_SESSION['admin']['uedit']);

$userTitles = array(1 => 'Mr.', 2 => 'Mrs.', 3 => 'Miss', 4 => 'Dr.', 5 => 'Pr.');
$userBankCodeTypes = array( 1 => 'SWIFT Code', 2 => 'IBAN Code', 3 => 'ABA #', 4 => 'BSC Code');

$db = new DBConnection();

$db->close();

if(isset($_POST['_form_submit'])) {
    $db=new DBConnection();
    $mysql_fields='';
    $comma='';
    $count=0;
    foreach ($_POST AS $k=>$x) {
        if($k!='usid'&&$k!='_submit'&&$k!='_form_submit'&&$k!='user_refid') {
            if($count!=0) $comma=', ';
            $mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';
            $count++;
        }
    }

    if($_POST['usid']!='') {
        $query='UPDATE users SET '.$mysql_fields.' WHERE user_account_num="'.$_POST['usid'].'"';
        $db->rq($query);
        
        addLog('Back-end','Accounts',''.$_POST['user_firstname'].' '.$_POST['user_lastname'].' ('.$_POST['usid'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','User edited');
    }else {
        $user_fullref=''.$_POST['user_ref'].'-'.$_POST['user_refid'].'';
        $user_uid=UID;
        $query='INSERT INTO users SET '.$mysql_fields.', user_fullref="'.$user_fullref.'", user_uid="'.$user_uid.'"';
        $db->rq($query);
        
        addLog('Back-end','Accounts',''.$_POST['user_firstname'].' '.$_POST['user_lastname'].' ('.$_POST['usid'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','User added');
    }
    $db->close();
    header('Location: users.php');
    exit();
}

function addNewUser($users_id=0) {
    $db=new DBConnection();
    
    if($users_id && !array_get($_POST, '_form_submit', false)) {
        $query='SELECT * FROM users WHERE user_account_num="'.$users_id.'"';
        $res=$db->rq($query);
        $_POST=$db->fetch($res);
        $_SESSION['admin']['uedit']=$_POST['users_id'];
        $FullREF=explode('-', $_POST['user_fullref']);
        $UserNID=$FullREF[1];

        $JSCripts='';
    }else {
        $JSCripts=' onkeyup="generateAccountInfos();" onblur="generateAccountInfos();"';
        $_POST['user_password']='xy'.date('d', CUSTOMTIME).'r89';
        $_POST['user_app_date']=date('Y-m-d', CUSTOMTIME);
    }

    global $userTitles;
    global $userStatuses;
    global $userBankCodeTypes;

    $pcontent='';
    $pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($users_id>0)?'Editing':'Creating New').' User Account</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/users.js"></script>
<form name="addNewUser" method="POST" id="MainForms" action="">

<div class="left">
	<fieldset class="mainFormHolder left minHeight200">
	<legend>Contact Information</legend>
	<div class="formsLeft">Title:</div>
	<div class="formsRight">
		<select name="user_title" class="text-input">';


    foreach ($userTitles AS $TitleID=>$TitleName) {
        $selected='';
        if(array_get($_POST, 'user_title') == $TitleID){
            $selected=' selected';
        }
        $pcontent.='<option value="'.$TitleID.'"'.$selected.'>'.$TitleName.'</option>';
    }

    $pcontent.='
		</select>
	</div>
	<br />  	
	
	<div class="formsLeft">First Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_firstname" id="user_firstname" value="'.array_get($_POST, 'user_firstname').'"'.$JSCripts.' />
	</div>
	<br />

	<div class="formsLeft">Middle Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_middlename" id="user_middlename" value="'.array_get($_POST, 'user_middlename').'"'.$JSCripts.' />
	</div>
	<br />

	<div class="formsLeft">Last Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_lastname" id="user_lastname" value="'.array_get($_POST, 'user_lastname').'"'.$JSCripts.' />
	</div>
	<br />
 	
	<div class="formsLeft">Email:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_email" id="user_email" value="'.array_get($_POST, 'user_email').'" />
	</div>
	<br />
	
	<div class="formsLeft">Phone:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_phone" id="user_phone" value="'.array_get($_POST, 'user_phone').'" />
	</div>
	<br />
	<div class="formsLeft">Mailing Address:</div>
	<div class="formsRight">
	    <textarea class="text-area-small2rows" name="user_mailing_address" id="user_mailing_address" rows="2" cols="1">'.array_get($_POST, 'user_mailing_address').'</textarea>
	</div>
	<br />
	<div class="formsLeft">City:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_city" id="user_city" value="'.array_get($_POST, 'user_city').'" />
	</div>
	<br />
	<div class="formsLeft">State/Province:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_state" id="user_state" value="'.array_get($_POST, 'user_state').'" />
	</div>
	<br />
	<div class="formsLeft">Postal Code/ZIP:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_postal" id="user_postal" value="'.array_get($_POST, 'user_postal').'" />
	</div>
	<br />
	<div class="formsLeft">Country:</div>
	<div class="formsRight">
	<select name="user_country" id="user_country" class="text-input">';

    $query='SELECT country_full FROM countries ORDER BY country_full';
    $res=$db->rq($query);
    while (($row=$db->fetch($res)) != FALSE) {
        $selected='';
        if(array_get($_POST, 'user_country')==$row['country_full']) $selected=' selected';
        $pcontent.='<option value="'.$row['country_full'].'"'.$selected.'>'.$row['country_full'].'</option>';
    }

    $pcontent.='
		</select>
	</div>
	<br />

	<div class="moreRight" id="showMoreDetails">more details &raquo;</div>
	
	<span id="moreDetails">
	<br />
	<div class="formsLeft">Fax:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_fax" id="user_fax" value="'.array_get($_POST, 'user_fax').'" />
	</div>
	<br />
	<div class="formsLeft">Secondary Email:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_email2" id="user_email2" value="'.array_get($_POST, 'user_email2').'" />
	</div>
	<br />
	<div class="formsLeft">Company:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_company" id="user_company" value="'.array_get($_POST, 'user_company').'" />
	</div>
	<br />
	<div class="formsLeft">Web Page:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_web" id="user_web" value="'.array_get($_POST, 'user_web').'" />
	</div>
	</span>
	</fieldset>
	
	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Trading Advisor</legend>
	<div class="formsLeft">Advisor 1:</div>
	<div class="formsRight">
		<select name="user_advisor1" class="text-input">
			<option value="0">Select primary advisor</option>';

    $query='SELECT * FROM users_advisors ORDER BY advisor_names';
    $res=$db->rq($query);
    while(($row=$db->fetch($res)) != FALSE) {
        $pcontent.='<option value="'.$row['users_advisors_id'].'"'.(($row['users_advisors_id']==array_get($_POST, 'user_advisor1'))?' selected':'').'>'.$row['advisor_names'].' / '.$row['advisor_ref'].'</option>';
    }

    $pcontent.='
		</select>
	</div>
	<br />
	<div class="formsLeft">Advisor 2:</div>
	<div class="formsRight">
		<select name="user_advisor2" class="text-input">
			<option value="0">Select 2nd advisor</option>';

    $query='SELECT * FROM users_advisors ORDER BY advisor_names';
    $res=$db->rq($query);
    while(($row=$db->fetch($res)) != FALSE) {
        $pcontent.='<option value="'.$row['users_advisors_id'].'"'.(($row['users_advisors_id']==array_get($_POST, 'user_advisor2'))?' selected':'').'>'.$row['advisor_names'].' / '.$row['advisor_ref'].'</option>';
    }

    $pcontent.='
		</select>
	</div>
	</fieldset>
	
	
	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Bank Details</legend>
	<div class="moreRight" id="showBankDetails">show bank details &raquo;</div>
	
	<span id="moreBankDetails">
	<div class="formsLeft">Beneficiary:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_bank_beneficiary" id="user_bank_beneficiary" value="'.array_get($_POST, 'user_bank_beneficiary').'" />
	</div>
	<br />
	<div class="formsLeft">Bank Address:</div>
	<div class="formsRight">
		<textarea class="text-area" name="user_bank_address" id="user_bank_address">'.array_get($_POST, 'user_bank_address').'</textarea>
	</div>
	<br />
	<div class="formsLeft">Bank Account:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_bank_account" id="user_bank_account" value="'.array_get($_POST, 'user_bank_account').'" />
	</div>
	<br />
	<div class="formsLeft">Bank Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_bank_name" id="user_bank_name" value="'.array_get($_POST, 'user_bank_name').'" />
	</div>
	<br />
	<div class="formsLeft">
		<select name="user_bank_codetype" class="select-medium">';

    foreach ($userBankCodeTypes AS $BankCodeID=>$BankCodeType) {
        $pcontent.='<option value="'.$BankCodeID.'"'.(($BankCodeID==array_get($_POST, 'user_bank_codetype'))?' selected':'').'>'.$BankCodeType.'</option>';
    }

    $pcontent.='
		</select>
	</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_bank_code" id="user_bank_code" value="'.array_get($_POST, 'user_bank_code').'" />
	</div>
	<br />
	<div class="formsLeft">More Bank Details:</div>
	<div class="formsRight">
	    <textarea class="text-area" name="user_bank_moredetails" id="user_bank_moredetails">'.array_get($_POST, 'user_bank_moredetails').'</textarea>
	</div>
	</span>
	</fieldset>
</div>

<div class="left">
	<fieldset class="mainFormHolder left minHeight200">
	<legend>Account Information</legend>
	<div class="formsLeft">Admin Reference:</div>
	<div class="formsRight">
		<input class="text-input-smaller" type="text" name="user_ref" id="user_ref" value="'.((array_get($_POST, 'user_ref')!='')?''.$_POST['user_ref'].'':''.$_SESSION['admin']['refnum'].'').'" readonly />
		<input class="text-input-small" type="text" name="user_refid" id="user_refid" value="'.((isset($UserNID))?''.$UserNID.'':''. NID.'').'" readonly />
	</div>
	<br />
	<div class="formsLeft">Account Number:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_account_num" id="user_account_num" value="'.(($users_id!='')?''.$users_id.'':''. NID.'').'" readonly />
	</div>
	<br />
	<div class="formsLeft">Account Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_account_name" id="user_account_name" value="'.array_get($_POST, 'user_account_name').'" />
	</div>
	<br />
	<div class="formsLeft">Username:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_username" id="user_username" value="'.array_get($_POST, 'user_username').'" />
	</div>
	<br />
	<div class="formsLeft">Password:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="user_password" id="user_password" value="'.array_get($_POST, 'user_password').'" />
	</div>
	<br />
	
	<div class="formsLeft">Secret question:</div>
	<div class="formsRight">
	    <input class="text-input" type="text" name="user_secret_question" id="user_secret_question" value="'.array_get($_POST, 'user_secret_question').'" />
	</div>
	<br />
	
	<div class="formsLeft">Secret answer:</div>
	<div class="formsRight">
	    <input class="text-input" type="text" name="user_secret_answer" id="user_secret_answer" value="'.array_get($_POST, 'user_secret_answer').'" />
	</div>
	
	<br />
	<div class="formsLeft">Application Date:</div>
	<div class="formsRight">
	    <input class="text-input" type="text" name="user_app_date" id="user_app_date" value="'.array_get($_POST, 'user_app_date').'" />
	</div>
	<br />
	<div class="formsLeft">Status:</div>
	<div class="formsRight">
		<select name="user_status" class="text-input">';

    foreach ($userStatuses AS $StatusID=>$StatusName) {
        $pcontent.='<option value="'.$StatusID.'"'.(($StatusID==array_get($_POST, 'user_status'))?' selected':'').'>'.$StatusName.'</option>';
    }

    $pcontent.='
		</select>
	</div>
	<br />
	<div class="formsLeft">Trading Type:</div>
	<div class="formsRight">
		<select name="trading_type" class="text-input">';
		$pcontent.='<option value="3"'.((array_get($_POST, 'trading_type')==3)?' selected':'').'>Both</option>';
		$pcontent.='<option value="1"'.((array_get($_POST, 'trading_type')==1)?' selected':'').'>Options</option>';
		$pcontent.='<option value="2"'.((array_get($_POST, 'trading_type')==2)?' selected':'').'>Stocks</option>';
	$pcontent.='
		</select>
	</div>
	</fieldset>
	
	<div class="clear"></div>
	
	<fieldset class="mainFormHolder left">
	<legend>Notes</legend>
	<div class="formsRight">
		<textarea class="text-area-big" name="user_notes" id="user_notes">'.array_get($_POST, 'user_notes').'</textarea>
	</div>
	</fieldset>

	<div class="clear"></div>
	
	<div class="mainFormHolder left btnsHolder">
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
    if($users_id) {
        $pcontent.='
	<input type="hidden" name="usid" value="'.$users_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this user?\')) location=\'?action=delete&uid='.(array_get($_POST, 'user_uid')).'\';" />
	<input type="button" name="_logs" value="'.getLang('sform_logsbtn').'" class="submitBtn ui-state-default" onclick="location=\'?action=logs&uid='.(array_get($_POST, 'user_uid')).'\';" />';
    }
    $pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'users.php\';" />
	</div>
</div>
</form>
</div>';
    $db->close();
    return $pcontent;
}

function listUsers() {
    $pcontent='';

    $MoreTitle='';
    if (isset($_GET['view'])) {
	if($_GET['view']=='active') $MoreTitle.=' (active only)';
	if($_GET['view']=='disabled') $MoreTitle.=' (disabled only)';
	if($_GET['view']=='pending') $MoreTitle.=' (acpendingtive only)';
	if($_GET['view']=='trades2') $MoreTitle.=' (with 2 or more trades)';
	if($_GET['view']=='trades1') $MoreTitle.=' (with only 1 trade)';
	if($_GET['view']=='trades0') $MoreTitle.=' (without any trade)';
	
	$pcontent.='<input type="hidden" value="'.$_GET['view'].'" name="subSearchType" id="subSearchType" />';
    }

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
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/js/jquery.dataTables.addons.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_users.js"></script>
<div class="mainHolderUsers" style="width: 97%;">
	<div class="hintHolder ui-state-default"><b>List All User Accounts'.$MoreTitle.'</b></div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="usersTable">
	<thead>
		<tr>
			<th><b>Account #</b></th>
			<th><b>Acount name</b></th>
			<th><b>First name</b></th>
			<th><b>Last name</b></th>
			<th><b>Applied</b></th>
			<th><b>Trades</b></th>
			<th><b>Logins</b></th>
			<th><b>Status</b></th>
			<th><b>Last update</b></th>
			<th><b>LSCP</b></th>
			<th><b>HPSP</b></th>
			<th><b>Balance</b></th>
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

if (isset($_GET['action'])) {
    $cmd = $_GET['action'];
}else {
    $cmd = '';
}

if (isset($_POST['_back'])) {
    $cmd='';
}

$page_content = '';

switch	($cmd) {
    case 'new':
        $page_content=addNewUser();
        break;
    case 'edit':
        $exp="/[^a-zA-Z0-9]/i";
        $check=preg_match($exp, $_GET['uid']);
        if(($check+0)==1) {
            header('Location: users.php');
            exit();
        }else {
            $page_content=addNewUser($_GET['uid']);
        }
        break;
    case 'delete'	:
        if(isAppLoggedIn()) {
            $exp="/[^a-zA-Z0-9]/i";
            $check=preg_match($exp, $_GET['uid']);
            if(($check+0)==1) {
                header('Location: users.php');
                exit();
            }
            $db=new DBConnection();
            
            $uDetails=$db->getRow('users','user_uid="'.$_GET['uid'].'"','user_firstname, user_lastname, user_account_num');
            $query='SELECT * FROM trades WHERE user_account_num="'.$uDetails['user_account_num'].'"';
            $res=$db->rq($query);
            $num_rows=$db->num_rows($res);
            if($num_rows>0) {
            	while(($row=$db->fetch($res)) != FALSE) {
            		$query2='DELETE FROM trades_related WHERE trade_ref="'.$row['trade_ref'].'" OR trade_ref_relatedto="'.$row['trade_ref'].'"';
            		$db->rq($query2);
            	}
            }
            $query='DELETE FROM trades WHERE user_account_num="'.$uDetails['user_account_num'].'"';
            $db->rq($query);
            
            $query='DELETE FROM transfers WHERE user_account_num="'.$uDetails['user_account_num'].'"';
            $db->rq($query);
            
            //$query='DELETE FROM users_logs WHERE user_account_num="'.$uDetails['user_account_num'].'"';
            //$db->rq($query);
            
            $query='DELETE FROM users WHERE user_uid="'.$_GET['uid'].'"';
            $db->rq($query);
            
            addLog('Back-end','Accounts',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','User deleted');

            $db->close();
            header('Location: users.php');
            exit();
        }
        break;
    case 'pdf':
        $db = new DBConnection();
        $userModel = new App\Model\User($db);
        $tradesModel = new App\Model\Trades($db);
        $transfersModel = new App\Model\Transfer($db);
        
        $user = $userModel->getUserByUid($_GET['uid']);
        $trades = $tradesModel->getUserTrades($user['user_account_num']);
        $transfers = $transfersModel->getUserTransfers($user['user_account_num']);
        
        $view = new App\View\View('user/account_statement');
        $user['account_statement'] = $view->render(array(
            'trades' => $trades,
            'tradesBuyOptions' => $tradesModel->getOptions(),
            'buyStatuses' => $tradesModel->getStatuses('buy'),
            'sellStatuses' => $tradesModel->getStatuses('sell'),
            'transfers' => $transfers,
            'transfersOptions' => $transfersModel->getTypes(),
            'depositOptions' => $transfersModel->getStatuses()
        ));
        
        $mpdf = new mPDF(null, 'A4', null, null, 8, 8, 40, 20, 8, 8);
        $pdf  = new App\Utility\Pdf($db);
        
        $mpdf->SetHTMLHeader($pdf->getHeader());
        $mpdf->SetHTMLFooter($pdf->getFooter());
        
        $mpdf->WriteHTML($pdf->getBody('account_summary', $user));
        
        $mpdf->Output($user['user_account_num'] . '.pdf', 'D');
        exit();
        break;
    default	:
        $page_content=listUsers();
        break;
}

page_header();
echo $page_content;
page_footer();
?>