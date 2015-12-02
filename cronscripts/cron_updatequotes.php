<?php
require '../vendor/autoload.php';

require_once('../classes/db.class.php');
require_once('../classes/simplehtmldom/simple_html_dom.php');
require_once('../includes/timefix.php');
include ('../includes/nomad_mimemail.inc.php');
set_time_limit(900);
$db=new DBConnection();
$today=date('Y-m-d', CUSTOMTIME);
$detRef=hexdec(substr(uniqid(''), 0, 10))-81208208208;

$query = $db->rq("SELECT stocks_symbol, stocks_id FROM stocks ORDER BY stocks_symbol ASC");
while($row = $db->fetch($query)) { 
	$subq=$db->rq("SELECT value FROM stock_details WHERE stocks_id='".$row['stocks_id']."' and date!='".$today."' ORDER BY date DESC LIMIT 1");
	$subrow=$db->fetch($subq);
	$past_price = $subrow['value'];
	
	$curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, 'http://www.marketwatch.com/investing/stock/'.$row['stocks_symbol'].'/');  
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);  
	$str = curl_exec($curl);  
	curl_close($curl);  
	
	$html = str_get_html($str);
	$pricewrap = $html->find('div.pricewrap');
	if($pricewrap) { 
		$current_price = $pricewrap[0]->find('p[class="data bgLast"]');
		$curprice = $current_price[0]->innertext;
		if($past_price) { 
			$change = (($curprice-$past_price)/$past_price)*100; 
			$change = round($change, 2);
		} else { 
			$change = 0;
		}
		$volumewrap = $html->find('p[class="lastcolumn data"]');
		$current_volume = $volumewrap[1]->find('span');
		$curvolume = str_replace(',', '.', $current_volume[1]->innertext);
		$html->clear();
		
		$check_exist_q = $db->rq("SELECT value FROM stock_details WHERE stocks_id='".$row['stocks_id']."' and date='".$today."'");
		$exist = $db->num_rows($check_exist_q) > 0;

		if($exist){
			$db->rq("UPDATE stock_details SET details_ref='".$detRef."', 
		volume='".$curvolume."', value='".$curprice."', value_change='".$change."' where stocks_id='".$row['stocks_id']."' and date='".$today."'");
		}else{
			$db->rq("INSERT INTO stock_details SET stocks_id='".$row['stocks_id']."', details_ref='".$detRef."', date='".$today."', 
		volume='".$curvolume."', value='".$curprice."', value_change='".$change."'");
		}
	}
	sleep(10);
}

$db->close();
?>