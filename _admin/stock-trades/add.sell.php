<?php

function addNewTradeSell($tradesSell_id=0) {

	$db=new DBConnection();
	if ($tradesSell_id && !isset($_POST['_form_submit'])){
		$query='SELECT * FROM stock_trades WHERE trade_ref="'.$tradesSell_id.'"';
		$res=$db->rq($query);
		$_POST=$db->fetch($res);
		$_SESSION['admin']['uedit']=$_POST['trades_id'];
	}

	$JSCripts=' onchange="setDetails(0);"';
	$JSCriptsPremium=' onchange="setDetails(1);"';

	if ($_POST['trade_date']=='') $_POST['trade_date']=date('Y-m-d', CUSTOMTIME);

	global $tradesSellStatuses;
	global $tradesBuyOptions;

	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($_GET['action']=='new_sell')?'Adding new':'Editing').' SELL Order</b></div>
<script type="text/javascript" src="../js/jquery.metadata.js"></script> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/stradesSell.js"></script>
<script type="text/javascript">
jQuery(document).ready(
	function($) {
		var sliderValue = '.$_POST['trade_shares_left'].';
		$("#slider").slider( {
			min : 1,
			max : '.$_POST['trade_shares_left'].',
			step : 1,
			value : [ sliderValue ],
			slide : function(event, ui) {
				$("#sliderVal").val(ui.value);
			}
		});

		$("#sliderVal").attr("value", sliderValue);

		$("#sliderVal").keyup(function() {
			var sliderValue = +this.value;
			if (sliderValue >= 1 && sliderValue <= '.$_POST['trade_shares_left'].') {
				$("#slider").slider("value", sliderValue);
			} else {
				alert("Please enter a value between 1 and '.$_POST['trade_shares_left'].'");
				$("#slider").slider("value", 1);
				$("#sliderVal").attr("value", 1);
			}
		});

		$("#slider, #sliderVal").bind("mousedown mouseup mousemove mouseout mouseover",	function() {
			setDetails();
		});

		setDetails();
});
</script>
<form name="addNewTradeBuy" method="POST" id="MainForms" action="">

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Account</legend>
	<div class="formsRight">
		<select name="user_account_num" id="user_account_num" class="text-input-big" title="Please select user account!" validate="required:true">';

	$query='SELECT user_account_num, user_firstname, user_lastname, user_balance FROM users WHERE user_account_num="'.$_POST['user_account_num'].'" LIMIT 1';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		$pcontent.='<option value="'.$row['user_account_num'].'">'.$row['user_account_num'].' ('.$row['user_firstname'].' '.$row['user_lastname'].', $'.$row['user_balance'].')</option>';
	}

	$pcontent.='
		</select>
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Contract</legend>
	<div class="formsLeft">Trade Order:</div>
	<div class="formsRight">SELL</div>
	<br />
	<div class="formsLeft">Share(s):</div>
	<div class="formsRight">
		<div id="slider"><a href="#"></a></div> <input type="text" class="text-input-smallest left" id="sliderVal" name="trade_shares"'.$JSCripts.' />
	</div>

	<br /><br />
	<div class="formsLeft">Stock:</div>
	<div class="formsRight">';

	$query='SELECT stock_details.value, stocks.stocks_symbol, stocks.stocks_name FROM stock_details JOIN stocks on stock_details.stocks_id = stocks.stocks_id WHERE stocks.stocks_id='.($_POST['stocks_id']+0).' ORDER BY stock_details.date DESC LIMIT 1';
	$res=$db->rq($query);
	$row=$db->fetch($res);

	$pcontent.='
		<input type="hidden" name="stock_price" id="stock_price" value="'.$row['value'].'" />
		<input class="text-input ui-state-default" type="text" name="stocks_id" id="stocks_id" value="'.$row['stocks_symbol'].' ('.$row['stocks_name'].')">
	</div><br />

	<div class="formsLeft">Notes:</div>
	<div class="formsRight">
		<input type="text" class="text-input left" name="trade_notes" value="'.$_POST['trade_notes'].'"'.$JSCripts.' />
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Trade Details</legend>
	<input class="ui-state-default trade-details" type="text" name="trade_details" id="trade_details" value="'.(($_POST['trade_details']!='')?''.$_POST['trade_details'].'':'BUY').'" readonly />
	</fieldset>

	<div class="clear"></div>';

	$totalRelated=0;
	$query2='SELECT trade_ref_relatedto FROM trades_related WHERE trade_ref="'.$_POST['trade_ref'].'"';
	$res2=$db->rq($query2);
	$totalRelated=$db->num_rows($res2);
	if ($totalRelated>0){
		$row2=$db->fetch($res2);
		$getRelatedInfo=$db->getRow('stock_trades','trade_ref="'.$row2['trade_ref_relatedto'].'"','trade_ref, trade_details');
		$pcontent.='
		<fieldset class="mainFormHolder left">
			<legend>Related Trades</legend><br />
			<div class="ui-state-default trade-details"><a href="strades.php?action=edit_buy&tref='.$getRelatedInfo['trade_ref'].'" style="display:block;">'.$getRelatedInfo['trade_details'].'</a></div><br />
		</fieldset>';
	}

	$pcontent.='
</div>

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Prices</legend>
	<div class="formsLeft">Price/share:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_price_share" id="trade_price_share"'.$JSCripts.' />
	</div>
	<br />
	<div class="formsLeft">Trade Value:</div>
	<div class="formsRight">
		<input class="text-input align-right ui-state-default" type="text" name="trade_value" id="trade_value" value="'.$_POST['trade_value'].'" readonly />
	</div>
	<br />
	<div class="formsLeft">Fees:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_fees" id="trade_fees" value="'.$_POST['trade_fees'].'"'.$JSCripts.' />
	</div>
	<br />
	<div class="formsLeft">Total Invoiced:</div>
	<div class="formsRight">
		<input class="text-input align-right ui-state-default" type="text" name="trade_invoiced" id="trade_invoiced" value="'.$_POST['trade_invoiced'].'" />
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Settings</legend>
    
    <div class="formsLeft">Value date:</div>
    <div class="formsRight">
        <input class="text-input" type="text" name="trade_date" id="trade_date" value="'.array_get($_POST, 'trade_date').'" />
    </div>
    
    <br />
    
	<div class="formsLeft">Status:</div>
	<div class="formsRight">
		<select name="trade_status" class="text-input">';

	foreach ($tradesSellStatuses as $StatusID=>$StatusName){
		$pcontent.='<option value="'.$StatusID.'"'.(($StatusID==$_POST['trade_status'])?' selected':'').'>'.$StatusName.'</option>';
	}

	$pcontent.='
		</select>
	</div>
	</fieldset>

	<div class="clear"></div>

	<div class="mainFormHolder left btnsHolder">
	<input type="hidden" name="_form_submit" value="1" />
	<input type="hidden" name="_add_sell" value="1" />
	<input type="hidden" name="trid" value="'.$tradesSell_id.'">
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this SELL?\')) location=\'?action=delete_sell&sellid='.($_POST['trade_ref']).'\';" />
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'strades.php\';" />
	</div>
</div>
</form>
</div>';
	$db->close();
	return $pcontent;
}

?>