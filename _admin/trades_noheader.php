<?php
require_once ('template.php');
if (!$_SESSION['admin']['is_logged']){
	header('Location: index.php');
	exit();
}
$_SESSION['admin']['selected_tab']=1;
unset($_SESSION['admin']['uedit']);
if (isset($_POST['_form_submit'])&&$_POST['_add_sell']==1){
	$db=new DBConnection();
	
	$query='SELECT * FROM trades WHERE trade_ref="'.($_POST['trid']+0).'"';
	$res=$db->rq($query);
	$num_rows=$db->num_rows($res);
	global $tradesSellStatuses;
	
	if ($num_rows>0){
		$row=$db->fetch($res);
		if ($row['trade_type']==1){
			$mysql_fields='';
			$mysql_fields.='user_account_num="'.($_POST['user_account_num']+0).'", ';
			
			$mysql_fields.='trade_option="'.$row['trade_option'].'", ';
			$mysql_fields.='commodities_id="'.$row['commodities_id'].'", ';
			$mysql_fields.='trade_expiry_date="'.$row['trade_expiry_date'].'", ';
			$mysql_fields.='trade_contract_size="'.str_replace(',', '', $row['trade_contract_size']).'", ';
			
			$mysql_fields.='trade_positions="'.$_POST['trade_positions'].'", ';
			$mysql_fields.='trade_positions_left="'.$_POST['trade_positions'].'", ';
			$mysql_fields.='trade_strikeprice="'.str_replace(',', '', $_POST['trade_strikeprice']).'", ';
			$mysql_fields.='trade_details="'.$_POST['trade_details'].'", ';
			$mysql_fields.='trade_premium_price="'.str_replace(',', '', $_POST['trade_premium_price']).'", ';
			$mysql_fields.='trade_price_contract="'.str_replace(',', '', $_POST['trade_price_contract']).'", ';
			$mysql_fields.='trade_value="'.str_replace(',', '', $_POST['trade_value']).'", ';
			$mysql_fields.='trade_fees="'.str_replace(',', '', $_POST['trade_fees']).'", ';
			$mysql_fields.='trade_invoiced="'.str_replace(',', '', $_POST['trade_invoiced']).'", ';
			$mysql_fields.='trade_date="'.$_POST['trade_date'].'", ';
			$mysql_fields.='trade_status="'.$_POST['trade_status'].'"';

			$tradeRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;
			$query='INSERT INTO trades SET '.$mysql_fields.', trade_type=2, trades_id="'.NID.'", trade_ref='.($tradeRef+0).', trade_action_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'"';
			$db->rq($query);
			
			$NewPositionsCount=$row['trade_positions_left']-$_POST['trade_positions'];
			if ($NewPositionsCount>0){
				$query='UPDATE trades SET trade_positions_left='.($NewPositionsCount+0).' WHERE trades_id='.($row['trades_id']+0).'';
				$db->rq($query);
			}else{
				$query='UPDATE trades SET trade_positions_left=0, trade_status=4 WHERE trades_id='.($row['trades_id']+0).'';
				$db->rq($query);
			}
			
			if ($_POST['trade_status']==1){
				$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
			$query='INSERT INTO trades_related SET trade_ref='.($tradeRef+0).', trade_ref_relatedto='.($row['trade_ref']+0).'';
			$db->rq($query);
			
			$link='sellref='.$tradeRef;
			
			$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			addLog('Back-end','Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Sell added '.($tradeRef+0).' ('.$tradesSellStatuses[$_POST['trade_status']].')');
		}else{
			$mysql_fields='';
			$mysql_fields.='user_account_num="'.($row['user_account_num']+0).'", ';
			$mysql_fields.='trade_option="'.$row['trade_option'].'", ';
			$mysql_fields.='commodities_id="'.$row['commodities_id'].'", ';
			$mysql_fields.='trade_expiry_date="'.$row['trade_expiry_date'].'", ';
			$mysql_fields.='trade_contract_size="'.str_replace(',', '', $row['trade_contract_size']).'", ';
			
			$mysql_fields.='trade_positions="'.$_POST['trade_positions'].'", ';
			$mysql_fields.='trade_positions_left="'.$_POST['trade_positions'].'", ';
			$mysql_fields.='trade_strikeprice="'.str_replace(',', '', $_POST['trade_strikeprice']).'", ';
			$mysql_fields.='trade_details="'.$_POST['trade_details'].'", ';
			$mysql_fields.='trade_premium_price="'.str_replace(',', '', $_POST['trade_premium_price']).'", ';
			$mysql_fields.='trade_price_contract="'.str_replace(',', '', $_POST['trade_price_contract']).'", ';
			$mysql_fields.='trade_value="'.str_replace(',', '', $_POST['trade_value']).'", ';
			$mysql_fields.='trade_fees="'.str_replace(',', '', $_POST['trade_fees']).'", ';
			$mysql_fields.='trade_invoiced="'.str_replace(',', '', $_POST['trade_invoiced']).'", ';
			$mysql_fields.='trade_date="'.$_POST['trade_date'].'", ';
			$mysql_fields.='trade_status="'.$_POST['trade_status'].'"';
			
			/*** FIX POSITIONS IF NEEDED ***/
			if ($row['trade_positions']!=$_POST['trade_positions']){
				// Get Related Buy
				$query2='SELECT trade_ref_relatedto, trade_positions_left FROM trades_related tr LEFT JOIN trades t ON trade_ref_relatedto=t.trade_ref 
				WHERE tr.trade_ref="'.$row['trade_ref'].'"';
				$res2=$db->rq($query2);
				$row2=$db->fetch($res2);
				
				// Update Related Buy
				$query3='UPDATE trades SET trade_positions_left=(trade_positions_left+'.($row['trade_positions']+0).') 
				WHERE trade_ref="'.$row2['trade_ref_relatedto'].'"';
				$db->rq($query3);
				
				$getUpdatedRow=$db->getRow('trades','trade_ref="'.$row2['trade_ref_relatedto'].'"','trade_positions_left');
				
				$NewPositionsCount=$getUpdatedRow['trade_positions_left']-$_POST['trade_positions'];
				if ($NewPositionsCount>0){
					$query='UPDATE trades SET trade_positions_left='.($NewPositionsCount+0).' WHERE trades_id='.($row['trades_id']+0).'';
					$db->rq($query);
				}else{
					$query='UPDATE trades SET trade_positions_left=0, trade_status=4 WHERE trades_id='.($row['trades_id']+0).'';
					$db->rq($query);
				}
			}
			
			$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
			/*** FIX USERS's BALANCE IF NEEDED ***/
			if ($fixPostValue==$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total are same, but status is different
				if ($_POST['trade_status']==1){
					$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}elseif($row['trade_status']==1){
					$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}
			}elseif ($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']==$row['trade_status']&&$row['trade_status']==1){ // if new total and old total are different, but status is same (open)
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total different and also status is different
				if ($_POST['trade_status']==1&&$row['trade_status']!=1){
					$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}else{
					$query='UPDATE users SET user_balance=(user_balance-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}
			}
			
			$query='UPDATE trades SET '.$mysql_fields.' WHERE trade_ref="'.$row['trade_ref'].'"';
			$db->rq($query);
			
			$link='sellref='.$row['trade_ref'];
			
			$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			addLog('Back-end','Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Sell edited '.($row['trade_ref']+0).' ('.$tradesSellStatuses[$_POST['trade_status']].')');
		}
	}
	$db->close();
	
	if($_POST['trade_status']==1) {
		header('Location: mails_singleuser.php?uid='.$_POST['user_account_num'].'&'.$link.'&noheader=1');
	}else{
		header('Location: /history.php');
	}
	exit();
}

if (isset($_POST['_form_submit'])&&$_POST['_add_edit_buy']==1){
	$db=new DBConnection();
	$mysql_fields='';
	$comma='';
	$count=0;
	foreach ($_POST as $k=>$x){
		if ($k!='tref'&&$k!='_submit'&&$k!='_form_submit'&&$k!='k'&&$k!='_add_edit_buy'){
			if ($count!=0) $comma=', ';
			if ($k=='commodities_id'){
				$explodeString=explode("_", $x);
				$x=$explodeString[0];
			}
			
			if ($k=='trade_premium_price'||$k=='trade_contract_size'||$k=='trade_price_contract'||$k=='trade_value'||$k=='trade_fees'||$k=='trade_invoiced'||$k=='trade_strikeprice') $x=str_replace(',', '', $x);
			
			$mysql_fields.=''.$comma.''.$k.'="'.$db->string_escape($x).'"';
			$count++ ;
		}
	}
	
	global $tradesStatuses;
	global $tradesBuyOptions;
	
	if (!$_POST['tref']){
		$tradeRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;
		$query='INSERT INTO trades SET '.$mysql_fields.', trade_positions_left='.($_POST['trade_positions']+0).', trade_type=1, trades_id="'.NID.'", trade_ref='.($tradeRef+0).', trade_action_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'"';
		$db->rq($query);
		
		if ($_POST['trade_status']==1){
			$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
			$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'", 
			user_trades=(user_trades+1) WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}
		$link='buyref='.$tradeRef;
		
		$currentLSCP_HPSP=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_lscp, user_hpsp');
		if($_POST['trade_option']==1) {
			if($_POST['trade_strikeprice']<$currentLSCP_HPSP['user_lscp']||$currentLSCP_HPSP['user_lscp']==0) {
				$query='UPDATE users SET user_lscp="'.($_POST['trade_strikeprice']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
				WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}else{
			if($_POST['trade_strikeprice']>$currentLSCP_HPSP['user_hpsp']||$currentLSCP_HPSP['user_hpsp']==0) {
				$query='UPDATE users SET user_hpsp="'.($_POST['trade_strikeprice']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
				WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}
		
		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Buy added '.($tradeRef+0).' ('.$tradesBuyOptions[$_POST['trade_option']].' @ '.$tradesStatuses[$_POST['trade_status']].')');
	}else{
		$query='SELECT * FROM trades WHERE trade_ref="'.$_POST['tref'].'" LIMIT 1';
		$res=$db->rq($query);
		$row=$db->fetch($res);
		
		$query='UPDATE trades SET '.$mysql_fields.', trade_positions_left='.($_POST['trade_positions']+0).', trade_type=1, trade_action_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
		WHERE trade_ref="'.$_POST['tref'].'"';
		$db->rq($query);
		
		$fixPostValue=str_replace(',', '', $_POST['trade_invoiced']);
		
		/*** FIX USERS's BALANCE IF NEEDED ***/
		if($fixPostValue==$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total are same, but status is different
			if ($_POST['trade_status']==1&&$row['trade_status']!=1&&$row['trade_status']!=4){
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['trade_status']==4&&$row['trade_status']!=1&&$row['trade_status']!=4){
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==1){
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==4){
				$query='UPDATE users SET user_balance=(user_balance+'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}elseif($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']==$row['trade_status']&&($row['trade_status']==1||$row['trade_status']==4)){ // if new total and old total are different, but status is same (open or closed)
			$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'+'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif ($fixPostValue!=$row['trade_invoiced']&&$_POST['trade_status']!=$row['trade_status']){ // if new total and old total different and also status is different
			if ($_POST['trade_status']==1&&$row['trade_status']!=1&&$row['trade_status']!=4){
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif ($_POST['trade_status']==4&&$row['trade_status']!=1&&$row['trade_status']!=4){
				$query='UPDATE users SET user_balance=(user_balance-'.($fixPostValue+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==1){
				$query='UPDATE users SET user_balance=(user_balance+'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}elseif (($_POST['trade_status']==2||$_POST['trade_status']==3)&&$row['trade_status']==4){
				$query='UPDATE users SET user_balance=(user_balance+'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
				$db->rq($query);
			}
		}
		
		/*** FIX TRADES COUNT IF NEEDED ***/
		if($_POST['trade_status']==1&&$row['trade_status']!=1) {
			$query='UPDATE users SET user_trades=(user_trades+1), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}elseif($_POST['trade_status']!=1&&$row['trade_status']==1) {
			$query='UPDATE users SET user_trades=(user_trades-1), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$_POST['user_account_num'].'"';
			$db->rq($query);
		}

		$currentLSCP_HPSP=$db->getRow('users', 'user_account_num="'.$_POST['user_account_num'].'"', 'user_lscp, user_hpsp');
		if ($_POST['trade_status']==1&&$row['trade_status']!=1){
			if ($_POST['trade_option']==1){
				if ($_POST['trade_strikeprice']<$currentLSCP_HPSP['user_lscp']||$currentLSCP_HPSP['user_lscp']==0){
					$query='UPDATE users SET user_lscp="'.($_POST['trade_strikeprice']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
				WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}
			}else{
				if ($_POST['trade_strikeprice']>$currentLSCP_HPSP['user_hpsp']||$currentLSCP_HPSP['user_hpsp']==0){
					$query='UPDATE users SET user_hpsp="'.($_POST['trade_strikeprice']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
				WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}
			}
		}elseif($_POST['trade_status']!=1&&$row['trade_status']==1) {
			if ($_POST['trade_option']==1){
				$query='SELECT MIN(trade_strikeprice) AS min_strike FROM trades WHERE trade_status=1 AND trade_option=1 AND user_account_num="'.$_POST['user_account_num'].'"';
				$res=$db->rq($query);
				$row=$db->fetch($res);
				if ($row['min_strike']<$currentLSCP_HPSP['user_lscp']||$currentLSCP_HPSP['user_lscp']==0){
					$query='UPDATE users SET user_lscp="'.($row['min_strike']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
				WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}
			}else{
				$query='SELECT MAX(trade_strikeprice) AS max_strike FROM trades WHERE trade_status=1 AND trade_option=2 AND user_account_num="'.$_POST['user_account_num'].'"';
				$res=$db->rq($query);
				$row=$db->fetch($res);
				if ($row['max_strike']>$currentLSCP_HPSP['user_hpsp']||$currentLSCP_HPSP['user_hpsp']==0){
					$query='UPDATE users SET user_hpsp="'.($row['max_strike']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
				WHERE user_account_num="'.$_POST['user_account_num'].'"';
					$db->rq($query);
				}
			}
		}elseif($_POST['trade_status']==1&&$row['trade_status']==1) {
			if ($_POST['trade_option']==1){
				if ($_POST['trade_strikeprice']<$currentLSCP_HPSP['user_lscp']||$currentLSCP_HPSP['user_lscp']==0){
					$query='SELECT MIN(trade_strikeprice) AS min_strike FROM trades WHERE trade_status=1 AND trade_option=1 AND user_account_num="'.$_POST['user_account_num'].'"';
					$res=$db->rq($query);
					$row=$db->fetch($res);
					if ($row['min_strike']<$currentLSCP_HPSP['user_lscp']||$currentLSCP_HPSP['user_lscp']==0){
						$query='UPDATE users SET user_lscp="'.($row['min_strike']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
						WHERE user_account_num="'.$_POST['user_account_num'].'"';
						$db->rq($query);
					}
				}
			}else{
				if ($_POST['trade_strikeprice']>$currentLSCP_HPSP['user_hpsp']){
					$query='SELECT MAX(trade_strikeprice) AS max_strike FROM trades WHERE trade_status=1 AND trade_option=2 AND user_account_num="'.$_POST['user_account_num'].'"';
					$res=$db->rq($query);
					$row=$db->fetch($res);
					if ($row['max_strike']>$currentLSCP_HPSP['user_hpsp']||$currentLSCP_HPSP['user_hpsp']==0){
						$query='UPDATE users SET user_hpsp="'.($row['max_strike']+0).'", user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" 
						WHERE user_account_num="'.$_POST['user_account_num'].'"';
						$db->rq($query);
					}
				}
			}
		}
		
		$link='buyref='.$_POST['tref'];
		$uDetails=$db->getRow('users','user_account_num="'.$_POST['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
		addLog('Back-end','Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Buy edited '.($_POST['tref']+0).' ('.$tradesBuyOptions[$_POST['trade_option']].' @ '.$tradesStatuses[$_POST['trade_status']].')');
	}
	
	$db->close();
	if($_POST['trade_status']==1) {
		header('Location: mails_singleuser.php?uid='.$_POST['user_account_num'].'&'.$link.'&noheader=1');
	}else{
		header('Location: /history.php');
	}
	exit();
}

function addNewTradeBuy($tradesBuy_id=0) {

	$db=new DBConnection();
	if ($tradesBuy_id&&!$_POST['_form_submit']){
		$query='SELECT * FROM trades WHERE trade_ref="'.$tradesBuy_id.'"';
		$res=$db->rq($query);
		$_POST=$db->fetch($res);
		$_SESSION['admin']['uedit']=$_POST['trades_id'];
		$JSCripts=' onchange="setDetails(0);"';
		$JSCriptsSelect=' onchange="setDetails(3);"';
		$JSCriptsPremium=' onchange="setDetails(1);"';
	}else{
		$_POST['trade_strikeprice']='0.0000';
		$_POST['trade_positions']=10;
		$JSCripts=' onchange="setDetails(0);"';
		$JSCriptsSelect=' onchange="setDetails(3);"';
		$JSCriptsPremium=' onchange="setDetails(1);"';
	}
	
	if ($_POST['trade_date']=='') $_POST['trade_date']=date('Y-m-d', CUSTOMTIME);
	
	global $tradesStatuses;
	global $tradesBuyOptions;
	
	$pcontent='';
	$pcontent.='
<div class="mainHolder">
<div class="hintHolder ui-state-default"><b>'.(($tradesBuy_id>0)?'Editing':'Adding New').' BUY Order</b></div>
<script type="text/javascript" src="../js/jquery.metadata.js"></script> 
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="js/forms/tradesBuy.js"></script>
<script type="text/javascript">
jQuery(document).ready(
	function($) {
		var sliderValue = '.$_POST['trade_positions'].';
		$("#slider").slider( {
			min : 1,
			max : 200,
			step : 1,
			value : [ sliderValue ],
			slide : function(event, ui) {
				$("#sliderVal").val(ui.value);
			}
		});

		$("#sliderVal").attr("value", sliderValue);

		$("#sliderVal").keyup(function() {
			var sliderValue = +this.value;
			if (sliderValue >= 1 && sliderValue <= 200) {
				$("#slider").slider("value", sliderValue);
			} else {
				alert("Please enter a value between 1 and 200");
				$("#slider").slider("value", 1);
				$("#sliderVal").attr("value", 1);
			}
		});

		$("#slider, #sliderVal").bind("mousedown mouseup mousemove mouseout mouseover",	function() {
			setDetails();
		});
		
		'.((!$tradesBuy_id)?'setDetails(3);':'setDetails(4);').'
});
</script>

<form name="addNewTradeBuy" method="POST" id="MainForms" action="">
<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Account</legend>
	<div class="formsRight">
		<select name="user_account_num" id="user_account_num" class="text-input-big" title="Please select user account!" validate="required:true"'.$JSCripts.'>
		<option value="">Select account</option>';
	
	$query='SELECT user_account_num, user_firstname, user_lastname, user_balance FROM users ORDER BY user_firstname ASC, user_lastname ASC';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		$pcontent.='<option value="'.$row['user_account_num'].'"'.(($_GET['uid']==$row['user_account_num']||$_POST['user_account_num']==$row['user_account_num'])?' selected':'').'>'.$row['user_account_num'].' ('.$row['user_firstname'].' '.$row['user_lastname'].', $'.$row['user_balance'].')</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	</fieldset>
	
	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Contract</legend>
	<div class="formsLeft">Trade Order:</div>
	<div class="formsRight">BUY</div>
	<br />
	<div class="formsLeft">Position(s):</div>
	<div class="formsRight">
		<div id="slider"><a href="#"></a></div> <input type="text" class="text-input-smallest left" id="sliderVal" name="trade_positions"'.$JSCripts.' />
	</div>
	
	<br /><br />
	<div class="formsLeft">Option:</div>
	<div class="formsRight">
		<select name="trade_option" id="trade_option" class="text-input"'.$JSCripts.'>';
	
	foreach ($tradesBuyOptions as $OptionID=>$OptionName){
		$pcontent.='<option value="'.$OptionID.'"'.(($OptionID==$_POST['trade_option'])?' selected':'').'>'.$OptionName.'</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	<br />
	<div class="formsLeft">Commodity:</div>
	<div class="formsRight">
		<select name="commodities_id" id="commodities_id" class="text-input"'.$JSCriptsSelect.'>';
	
	$query='SELECT * FROM commodities WHERE commodities_status=1 ORDER BY commodities_order_priority ASC, commodities_name ASC';
	$res=$db->rq($query);
	while (($row=$db->fetch($res))!=FALSE){
		$pcontent.='<option value="'.$row['commodities_id'].'_'.$row['commodities_symbol'].'_'.$row['commodities_contract_size'].'_'.$row['commodities_unit'].'_'.$row['commodities_def_fee'].'_'.$row['commodities_def_prem'].'"'.(($row['commodities_id']==$_POST['commodities_id'])?' selected':'').'>'.$row['commodities_symbol'].' ('.$row['commodities_name'].')</option>';
	}
	
	$pcontent.='
		</select>
	</div>
	
	<br />
	<div class="formsLeft">Expiry Date:</div>
	<div class="formsRight">
	    <select name="trade_expiry_date" id="trade_expiry_date" class="text-input"'.$JSCripts.'>';
	
	$query='SELECT * FROM expiry_dates ORDER BY expiry_dates_id';
	$res=$db->rq($query);
	$strToUse='';
	while (($row=$db->fetch($res))!=FALSE){
		$strToUse=strtotime($row['expiry_date']);
		$pcontent.='<option value="'.$row['expiry_date'].'"'.(($row['expiry_date']==$_POST['user_status'])?' selected':'').'>'.$row['expiry_short'].' ('.date('d M y', $strToUse).')</option>';
	}
	
	$pcontent.='
	    </select>
	</div>
	
	<br />
	<div class="formsLeft">Strike Price:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_strikeprice" id="trade_strikeprice" value="'.$_POST['trade_strikeprice'].'"'.$JSCripts.' />
	</div>
	</fieldset>
	
	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Trade Details</legend>
	<input class="ui-state-default trade-details" type="text" name="trade_details" id="trade_details" value="'.(($_POST['trade_details']!='')?''.$_POST['trade_details'].'':'BUY').'" readonly />
	</fieldset>';
	
	$totalRelated=0;
	$query2='SELECT trade_details, trades.trade_ref FROM trades_related tr LEFT JOIN trades ON tr.trade_ref=trades.trade_ref WHERE trade_ref_relatedto="'.$_POST['trade_ref'].'"';
	$res2=$db->rq($query2);
	$totalRelated=$db->num_rows($res2);
	if ($totalRelated>0){
		$pcontent.='
		<div class="clear"></div>
		<fieldset class="mainFormHolder left">
			<legend>Related Trades</legend><br />';
		while (($row2=$db->fetch($res2))!=FALSE){
			$pcontent.='<div class="ui-state-default trade-details"><a href="trades_noheader.php?action=edit_sell&tref='.$row2['trade_ref'].'" style="display:block;">'.$row2['trade_details'].'</a></div><br />';
		}
		
		$pcontent.='
		</fieldset>';
	}
	
	$pcontent.='
</div>

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Prices</legend>
	<div class="formsLeft">Premium:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_premium_price" id="trade_premium_price" value="'.$_POST['trade_premium_price'].'"'.$JSCriptsPremium.' />
	</div>
	<br />
	<div class="formsLeft">Contract Size:</div>
	<div class="formsRight">
		<input class="text-input align-right ui-state-default" type="text" name="trade_contract_size" id="trade_contract_size" value="'.$_POST['trade_contract_size'].'" readonly />
	</div>
	<br />
	<div class="formsLeft">Price/contract:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_price_contract" id="trade_price_contract" value="'.$_POST['trade_price_contract'].'"'.$JSCripts.' />
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
		<input class="text-input align-right ui-state-default" type="text" name="trade_invoiced" id="trade_invoiced" value="'.$_POST['trade_invoiced'].'" readonly />
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Settings</legend>
	<div class="formsLeft">Value date:</div>
	<div class="formsRight"><input class="text-input" type="text" name="trade_date" id="trade_date" value="'.$_POST['trade_date'].'" /></div>
	<br />
	<div class="formsLeft">Status:</div>
	<div class="formsRight">
		<select name="trade_status" class="text-input">';
	
	foreach ($tradesStatuses as $StatusID=>$StatusName){
		$pcontent.='<option value="'.$StatusID.'"'.(($StatusID==$_POST['trade_status'])?' selected':'').'>'.$StatusName.'</option>';
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
	<input type="hidden" name="_add_edit_buy" value="1" />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default" />';
		if ($tradesBuy_id){
			$pcontent.='
	<input type="hidden" name="tref" value="'.$tradesBuy_id.'">
	<input type="button" name="_delete" value="'.getLang('sform_delbtn').'" class="submitBtn ui-state-default" onclick="if(confirm(\'Are you sure you want to delete this BUY?\')) location=\'?action=delete_buy&buyid='.($_POST['trade_ref']).'\';" />';
		}
	}else{
		$pcontent.='
    <div class="ui-state-error bold" style="width:300px; margin:auto; padding:5px;">
	    These BUY trade have been partially or totally sold and therefore cannot be updated.
	</div>';
	}
	$pcontent.='
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'/history.php\';" />
	</div>
</div>
</form>
</div>';
	$db->close();
	return $pcontent;
}

function listTrades() {

	$pcontent='';
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
</style>
<script type="text/javascript" src="js/jquery.simplemodal-1.3.3.min.js"></script>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_trades.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Trades</b></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tradesTable">
	<thead>
	    <tr>
		<th><b>REF #</b></th>
		<th><b>Account</b></th>
		<th><b>Account Name</b></th>
		<th><b>Details</b></th>
		<th><b>Opt</b></th>
		<th><b>Expiry</b></th>
		<th><b>Prm</b></th>
		<th><b>SP</b></th>
		<th><b>Price</b></th>
		<th><b>Date</b></th>
		<th><b>Status</b></th>
		<th><b></b></th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
		<td colspan="11" class="dataTables_empty">Loading data from server</td>
	    </tr>
	</tbody>
    </table>
</div>';
	
	return $pcontent;
}

function listOpenTrades() {

	$pcontent='';
	$pcontent.='
<style type="text/css">
@import "css/table_jui.css";
@import "tables/media/css/TableTools.css";
</style>
<script type="text/javascript" src="tables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="tables/media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="tables/media/js/TableTools.js"></script>
<script type="text/javascript" src="tables/tables_tradesOpen.js"></script>
<div class="mainHolder">
    <div class="hintHolder ui-state-default"><b>List All Open Trades</b></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tradesTable">
	<thead>
	    <tr>
		<th><b>REF #</b></th>
		<th><b>Account</b></th>
		<th><b>Account Name</b></th>
		<th><b>Details</b></th>
		<th><b>Opt</b></th>
		<th><b>Expiry</b></th>
		<th><b>Prm</b></th>
		<th><b>SP</b></th>
		<th><b>Price</b></th>
		<th><b>Date</b></th>
		<th><b>Status</b></th>
		<th><b></b></th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
		<td colspan="11" class="dataTables_empty">Loading data from server</td>
	    </tr>
	</tbody>
    </table>
</div>';
	
	return $pcontent;
}

function addNewTradeSell($tradesSell_id=0) {

	$db=new DBConnection();
	if ($tradesSell_id&&!$_POST['_form_submit']){
		$query='SELECT * FROM trades WHERE trade_ref="'.$tradesSell_id.'"';
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
<script type="text/javascript" src="js/forms/tradesSell.js"></script>
<script type="text/javascript">
jQuery(document).ready(
	function($) {
		var sliderValue = '.$_POST['trade_positions_left'].';
		$("#slider").slider( {
			min : 1,
			max : '.$_POST['trade_positions_left'].',
			step : 1,
			value : [ sliderValue ],
			slide : function(event, ui) {
				$("#sliderVal").val(ui.value);
			}
		});

		$("#sliderVal").attr("value", sliderValue);

		$("#sliderVal").keyup(function() {
			var sliderValue = +this.value;
			if (sliderValue >= 1 && sliderValue <= '.$_POST['trade_positions_left'].') {
				$("#slider").slider("value", sliderValue);
			} else {
				alert("Please enter a value between 1 and '.$_POST['trade_positions_left'].'");
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
	<div class="formsLeft">Position(s):</div>
	<div class="formsRight">
		<div id="slider"><a href="#"></a></div> <input type="text" class="text-input-smallest left" id="sliderVal" name="trade_positions"'.$JSCripts.' />
	</div>
	
	<br /><br />
	<div class="formsLeft">Option:</div>
	<div class="formsRight"><input class="text-input ui-state-default" type="text" name="trade_option" id="trade_option" value="'.$tradesBuyOptions[$_POST['trade_option']].'"></div>
	<br />
	<div class="formsLeft">Commodity:</div>
	<div class="formsRight">';
	
	$query='SELECT * FROM commodities WHERE commodities_id='.($_POST['commodities_id']+0).' LIMIT 1';
	$res=$db->rq($query);
	$row=$db->fetch($res);
	
	$strToUse=strtotime($_POST['trade_expiry_date']);
	$pcontent.='
    	<input class="text-input ui-state-default" type="text" name="commodities_id" id="commodities_id" value="'.$row['commodities_symbol'].' ('.$row['commodities_name'].')">
	</div>
	
	<br />
	<div class="formsLeft">Expiry Date:</div>
	<div class="formsRight">
	    <div class="formsRight"><input class="text-input ui-state-default" type="text" name="trade_expiry_date" id="trade_expiry_date" value="'.date('d M y', $strToUse).'"></div>
	</div>
	
	<br />
	<div class="formsLeft">Strike Price:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_strikeprice" id="trade_strikeprice" value="'.$_POST['trade_strikeprice'].'"'.$JSCripts.' />
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
		$getRelatedInfo=$db->getRow('trades','trade_ref="'.$row2['trade_ref_relatedto'].'"','trade_ref, trade_details');
		$pcontent.='
		<fieldset class="mainFormHolder left">
			<legend>Related Trades</legend><br />
			<div class="ui-state-default trade-details"><a href="trades_noheader.php?action=edit_buy&tref='.$getRelatedInfo['trade_ref'].'" style="display:block;">'.$getRelatedInfo['trade_details'].'</a></div><br />
		</fieldset>';
	}
	
	$pcontent.='
</div>

<div class="left">
	<fieldset class="mainFormHolder left">
	<legend>Prices</legend>
	<div class="formsLeft">Premium:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_premium_price" id="trade_premium_price" value="'.$_POST['trade_premium_price'].'"'.$JSCriptsPremium.' />
	</div>
	<br />
	<div class="formsLeft">Contract Size:</div>
	<div class="formsRight">
		<input class="text-input align-right ui-state-default" type="text" name="trade_contract_size" id="trade_contract_size" value="'.$_POST['trade_contract_size'].'" readonly />
	</div>
	<br />
	<div class="formsLeft">Price/contract:</div>
	<div class="formsRight">
		<input class="text-input align-right" type="text" name="trade_price_contract" id="trade_price_contract" value="'.$_POST['trade_price_contract'].'"'.$JSCripts.' />
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
		<input class="text-input align-right ui-state-default" type="text" name="trade_invoiced" id="trade_invoiced" value="'.$_POST['trade_invoiced'].'" readonly />
	</div>
	</fieldset>

	<div class="clear"></div>

	<fieldset class="mainFormHolder left">
	<legend>Settings</legend>
	<div class="formsLeft">Value date:</div>
	<div class="formsRight"><input class="text-input" type="text" name="trade_date" id="trade_date" value="'.$_POST['trade_date'].'" /></div>
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
	<input type="button" name="_cancel" value="'.getLang('sform_backbtn').'" class="submitBtn ui-state-default" onclick="location=\'/history.php\';" />
	</div>
</div>
</form>
</div>';
	$db->close();
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
	case 'new_buy' :
		$page_content=addNewTradeBuy();
		break;
	case 'edit_buy' :
		$exp="/[^a-zA-Z0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: /history.php');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeBuy($_GET['tref']);
			}else{
				header('Location: /history.php');
				exit();
			}
		}
		break;
	case 'delete_buy' :
		if ($_SESSION['admin']['is_logged']==1){
			$exp="/[^a-zA-Z0-9]/i";
			$check=preg_match($exp, $_GET['buyid']);
			if (($check+0)==1||$_GET['buyid']==''){
				header('Location: /history.php');
				exit();
			}
			$db=new DBConnection();
			$query='SELECT * FROM trades_related WHERE trade_ref_relatedto="'.($_GET['buyid']+0).'"';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			
			if($num_rows>0) {
				header('Location: /history.php');
				exit();
			}
			
			$query='SELECT * FROM trades WHERE trade_ref="'.($_GET['buyid']+0).'"';
			$res=$db->rq($query);
			$row=$db->fetch($res);
			
			if ($row['trade_type']==1&&($row['trade_status']==1||$row['trade_status']==4)){
				$query='UPDATE users SET user_balance=(user_balance+'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$row['user_account_num'].'"';
				$db->rq($query);
			}
			
			$query='DELETE FROM trades WHERE trade_ref="'.$_GET['buyid'].'"';
			$db->rq($query);
			
			$uDetails=$db->getRow('users','user_account_num="'.$row['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			global $tradesStatuses;
			addLog('Back-end','Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Buy deleted '.($row['trade_ref']+0).' ('.$tradesStatuses[$row['trade_status']].')');
			
			$db->close();
			header('Location: /history.php');
			exit();
		}
		break;
	case 'list_open' :
		$page_content=listOpenTrades();
		break;
	case 'new_sell' :
		$exp="/[^0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: trades.php?action=list_open');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeSell($_GET['tref']);
			}else{
				header('Location: /history.php');
				exit();
			}
		}
		break;
	case 'edit_sell' :
		$exp="/[^a-zA-Z0-9]/i";
		$check=preg_match($exp, $_GET['tref']);
		if (($check+0)==1||$_GET['tref']==''){
			header('Location: /history.php');
			exit();
		}else{
			$db=new DBConnection();
			$query='SELECT trades_id FROM trades WHERE trade_ref="'.$_GET['tref'].'" LIMIT 1';
			$res=$db->rq($query);
			$num_rows=$db->num_rows($res);
			$db->close();
			if ($num_rows>0){
				$page_content=addNewTradeSell($_GET['tref']);
			}else{
				header('Location: /history.php');
				exit();
			}
		}
		break;
	case 'delete_sell' :
		if ($_SESSION['admin']['is_logged']==1){
			$exp="/[^a-zA-Z0-9]/i";
			$check=preg_match($exp, $_GET['sellid']);
			if (($check+0)==1||$_GET['sellid']==''){
				header('Location: /history.php');
				exit();
			}
			$db=new DBConnection();
			
			$query='SELECT * FROM trades WHERE trade_ref="'.($_GET['sellid']+0).'"';
			$res=$db->rq($query);
			$row=$db->fetch($res);
			
			$query2='SELECT * FROM trades_related WHERE trade_ref="'.($_GET['sellid']+0).'"';
			$res2=$db->rq($query2);
			$row2=$db->fetch($res2);
			
			$query3='UPDATE trades SET trade_positions_left=(trade_positions_left+'.($row['trade_positions']+0).') 
			WHERE trade_ref="'.$row2['trade_ref_relatedto'].'"';
			$db->rq($query3);
			
			$checkPositions=$db->getRow('trades','trade_ref="'.$row2['trade_ref_relatedto'].'"','trade_positions_left');
			if($checkPositions['trade_positions_left']>0) {
				$query4='UPDATE trades SET trade_status=1 WHERE trade_ref="'.$row2['trade_ref_relatedto'].'"';
				$db->rq($query4);
			}
			
			if ($row['trade_type']==2&&$row['trade_status']==1){
				$query='UPDATE users SET user_balance=(user_balance-'.($row['trade_invoiced']+0).'), user_lastupdate="'.date('Y-m-d H:i:s', CUSTOMTIME).'" WHERE user_account_num="'.$row['user_account_num'].'"';
				$db->rq($query);
			}
			
			$query='DELETE FROM trades_related WHERE trade_ref="'.$_GET['sellid'].'"';
			$db->rq($query);
			
			$query='DELETE FROM trades WHERE trade_ref="'.$_GET['sellid'].'"';
			$db->rq($query);
			
			$uDetails=$db->getRow('users','user_account_num="'.$row['user_account_num'].'"','user_firstname, user_lastname, user_account_num');
			global $tradesSellStatuses;
			addLog('Back-end','Trades',''.$uDetails['user_firstname'].' '.$uDetails['user_lastname'].' ('.$uDetails['user_account_num'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Sell deleted '.($row['trade_ref']+0).' ('.$tradesSellStatuses[$row['trade_status']].')');
			
			$db->close();
			header('Location: /history.php');
			exit();
		}
		break;
	default :
		$page_content=listTrades();
		break;
}

page_header(0);
echo $page_content;
page_footer();
?>