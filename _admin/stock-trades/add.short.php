<?php

function addNewTradeShort($tradesSell_id=0) {

	$db=new DBConnection();
	if ($tradesSell_id && !isset($_POST['_form_submit'])){
		$query='SELECT * FROM stock_trades WHERE trade_ref="'.$tradesSell_id.'"';
		$res=$db->rq($query);
		$_POST=$db->fetch($res);
		$_SESSION['admin']['uedit']=$_POST['trades_id'];
		$JSCripts=' onchange="setDetails(0);"';
		$JSCriptsSelect=' onchange="setDetails(3);"';
		$JSCriptsPremium=' onchange="setDetails(1);"';
	}else{
		$_POST['trade_stockprice']='0.0000';
		$_POST['trade_shares']=10;
		$JSCripts=' onchange="setDetails(0);"';
		$JSCriptsSelect=' onchange="setDetails(3);"';
		$JSCriptsPremium=' onchange="setDetails(1);"';
	}

	if (array_get($_POST, 'trade_date') == ''){
        $_POST['trade_date'] = date('Y-m-d', CUSTOMTIME);
    }

	global $tradesStatuses;
	global $tradesBuyOptions;

	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($tradesSell_id>0)?'Editing':'Adding New').' SHORT Order</b></div>
<script type="text/javascript" src="../js/jquery.metadata.js"></script> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/stradesShort.js"></script>
<script type="text/javascript">
jQuery(document).ready(
	function($) {
		var sliderValue = '.$_POST['trade_shares'].';
		$("#slider").slider( {
			min : 1,
			max : 99999,
			step : 1,
			value : [ sliderValue ],
			slide : function(event, ui) {
				$("#sliderVal").val(ui.value);
			}
		});

		$("#sliderVal").attr("value", sliderValue);

		$("#sliderVal").keyup(function() {
			var sliderValue = +this.value;
			if (sliderValue >= 1 && sliderValue <= 99999) {
				$("#slider").slider("value", sliderValue);
			} else {
				alert("Please enter a value between 1 and 99999");
				$("#slider").slider("value", 1);
				$("#sliderVal").attr("value", 1);
			}
		});

		$("#slider, #sliderVal").bind("mousedown mouseup mousemove mouseout mouseover",	function() {
			setDetails(0);
		});

		'.((!$tradesSell_id)?'setDetails(3);':'setDetails(4);').'
});
</script>

<form name="addNewTradeShort" method="POST" id="MainForms" action="">
<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Account</legend>
	<div class="formsRight">
		<select name="user_account_num" id="user_account_num" class="text-input-big" title="Please select user account!" validate="required:true"'.$JSCripts.'>
		<option value="">Select account</option>';

	$query='SELECT user_account_num, user_firstname, user_lastname, user_balance FROM users ORDER BY user_firstname ASC, user_lastname ASC';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		$pcontent.='<option value="'.$row['user_account_num'].'"'.((array_get($_GET, 'uid')==$row['user_account_num']||array_get($_POST, 'user_account_num')==$row['user_account_num'])?' selected':'').'>'.$row['user_account_num'].' ('.$row['user_firstname'].' '.$row['user_lastname'].', $'.$row['user_balance'].')</option>';
	}

	$pcontent.='
		</select>
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Transaction</legend>
	<div class="formsLeft">Trade Order:</div>
	<div class="formsRight">SHORT SELL</div>
	<br />
	<div class="formsLeft">Share(s):</div>
	<div class="formsRight">
		<div id="slider"><a href="#"></a></div> <input type="text" class="text-input-smallest left" id="sliderVal" name="trade_shares"'.$JSCripts.' />
	</div>

	<br /><br />
	<div class="formsLeft">Stock:</div>
	<div class="formsRight">
		<select name="stocks_id" id="stocks_id" class="text-input"'.$JSCriptsSelect.'>';
	$query='SELECT stocks_id, stocks_symbol, stocks_name FROM stocks ORDER BY stocks_symbol ASC';
	$res=$db->rq($query);
	while($row = $db->fetch($res)) {
		$subq=$db->rq('SELECT value FROM stock_details WHERE stocks_id='.$row['stocks_id'].' ORDER BY date DESC LIMIT 1');
		$subrow=$db->fetch($subq);
		$pcontent.='<option value="'.$row['stocks_id'].'_'.$subrow['value'].'_'.$row['stocks_symbol'].'"'.(($row['stocks_id']==array_get($_POST, 'stocks_id'))?' selected':'').'>'.$row['stocks_symbol'].' ('.$row['stocks_name'].')</option>';
	}
	$pcontent.='
		</select>
	</div><br />
	<div class="formsLeft">Notes:</div>
	<div class="formsRight">
		<input type="text" class="text-input left" name="trade_notes" value="'.array_get($_POST, 'trade_notes').'"'.$JSCripts.' />
	</div>

	<br /><br />

	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Trade Details</legend>
	<input class="ui-state-default trade-details" type="text" name="trade_details" id="trade_details" value="'.array_get($_POST, 'trade_details', 'SHORT').'" readonly />
	</fieldset>';

	$totalRelated=0;
	$query2='SELECT trade_details, stock_trades.trade_ref FROM trades_related tr LEFT JOIN stock_trades ON tr.trade_ref=stock_trades.trade_ref WHERE trade_ref_relatedto="'.array_get($_POST, 'trade_ref').'"';
	$res2=$db->rq($query2);
	$totalRelated=$db->num_rows($res2);
	if ($totalRelated>0){
		$pcontent.='
		<div class="clear"></div>
		<fieldset class="mainFormHolder left">
			<legend>Related Trades</legend><br />';
		while (($row2=$db->fetch($res2))!=FALSE){
			$pcontent.='<div class="ui-state-default trade-details"><a href="strades.php?action=edit_sell&tref='.$row2['trade_ref'].'" style="display:block;">'.$row2['trade_details'].'</a></div><br />';
		}

		$pcontent.='
		</fieldset>';
	}

	$pcontent.='
</div>

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Prices</legend>

	<div class="formsLeft">Price/share:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_price_share" id="trade_price_share" value="'.array_get($_POST, 'trade_price_share').'"'.$JSCripts.' />
	</div>
	<br />
	<div class="formsLeft">Trade Value:</div>
	<div class="formsRight">
		<input class="text-input align-right ui-state-default" type="text" name="trade_value" id="trade_value" value="'.array_get($_POST, 'trade_value').'" readonly />
	</div>
	<br />
	<div class="formsLeft">Fees:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_fees" id="trade_fees" value="'.array_get($_POST, 'trade_fees').'"'.$JSCripts.' />
	</div>
	<br />
	<div class="formsLeft">Total Invoiced:</div>
	<div class="formsRight">
		<input class="text-input align-right ui-state-default" type="text" name="trade_invoiced" id="trade_invoiced" value="'.array_get($_POST, 'trade_invoiced').'" />
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

	foreach ($tradesStatuses as $StatusID=>$StatusName){
		$pcontent.='<option value="'.$StatusID.'"'.(($StatusID==array_get($_POST, 'trade_status'))?' selected':'').'>'.$StatusName.'</option>';
	}

	$pcontent.='
		</select>
	</div>
	</fieldset>

	<div class="clear"></div>

	<div class="mainFormHolder left btnsHolder">';

	if ($totalRelated==0){
		$pcontent.='
	<input type="hidden" name="_form_submit" value="1" />
	<input type="hidden" name="_add_short" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
		if ($tradesSell_id){
			$pcontent.='
	<input type="hidden" name="tref" value="'.$tradesSell_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this BUY?\')) location=\'?action=delete_buy&buyid='.($_POST['trade_ref']).'\';" />';
		}
	}else{
		$pcontent.='
	<div class="ui-state-error bold" style="width:300px; margin:auto; padding:5px;">
		These BUY trade have been partially or totally sold and therefore cannot be updated.
	</div>';
	}
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'strades.php\';" />
	</div>
</div>
</form>
</div>';
	$db->close();
	return $pcontent;
}

?>