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
    if(($_POST['cgid']+0)>0) {
        $query='UPDATE commodities_groups SET commodities_groups_name="'.$_POST['commodities_groups_name'].'"
		WHERE commodities_groups_id='.($_POST['cgid']+0).'';
        $db->rq($query);
        
        addLog('Back-end','Back-end Settings, Commodities - groups',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity group edited ('.$_POST['commodities_groups_name'].')');
    }else {
        $query='INSERT INTO commodities_groups SET commodities_groups_name="'.$_POST['commodities_groups_name'].'"';
        $db->rq($query);
        
        addLog('Back-end','Back-end Settings, Commodities - groups',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity group added ('.$_POST['commodities_groups_name'].')');
    }

    $db->close();
    header('Location: commodities_groups.php');
    exit();
}

function addNewCommodityGroup($commodities_groups_id=0) {
    if($commodities_groups_id&&!$_POST['_form_submit']) {
        $_SESSION['admin']['uedit']=$commodities_groups_id;
        $db=new DBConnection();
        $query='SELECT * FROM commodities_groups WHERE commodities_groups_id='.($commodities_groups_id+0).'';
        $res=$db->rq($query);
        foreach ($db->fetch($res) AS $RowName=>$RowValue) {
            $_POST[$RowName]=$RowValue;
        }
        $db->close();
    }

    $pcontent='';
    $pcontent.='
<div class="mainHolderSmaller">
<div class="hintHolder ui-state-default"><b>'.(($commodities_groups_id>0)?'Editing':'Creating New').' Commodity Group</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/commodities_groups.js"></script>
<form name="addNewCommodityGroup" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder">
	<legend>Group information</legend>
	<div class="formsLeft">Name:</div>
	<div class="formsRight">
		<input class="text-input" type="text" name="commodities_groups_name" id="commodities_name" value="'.$_POST['commodities_groups_name'].'" />
	</div>
	<input type="hidden" name="_form_submit" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
    if($commodities_groups_id) {
        $pcontent.='
	<input type="hidden" name="cgid" value="'.$commodities_groups_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this commodity group?\')) location=\'?action=delete&cgid='.($_POST['commodities_groups_id']+0).'\';" />';
    }
    $pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'commodities_groups.php\';" />
	</fieldset>
</form>
</div>';
    return $pcontent;
}

function listCommoditiesGroup() {
    $pcontent='';
    $pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_commodities_groups.js"></script>
<div class="mainHolderSmaller">
    <div class="hintHolder ui-state-default"><b>List All Commodities</b></div>
    <div class="simpleHolder">Actions: <a href="'.THISPAGE.'?action=new">add new</a></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
        <thead>
            <tr>
                <th><b>#</b></th>
                <th><b>Name</b></th>
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
        $page_content=addNewCommodityGroup();
        break;
    case 'edit':
        $page_content=addNewCommodityGroup($_GET['cgid']+0);
        break;
    case 'delete'	:
        if($_SESSION['admin']['is_logged']==1) {
            $db=new DBConnection();
            $currentInfo=$db->getRow('commodities_groups','commodities_groups_id='.($_GET['cgid']+0).'');
            
            $query='DELETE FROM commodities_groups WHERE commodities_groups_id='.($_GET['cgid']+0);
            $db->rq($query);
            
            addLog('Back-end','Back-end Settings, Commodities - groups',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Commodity group deleted ('.$currentInfo['commodities_groups_name'].')');
            
            $db->close();
            header('Location: commodities_groups.php');
            exit();
        }
        break;
    default	:
        $page_content=listCommoditiesGroup();
        break;
}

page_header();
echo $page_content;
page_footer();
?>