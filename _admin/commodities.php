<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}
$_SESSION['admin']['selected_tab']=5;
unset($_SESSION['admin']['uedit']);
if(isset($_POST['_form_submit'])) {
    $db=new DBConnection();
    foreach ($_POST AS $k=>$x) $_POST[$k]=$db->string_escape($x);
    if(($_POST['cid']+0)>0) {
        $query='UPDATE commodities SET commodities_groups_id="'.$_POST['commodities_groups_id'].'",
		commodities_name="'.($_POST['commodities_name']).'", commodities_symbol="'.$_POST['commodities_symbol'].'", 
		commodities_contract_size="'.$db->string_escape($_POST['commodities_contract_size']).'", 
		commodities_unit="'.$db->string_escape($_POST['commodities_unit']).'", 
		commodities_status="'.$db->string_escape($_POST['commodities_status']).'",
		commodities_order_priority="'.$db->string_escape($_POST['commodities_order_priority']).'", 
		commodities_def_fee="'.$db->string_escape($_POST['commodities_def_fee']+0).'",
		commodities_def_prem="'.$db->string_escape($_POST['commodities_def_prem']+0).'"  
		WHERE commodities_id='.($_POST['cid']+0).'';
        $db->rq($query);
        
        addLog('Back-end','Back-end Settings, Commodities',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity edited ('.$_POST['commodities_symbol'].')');
    }else {
        $query='INSERT INTO commodities SET commodities_groups_id="'.$_POST['commodities_groups_id'].'",
		commodities_name="'.($_POST['commodities_name']).'", commodities_symbol="'.$_POST['commodities_symbol'].'", 
		commodities_contract_size="'.$db->string_escape($_POST['commodities_contract_size']).'", 
		commodities_unit="'.$db->string_escape($_POST['commodities_unit']).'", 
		commodities_status="'.$db->string_escape($_POST['commodities_status']).'",
		commodities_order_priority="'.$db->string_escape($_POST['commodities_order_priority']).'",
		commodities_def_fee="'.$db->string_escape($_POST['commodities_def_fee']+0).'",
		commodities_def_prem="'.$db->string_escape($_POST['commodities_def_prem']+0).'"';
        $db->rq($query);
        
        addLog('Back-end','Back-end Settings, Commodities',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity added ('.$_POST['commodities_symbol'].')');
    }

    $db->close();
    header('Location: commodities.php');
    exit();
}

function addNewCommodity($commodities_id=0) {
    if($commodities_id&&!$_POST['_form_submit']) {
        $_SESSION['admin']['uedit']=$commodities_id;
        $db=new DBConnection();
        $query='SELECT * FROM commodities WHERE commodities_id='.($commodities_id+0).'';
        $res=$db->rq($query);
        foreach ($db->fetch($res) AS $RowName=>$RowValue) {
            $_POST[$RowName]=$RowValue;
        }
        $db->close();
    }

    $pcontent='';
    $pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($commodities_id>0)?'Editing':'Creating New').' Commodity</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/commodities.js"></script>
<form name="addNewCommodity" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder">
	<legend>Commodity information</legend>
	<div class="formsLeft">Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="commodities_name" id="commodities_name" value="'.$_POST['commodities_name'].'" />
	</div>
	<br />
	<div class="formsLeft">Group:</div>
	<div class="formsRight">
		<select name="commodities_groups_id" class="text-input">';
    $db=new DBConnection();
    $query='SELECT * FROM commodities_groups ORDER BY commodities_groups_name';
    $res=$db->rq($query);
    while(($row=$db->fetch($res)) != FALSE) {
        $pcontent.='<option value="'.$row['commodities_groups_id'].'"'.(($_POST['commodities_groups_id']==$row['commodities_groups_id'])?' selected':'').'>'.$row['commodities_groups_name'].'</option>';
    }
    $db->close();

    $pcontent.='
		</select>
	</div>
	<br />
	<div class="formsLeft">Symbol:</div>
	<div class="formsRight">
		<input class="text-input" name="commodities_symbol" id="commodities_symbol" value="'.$_POST['commodities_symbol'].'" />
	</div>
	<br />
	<div class="formsLeft">Contract size:</div>
	<div class="formsRight">
		<input class="text-input" name="commodities_contract_size" id="commodities_contract_size" value="'.$_POST['commodities_contract_size'].'" />
	</div>
	<br />
	<div class="formsLeft">Unit:</div>
	<div class="formsRight">
		<input class="text-input" name="commodities_unit" id="commodities_unit" value="'.$_POST['commodities_unit'].'" />
	</div>
	<br />
	<div class="formsLeft">Default Fees:</div>
	<div class="formsRight">
		<input class="text-input" name="commodities_def_fee" id="commodities_def_fee" value="'.$_POST['commodities_def_fee'].'" />
	</div>
	<br />
	<div class="formsLeft">Default Premium Price:</div>
	<div class="formsRight">
		<input class="text-input" name="commodities_def_prem" id="commodities_def_prem" value="'.$_POST['commodities_def_prem'].'" />
	</div>
	<br />
	<div class="formsLeft">Status:</div>
	<div class="formsRight">
		<select name="commodities_status" class="text-input">
			<option value="0"'.(($_POST['commodities_status']==0)?' selected':'').'>Not active</option>
			<option value="1"'.(($_POST['commodities_status']==1)?' selected':'').'>Active</option>
		</select>
	</div>
	<br />
	<div class="formsLeft">Order priority:</div>
	<div class="formsRight">
		<input class="text-input" name="commodities_order_priority" id="commodities_order_priority" value="'.$_POST['commodities_order_priority'].'" />
	</div>
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
    if($commodities_id) {
        $pcontent.='
	<input type="hidden" name="cid" value="'.$commodities_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this commodity?\')) location=\'?action=delete&cid='.($_POST['commodities_id']+0).'\';" />';
    }
    $pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'commodities.php\';" />
	</fieldset>
</form>
</div>';
    return $pcontent;
}

function listCommodities() {
    $pcontent='';
    $pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_commodities.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Commodities</b></div>
    <div class="simpleHolder">Actions: <a href="'.THISPAGE.'?action=new">add new</a></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
		<thead>
			<tr>
				<th><b>#</b></th>
				<th><b>Name</b></th>
				<th><b>Group</b></th>
				<th><b>Symbol</b></th>
				<th><b>Contract size</b></th>
				<th><b>Unit</b></th>
				<th><b>Default Fees</b></th>
				<th><b>Default Premium</b></th>
				<th><b>Status</b></th>
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

if (isset($_GET['action'])) {
    $cmd=($_GET['action']);
}else {
    $cmd='';
}

if (isset($_POST['_back']))	$cmd='';
$page_content='';
switch	($cmd) {
    case 'new':
        $page_content=addNewCommodity();
        break;
    case 'edit':
        $page_content=addNewCommodity($_GET['cid']+0);
        break;
    case 'delete'	:
        if($_SESSION['admin']['is_logged']==1) {
            $db=new DBConnection();
            $currentInfo=$db->getRow('commodities','commodities_id='.($_GET['cid']+0).'');
            $query='DELETE FROM commodities WHERE commodities_id='.($_GET['cid']+0);
            $db->rq($query);
            
            addLog('Back-end','Back-end Settings, Commodities',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity deleted ('.$currentInfo['commodities_symbol'].')');

            $db->close();
            header('Location: commodities.php');
            exit();
        }
        break;
    default	:
        $page_content=listCommodities();
        break;
}

page_header();
echo $page_content;
page_footer();
?>