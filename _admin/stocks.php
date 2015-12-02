<?php
require_once ('template.php');

if (!isAppLoggedIn()){
	header('Location: index.php');
	exit();
}

$_SESSION['admin']['selected_tab'] = 4;
unset($_SESSION['admin']['uedit']);

if (isset($_POST['_form_submit']) && isset($_POST['_new_stock'])){
	$db=new DBConnection();
	if (($_POST['stockid']+0)>0){
		$query = '
            UPDATE stocks
            SET
                stocks_symbol="'.$_POST['symbol'].'",
                stocks_name="'.$db->string_escape($_POST['names']).'", 
                stocks_links="'.$db->string_escape($_POST['link']).'",
                checking = "'.$db->string_escape($_POST['checking']).'"
            WHERE stocks_id='.($_POST['stockid']+0).'';
        
		$db->rq($query);
		
		addLog('Back-end','Stocks',''.$db->string_escape($_POST['names']).' ('.$_POST['symbol'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Stock edited');
	}else{
		$detRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;

		$query='INSERT INTO stocks SET stocks_symbol="'.$_POST['symbol'].'", stocks_name="'.$db->string_escape($_POST['names']).'", 
		stocks_links="'.$db->string_escape($_POST['link']).'", checking = "'.$db->string_escape($_POST['checking']).'"';
		$db->rq($query);
		$today = date('Y-m-d', CUSTOMTIME);
		$query='INSERT INTO stock_details SET details_ref="'.$detRef.'", stocks_id="'.$db->last_id().'", value="'.str_replace(',', '', $_POST['value']).'", date="'.$today.'"';
		$db->rq($query);
		
		addLog('Back-end','Stocks',''.$db->string_escape($_POST['names']).' ('.$_POST['symbol'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','New Stock added');
	}
	
	$db->close();
	header('Location: stocks.php');
	exit();
}

if (isset($_POST['_form_submit']) && isset($_POST['_new_value'])){
	$db=new DBConnection();
	$detRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;
	if($_POST['trade_ref']) {
		$query='DELETE FROM stock_details WHERE details_ref="'.$_POST['trade_ref'].'"';
		$db->rq($query);
	}
	for($i=1; $_POST['stocks_id_'.$i] > 0; $i++) {
		$subq=$db->rq("SELECT value FROM stock_details WHERE stocks_id='".$_POST['stocks_id_'.$i]."' ORDER BY date DESC LIMIT 1");
		$subrow=$db->fetch($subq);
		$past_price = $subrow['value'];
		if($past_price) { 
			$change = (($_POST['value_'.$i]-$past_price)/$past_price)*100; 
			$change = round($change, 2);
		} else { 
			$change = 0;
		}
		
		$query='INSERT INTO stock_details SET details_ref="'.$detRef.'", stocks_id="'.$_POST['stocks_id_'.$i].'", 
		volume="'.$_POST['volume_'.$i].'", value="'.$_POST['value_'.$i].'", value_change="'.$change.'", date="'.$_POST['date_value'].'"';
		$db->rq($query);
	}
	if($_POST['trade_ref']) {
		addLog('Back-end','Stocks',date('Y-m-d', CUSTOMTIME).' ('.$_POST['trade_ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Edited Stock values');
	} else { 
		addLog('Back-end','Stocks',''.$_POST['date_value'].' ('.$detRef.')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','New stock values added');
	}
	$db->close();
	header('Location: stocks.php');
	exit();
}

function addNewStock($stockid) {
	if($stockid) { 
		$db=new DBConnection();
		$query=$db->rq("SELECT * FROM stocks WHERE stocks_id='".$stockid."'");
		$_POST=$db->fetch($query);
        
        $_SESSION['admin']['uedit'] = $_POST['stocks_id'];
	}
	$JSCripts=' onchange="setDetails();"';
	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($stockid>0)?'Editing':'Creating New').' Stock</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/stocks.js"></script>
<form name="addNewStock" method="POST" id="MainForms" action="">
<fieldset class="mainFormHolder">
	<legend>Stock information</legend>
	<div class="formsLeft">Stock Symbol: </div>
	<div class="formsRight">
		<input class="text-input" type="text" name="symbol" id="symbol" value="'.$_POST['stocks_symbol'].'" />
	</div>
	<br />
	<div class="formsLeft">Stock Name: </div>
	<div class="formsRight">
		<input class="text-input" name="names" id="names" value="'.htmlspecialchars(stripslashes($_POST['stocks_name']), ENT_QUOTES).'" />
	</div>
	<br />
	<div class="formsLeft">Stock Link: </div>
	<div class="formsRight">
		<input class="text-input" name="link" id="link" value="'.htmlspecialchars(stripslashes($_POST['stocks_links']), ENT_QUOTES).'" />
	</div>
    <br />
	<div class="formsLeft">Stock Price Checking: </div>
	<div class="formsRight">
		<select class="text-input" name="checking" id="checking">
            <option value="" ' . ($_POST['checking'] == '' ? 'selected' : '') . '>Disabled</option>
            <option value="hourly" ' . ($_POST['checking'] == 'hourly' ? 'selected' : '') . '>Hourly</option>
            <option value="daily" ' . ($_POST['checking'] == 'daily' ? 'selected' : '') . '>Daily</option>
        </select>
	</div>';
	if(!$stockid) { 
		$pcontent.='<BR /><div class="formsLeft">Today\'s Price/Share: </div>
		<div class="formsRight">
			<input class="text-input align-right" name="value" id="value"'.$JSCripts.' />
		</div>';
	} else { 
		$pcontent.='<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this stock?\')) location=\'?action=delete&sid='.($stockid+0).'\';" />';
	}
	$pcontent.='<input type="hidden" name="_form_submit" value="1" />
	<input type="hidden" name="_new_stock" value="1" />
	<input type="hidden" name="stockid" value="'.$stockid.'" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />
	';
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'stocks.php\';" />
	</fieldset>
</form>
</div>';
	return $pcontent;
}

function addNewValue($details_id=0) {
	$JSCripts=' onchange="setDetails();"';
	$db=new DBConnection();
	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>Adding New Stock Values</b></div> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/stockValues.js"></script>
<form name="addNewStockValue" method="POST" id="MainForms" action="">';

$query='SELECT * FROM stocks ORDER BY stocks_name ASC';
$res=$db->rq($query);
$num = 1;
$pcontent.='<div class="left">';
while (($row=$db->fetch($res))!=FALSE){
    
	if($details_id > 0) { 
		$details_id = $db->string_escape($details_id);
		$curval     = $db->getRow('stock_details','stocks_id="'.$row['stocks_id'].'" AND details_ref="'.$details_id.'"','value, volume, date');
	} else { 
		$curval = $db->getRow('stock_details','stocks_id="'.$row['stocks_id'].'" ORDER BY date DESC','value, volume');
	}
    
	if($curval){
	    $date = array_get($curval, 'date');
	    
		$pcontent.='<fieldset class="mainFormHolder">
			<legend>Share</legend>
			<div class="formsLeft">Share:</div>
			<div class="formsRight">
				<select name="stocks_id_'.$num.'" id="stocks_id_'.$num.'" class="text-input">';
				$pcontent.='<option value="'.$row['stocks_id'].'">'.$row['stocks_symbol'].' ('.$row['stocks_name'].')</option>';
			$pcontent.='
				</select>
			</div><br />
			<div class="formsLeft">Value:</div>
			<div class="formsRight">
				<input class="required text-input align-right" type="text" name="value_'.$num.'" id="value_'.$num.'" value="'.$curval['value'].'"'.$JSCripts.' />
			</div>
			<br />
			<div class="formsLeft">Volume:</div>
			<div class="formsRight">
				<input class="text-input align-right" type="text" name="volume_'.$num.'" id="volume_'.$num.'" value="'.$curval['volume'].'"'.$JSCripts.' />
			</div><br />
		</fieldset>';
	}
	$num++;
}
$pcontent.='</div><div class="left"><fieldset class="mainFormHolder">

	<legend>Date</legend>
	<div class="formsLeft">Value date:</div>
	<div class="formsRight"><input class="text-input" type="text" name="date_value" id="date_value" value="'.$date.'" /></div>
	<br />';
	if($details_id) { 
		$pcontent.='<input type="hidden" name="trade_ref" value="'.$details_id.'" />';
		$pcontent.='<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete the values from this date?\')) location=\'?action=delete_values&sid='.($details_id).'\';" />';
	}
	$pcontent.='<input type="hidden" name="_form_submit" value="1" />
	<input type="hidden" name="_new_value" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />
	';
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'stocks.php\';" />
	</fieldset></div>
</form>
</div>';
	return $pcontent;
}

function listStocks() {

	$pcontent='';
	$pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_stocks.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Stocks</b></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
	<thead>
	    <tr>
		<th><b>Symbol</b></th>
		<th><b>Stock Name</b></th>
		<th><b>Prev Price</b></th>
		<th><b>Present Price</b></th>
		<th><b>% change</b></th>
		<th><b>Updates</b></th>
		<th><b>Last Run</b></th>
		<th><b>Actions</b></th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
	    	<td colspan="6" class="dataTables_empty">Loading data from server</td>
	    </tr>
	</tbody>
    </table>
</div>';
	
	return $pcontent;
}

function listDates() {

	$pcontent='';
	$pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_stockDates.js"></script>
<div class="mainHolder">
	<div class="hintHolder ui-state-default"><b>List All Value Updates</b></div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="advisorsTable">
	<thead>
		<tr>
		<th><b>Reference ID</b></th>
		<th><b>Date</b></th>
		<th><b>Actions</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6" class="dataTables_empty">Loading data from server</td>
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
	case 'new_stock' :
		$_GET['sid'] = isset($_GET['sid']) ? (int)$_GET['sid'] : 0;
		if(!$_GET['sid'] && $_GET['ref']) {
			$db=new DBConnection();
			$stockdata=$db->getRow('stocks', 'stocks_symbol="'.$db->string_escape($_GET['ref']).'"');
			$_GET['sid']=$stockdata['stocks_id'];
		}
		$page_content = addNewStock($_GET['sid']);
		break;
	case 'new_value' :
		$page_content=addNewValue();
		break;
	case 'edit_value' :
		$page_content=addNewValue($_GET['ref']);
		break;
	case 'list_dates' :
		$page_content=listDates();
		break;
	case 'force_update' :
        $db           = new DBConnection();
        $stockModel   = new App\Model\Stocks($db);
        $page_content = '';
        
        $updated = $stockModel->updateStockValues();
        
        if ($updated) {
            $page_content .= '
                <div style="text-align:center;margin: 10px auto;color:#000000;width:300px;display:none;" id="EndHolder">
                    <b>Successfully updated '.$updated.' stocks...</b>
                </div>
            ';
        }
        
		$page_content .= listDates();
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
			$getCurrentData=$db->getRow('stocks', 'stocks_id="'.($_GET['sid']+0).'"');
			$query='DELETE FROM stock_details WHERE stocks_id='.($_GET['sid']+0);
			$db->rq($query);
			
			$query='DELETE FROM stocks WHERE stocks_id='.($_GET['sid']+0);
			$db->rq($query);

			addLog('Back-end','Stocks',''.$getCurrentData['stocks_name'].' ('.$getCurrentData['stocks_symbol'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Stock deleted');
			
			$db->close();
			header('Location: stocks.php');
			exit();
		}
		break;
	case 'delete_values' :
		if ($_SESSION['admin']['is_logged']==1){
			$db=new DBConnection();
			
			$getCurrentData=$db->getRow('stock_details', 'details_ref="'.($_GET['sid']+0).'"');
			$query='DELETE FROM stock_details WHERE details_ref='.($_GET['sid']+0);
			$db->rq($query);

			addLog('Back-end','Stocks',''.$getCurrentData['date'].' ('.$getCurrentData['details_ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Values deleted');

			$db->close();
			header('Location: stocks.php?action=list_dates');
			exit();
		}
		break;
	default :
		$page_content=listStocks();
		break;
}

page_header();
echo $page_content;
page_footer();
?>