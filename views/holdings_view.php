<section class="panel">
	<header class="panel-heading">
		<strong><?php echo getLang('holding_head')?></strong>
		<span class="tools pull-right">
			<a href="javascript:;" class="fa fa-chevron-down"></a>
			<a href="javascript:;" class="fa fa-cog"></a>
			<a href="javascript:;" class="fa fa-times"></a>
		 </span>
	</header>
	<div class="panel-body">
		<div class="adv-table table-responsive">
			<table class="display table table-hover table-bordered table-striped" id="dynamic-table">
				<thead>
					<tr>
						<th><?php echo getLang('holding_th_name')?></th>
						<th><?php echo getLang('holding_th_qty')?></th>
						<th><?php echo getLang('holding_th_price')?></th>
						<th><?php echo getLang('holding_th_last')?></th>
						<th><?php echo getLang('holding_th_today')?></th>
						<th><?php echo getLang('holding_th_cost')?></th>
						<th><?php echo getLang('holding_th_value')?></th>
						<th><?php echo getLang('holding_th_profit')?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($result as $row):
					$stock = & $row['stock'];
					$details = & $row['details'];
					?>
					<tr>
						<td><?php echo stripslashes($stock['stocks_name']), ' (', $stock['stocks_symbol'], ')'?></td>
						<td><?php echo $row['trade_shares_left']?></td>
						<td>$ <?php echo number_format($row['trade_price_share'], 2)?></td>
						<td>$ <?php echo number_format($details['value'],2)?></td>
						<td><?php echo $details['value_change']?></td>
						<td>$ <?php echo number_format($row['trade_value'],2)?></td>
						<td>$ <?php echo number_format($row['cur_value'],2)?></td>
						<td <?php echo $row['profit_class']?>><?php echo number_format($row['profit'],2)?>%</td>
					</tr>
				<?php endforeach;?>
				<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo getLang('holding_total')?></td>
					<td><?php echo $total_change?></td>
					<td><?php echo number_format($total_cost, 2)?></td>
					<td><?php echo number_format($total_value, 2)?></td>
					<td><span <?php echo $profit_class?>><?php echo number_format($total_profit, 2)?></span></td>
				</tr></tfoot>
				</tbody>
			</table>
		</div>
	</div>
</section>