<?php
require_once('template.php');

// menu bar
page_header(3);

if($_SESSION['user']['is_logged'] == 1) {

	$db = new DBConnection();

    echo '
        <div class="flat_area grid_16" style="opacity: 1;">
            <h2>'.getLang('charts_head').'<small> 	- '.getLang('charts_subhead').'</small></h2>
        </div>
	';

$watchlist = new App\Model\Watchlist($db);
$stocks = $watchlist->getList('id', 'stock_name', "user_account_num = '{$_SESSION['user']['user_account_num']}'");
$stocksWidget = $watchlist->getWidgetStocks("user_account_num = '{$_SESSION['user']['user_account_num']}'");

echo '
<div class="grid_16 block box">

    <!-- TradingView Widget BEGIN -->
    <script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget({
            "width": 900,
            "height": 500,
            "symbol": "FX:SPX500",
            "interval": "D",
            "timezone": "exchange",
            "theme": "White",
            "toolbar_bg": "#f1f3f6",
            "hide_top_toolbar": false,
            "allow_symbol_change": true,
            "save_image": false,
            "watchlist": [
                ' . $stocksWidget . '
            ],
            "details": true,
            "hideideas": true
        });
    </script>
    <!-- TradingView Widget END -->

</div>									
';

echo ' 
    <div class="box grid_16">
        <h2 class="box_head round_all">'.getLang('charts_box_head').'</h2>
        <div class="controls">
            <a href="#" class="toggle toggle_open"></a>
        </div>
        <div class="toggle_container">
            <div class="block">
                <div class="button_bar clearfix">
                    <label>'.getLang('charts_box_text').'</label>
                    <button class="blue dialog_button" data-dialog="manage-watchlist">
                        <span>'.getLang('charts_button').'</span>
                    </button>
                </div>
            </div>
        </div>
    </div>';

include 'includes/stock_watchlist_modal.php';

}



page_footer();

?>
