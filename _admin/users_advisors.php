<?php
require_once ('template.php');
if (!$_SESSION['admin']['is_logged']){
	header('Location: index.php');
	exit();
}
$_SESSION['admin']['selected_tab']=7;
unset($_SESSION['admin']['uedit']);

if (isset($_POST['_form_submit'])){
	$db=new DBConnection();
	if (($_POST['advid']+0)>0){
		$query='UPDATE users_advisors SET advisor_ref="'.$_POST['ref'].'", advisor_names="'.($_POST['names']).'",
		advisor_firm="'.$db->string_escape($_POST['firm']).'", advisor_contacts="'.$db->string_escape($_POST['contacts']).'"
		WHERE users_advisors_id='.($_POST['advid']+0).'';
		$db->rq($query);
		
		addLog('Back-end','Advisors',''.$_POST['names'].' ('.$_POST['ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Advisor edited');
	}else{
		$query='INSERT INTO users_advisors SET advisor_ref="'.$_POST['ref'].'", advisor_names="'.($_POST['names']).'",
		advisor_firm="'.$db->string_escape($_POST['firm']).'", advisor_contacts="'.$db->string_escape($_POST['contacts']).'"';
		$db->rq($query);
		
		addLog('Back-end','Advisors',''.$_POST['names'].' ('.$_POST['ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Advisor added');
	}
	
	$db->close();
	header('Location: users_advisors.php');
	exit();
}

function addNewAdvisor($users_advisors_id=0) {
	if ($users_advisors_id&&!$_POST['_form_submit']){
		$_SESSION['admin']['uedit']=$users_advisors_id;
		$db=new DBConnection();
		$query='SELECT * FROM users_advisors WHERE users_advisors_id='.($users_advisors_id+0).'';
		$res=$db->rq($query);
		foreach ($db->fetch($res) as $RowName=>$RowValue){
			$FormFieldName=str_replace('advisor_', '', $RowName);
			$_POST[$FormFieldName]=$RowValue;
		}
		$db->close();
	}
	
	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($users_advisors_id>0)?'Editing':'Creating New').' Advisor</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/advisors.js"></script>
<form name="addNewAdvisor" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder">
	<legend>User information</legend>
	<div class="formsLeft">REF:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="ref" id="ref" value="'.$_POST['ref'].'" />
	</div>
	<br />
	<div class="formsLeft">Names:</div>
	<div class="formsRight">
		<input class="text-input" name="names" id="names" value="'.$_POST['names'].'" />
	</div>
	<br />
	<div class="formsLeft">Firm:</div>
	<div class="formsRight">
		<input class="text-input" name="firm" id="firm" value="'.$_POST['firm'].'" />
	</div>
	<br />
	<div class="formsLeft">Contacts:</div>
	<div class="formsRight">
		<input class="text-input" name="contacts" id="contacts" value="'.$_POST['contacts'].'" />
	</div>
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />
	';
	if ($users_advisors_id){
		$pcontent.='
	<input type="hidden" name="advid" value="'.$users_advisors_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this advisor?\')) location=\'?action=delete&advid='.($_POST['users_advisors_id']+0).'\';" />';
	}
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'users_advisors.php\';" />
	</fieldset>
</form>
</div>';
	return $pcontent;
}

function listAdvisors() {

	$pcontent='';
	$pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_advisors.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Advisors</b></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
	<thead>
	    <tr>
		<th><b>Names</b></th>
		<th><b>REF</b></th>
		<th><b>Company</b></th>
		<th><b>Contacts</b></th>
		<th><b>Actions</b></th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
	    	<td colspan="5" class="dataTables_empty">Loading data from server</td>
	    </tr>
	</tbody>
    </table>
</div>';
	
	return $pcontent;
}

if (isset($_GET['action'])){
	$cmd=($_GET['action']);
}else{
	$cmd='';
}

if (isset($_POST['_back'])) $cmd='';
$page_content='';
switch ($cmd) {
	case 'new' :
		$page_content=addNewAdvisor();
		break;
	case 'edit' :
		if ($_GET['ref']!=''&&($_GET['advid']+0)==0){
			$db=new DBConnection();
			$query='SELECT users_advisors_id FROM users_advisors WHERE advisor_ref="'.$db->string_escape($_GET['ref']).'" LIMIT 1';
			$res=$db->rq($query);
			$row=$db->fetch($res);
			$_GET['advid']=($row['users_advisors_id']+0);
		}
		$page_content=addNewAdvisor($_GET['advid']+0);
		break;
	case 'delete' :
		if ($_SESSION['admin']['is_logged']==1){
			$db=new DBConnection();
			$getCurrentData=$db->getRow('users_advisors', 'users_advisors_id="'.$_GET['advid'].'"');
			
			$query='DELETE FROM users_advisors WHERE users_advisors_id='.($_GET['advid']+0);
			$db->rq($query);

			addLog('Back-end','Advisors',''.$getCurrentData['advisor_names'].' ('.$getCurrentData['advisor_ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Advisor deleted');
			
			$db->close();
			header('Location: users_advisors.php');
			exit();
		}
		break;
	default :
		$page_content=listAdvisors();
		break;
}

page_header();
echo $page_content;
page_footer();
?>