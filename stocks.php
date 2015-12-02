<?php
require_once('template.php');

page_header(2);

if($_SESSION['user']['is_logged'] == 1) {

	$db=new DBConnection();

	$line = array();

	$line2 = array();

	$query = $db->rq("SELECT value_change, stocks_id FROM stock_details ORDER BY date DESC, value_change DESC LIMIT 2");

	while($details = $db->fetch($query)) { 

		$subq = $db->rq("SELECT stocks_symbol, stocks_name FROM stocks WHERE stocks_id='".$details['stocks_id']."' LIMIT 1");

		$stock = $db->fetch($subq);

		$stock['stocks_name'] = stripslashes($stock['stocks_name']);

		$line[$stock['stocks_name']] = $details['value_change'];

	}

	$query = $db->rq("SELECT value_change, stocks_id FROM stock_details ORDER BY date DESC, value_change ASC LIMIT 2");

	while($details = $db->fetch($query)) { 

		$subq = $db->rq("SELECT stocks_symbol, stocks_name FROM stocks WHERE stocks_id='".$details['stocks_id']."' LIMIT 1");

		$stock = $db->fetch($subq);

		$stock['stocks_name'] = stripslashes($stock['stocks_name']);

		$line2[$stock['stocks_name']] = $details['value_change'];

	}

	

?> 

<script type="text/javascript">

$(document).ready(function(){

  var line1 = [

  	<?php 

		foreach($line as $lname => $lvalue) { 

			echo "['".$lname."', ".$lvalue."],"; 

		}

	?>

  ];

  var plot1b = $.jqplot('chart1b', [line1], {

	series:[{renderer:$.jqplot.BarRenderer, color:'#008040'}],

	axesDefaults: {

		tickRenderer: $.jqplot.CanvasAxisTickRenderer ,

		tickOptions: {

		  fontFamily: 'Georgia',

		  fontSize: '10pt'

		}

	},

	axes: {

	  xaxis: {

		renderer: $.jqplot.CategoryAxisRenderer

	  }

	}

  });

  

  var line2 = [

	<?php 

		foreach($line2 as $l2name => $l2value) { 

			echo "['".$l2name."', ".$l2value."],"; 

		}

	?>

  ];

  var plot2b = $.jqplot('chart2b', [line2], {

	series:[{renderer:$.jqplot.BarRenderer, color:'#ffb3b3'}],

	axesDefaults: {

		tickRenderer: $.jqplot.CanvasAxisTickRenderer ,

		tickOptions: {

		  fontFamily: 'Georgia',

		  fontSize: '10pt', 

		  color: '#f3f3f3'

		}

	},

	axes: {

	  xaxis: {

		renderer: $.jqplot.CategoryAxisRenderer

	  }

	}

  });

});

</script>

<?php
	
	$tab='<div class="box grid_16 tabs">			
					<ul class="tab_header clearfix">
	';

	$tab_content='<div class="toggle_container">';
	

	$query='SELECT trade_price_share, stocks_id, trade_shares_left FROM stock_trades WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" AND trade_type="1"';

	$res=$db->rq($query);

	$change_price = 0;

	$present_prices = 0;

	$past_prices = 0;

	while($trade=$db->fetch($res)) { 

		$subq=$db->rq('SELECT value FROM stock_details WHERE stocks_id="'.$trade['stocks_id'].'" ORDER BY date DESC LIMIT 1');

		$detail=$db->fetch($subq);

		$present_prices+=$detail['value']*$trade['trade_shares_left'];

		$past_prices+=$trade['trade_price_share']*$trade['trade_shares_left']; 

	}

	if($past_prices) { 

	$change = number_format((($present_prices-$past_prices)/$past_prices)*100, 2); 

	} else { 

	$change = 0;

	}

	if($change < 0) { 

		$change = '<span class="icon loss"></span>'.(-1*$change).'%'; 

	} else if($change > 0) { 

		$change = '<span class="icon win"></span>'.$change.'%'; 

	} else { 

		$change = $change.'%'; 

	}?>

	<div class="flat_area grid_16" style="opacity: 1;">
    <h2><?php echo getLang('market_head')?>
        </h2>
    </div>
<?php 

	$tab.='<li><a href="#tabs-1">'.getLang('market_performance').'</a></li>';

 //    echo '
	// <div class="grid_8 box">';

	


$query = $db->rq("SELECT user_balance FROM users WHERE user_account_num='".$_SESSION['user']['user_account_num']."' LIMIT 1");

$row = $db->fetch($query);
$query2 = $db->rq('SELECT trade_date FROM stock_trades WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" ORDER BY trade_date ASC');

$row2=$db->fetch($query2);

$tab_content.='<div id="tabs-1" class="block">
						<div class="section" >
							<ul class="flat">';
	if($row2['trade_date']) {
		$tab_content.='<li class="columns"><div class="col_50">'.getLang('market_inception').'</div><div class="col_50"><b>'.date('d M Y', strtotime($row['trade_date'])).'</b></div></li>';
	}		
		$tab_content.='<li class="columns"><div class="col_50">'.getLang('market_perform_today').' ('.date("M d").')</div>
						 		<div class="col_50">'.$change.'</div></li>
								<li class="columns"><div class="col_50">'.getLang('market_perform_holdings').'</div> 
								<div class="col_50">'.number_format($present_prices, 2).'</div></li>
								<li class="columns"><div class="col_50">'.getLang('market_perform_cash').'</div> 
								<div class="col_50">'.number_format($row['user_balance'], 2).'</div></li>
								<li class="columns"><div class="col_50">'.getLang('market_perform_total').'</div>
								<div class="col_50"><b><span style="color: #393;font-size: 16px;">   '.number_format(($row['user_balance'] + $present_prices), 2).'</span></b></div></li>
							</ul>
						</div>
					</div>
				';


// echo '<div class="inset green">
	
// 	<h2 class="box_head">'.getLang('market_performance').'</h2>
// 		<div class="section" style="background-color: #DEF3DE;color: #060;">
// 			<ul class="flat">
// 				<li><span class="xLabel">'.getLang('market_perform_today').' ('.date("M d").')</span> '.$change.'</li>
// 				<li><span class="xLabel">'.getLang('market_perform_holdings').'</span> '.number_format($present_prices, 2).'</li>
// 				<li><span class="xLabel">'.getLang('market_perform_cash').'</span> '.number_format($row['user_balance'], 2).'</li>
// 				<li><span class="xLabel">'.getLang('market_perform_total').'</span> '.number_format(($row['user_balance'] + $present_prices), 2).'</li>
// 			</ul>
// 		</div>
// 	</div>
// 	</div>
// 	';

	

// $query = $db->rq('SELECT trade_date FROM stock_trades WHERE user_account_num="'.$_SESSION['user']['user_account_num'].'" ORDER BY trade_date ASC');

// $row=$db->fetch($query);

// if($row['trade_date']) { 
// 	$tab.='<li><a href="#tabs-2">'.getLang('market_inception').'</a></li>';

// 	$tab_content.='<div id="tabs-2" class="block">

// 						<div class="section">
// 							<h4>'.date('d M Y', strtotime($row['trade_date'])).'</h4>
// 						</div>

// 					</div>';
// 	// echo '<div class="grid_8 box">
			
// 	// 		<h2 class="box_head">'.getLang('market_inception').'</h2>

// 	// 		<div class="section">
// 	// 		<h4>'.date('d M Y', strtotime($row['trade_date'])).'</h4>';

// 	// echo '
// 	// 		</div>
// 	// </div>';

// }

$tab.='<li><a href="#tabs-3">'.getLang('market_today_win').'</a></li>';

	$tab_content.='<div id="tabs-3" class="block">

						<div class="section">
							<div id="chart1b" style="height:300px;width:320px; "></div>
						</div>

					</div>';
$tab.='<li><a href="#tabs-4">'.getLang('market_today_lose').'</a></li>';

	$tab_content.='<div id="tabs-4" class="block">

						<div class="section">
							<div id="chart2b" style="height:300px;width:320px; "></div>
						</div>

					</div>';	

// echo '<div class="grid_8 box">
		
// 		<h2 class="box_head">'.getLang('market_today_win').'</h2>
// 		<div class="section">
// 		';

// echo '	<div id="chart1b" style="height:300px;width:320px; "></div>
// 		</div>
// 	</div>';

// echo '<div class="grid_8 box">
		
// 		<h2 class="box_head">'.getLang('market_today_lose').'</h2>
// 		<div class="section">
// 		';

// echo '	<div id="chart2b" style="height:300px;width:320px; "></div>
// 		</div>
// 	</div>';

$tab.="</ul>";
$tab_content.="</div></div>";
echo $tab;
echo $tab_content;

$watchlist = new App\Model\Watchlist($db);
$stocks = $watchlist->getList('id', 'stock_name', "user_account_num = '{$_SESSION['user']['user_account_num']}'");

echo '
    <div class="box grid_16">
        <h2 class="box_head round_all">Stock Watch List</h2>
        <div class="controls">
            <a href="#" class="toggle toggle_open"></a>
        </div>
        <div class="toggle_container">
            <div class="block">
                <div class="button_bar clearfix">
                    <label>Manage Watch List:</label>
                    <button class="blue dialog_button" data-dialog="manage-watchlist">
                        <span>Manage</span>
                    </button>
                </div>
            </div>
        </div>
    </div>';

    include_once 'includes/stock_watchlist_modal.php';


}

page_footer();