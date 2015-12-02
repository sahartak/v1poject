<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue">
		<ul class="nav nav-tabs nav-justified ">
			<?php $activated = false;
			if($user['trading_type'] == 1 || $user['trading_type'] == 3): $activated = true;?>
			<li class="active">
				<a data-toggle="tab" href="#hist_trade_head">
					<?php echo getLang('hist_trade_head')?>
				</a>
			</li>
			<?php endif;
			if($user['trading_type'] == 2 || $user['trading_type'] == 3):?>
			<li class="<?php if(!$activated){ $activated = true; echo 'active';}?>">
				<a data-toggle="tab" href="#hist_stock_head">
					<?php echo getLang('hist_stock_head')?>
				</a>
			</li>
			<?php endif;?>
			<li class="<?php if(!$activated){ $activated = true; echo 'active';}?>">
				<a data-toggle="tab" href="#hist_fund_head">
					<?php echo getLang('hist_fund_head')?>
				</a>
			</li>
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content tasi-tab">

		<?php $activated = false;
		if($user['trading_type'] == 1 || $user['trading_type'] == 3): $activated = true;?>
			<div id="hist_trade_head" class="table-responsive tab-pane active">
				<table class="display table table-hover table-bordered table-striped dynamic-tables">
					<thead>
					<tr>
						<td><?php echo getLang('hist_trade_date')?></td>
						<td><?php echo getLang('hist_trade_id')?></td>
						<td><?php echo getLang('hist_trade_detail')?></td>
						<td><?php echo getLang('hist_trade_opt')?></td>
						<td><?php echo getLang('hist_trade_expiry')?></td>
						<td><?php echo getLang('hist_trade_prem')?></td>
						<td><?php echo getLang('hist_trade_strike')?></td>
						<td><?php echo getLang('hist_trade_price')?></td>
						<td><?php echo getLang('hist_trade_status')?></td>
					</tr>
					</thead>
					<tbody>
					<?php foreach($hist_trade_head as $row): ?>
						<tr>
							<td><?php echo date('d M Y', strtotime($row['trade_date']))?></td>
							<td><?php echo $row['trade_ref']?></td>
							<td><?php echo $row['trade_details']?></td>
							<td><?php echo $tradesBuyOptions[$row['trade_option']]?></td>
							<td><?php echo date('d M Y',strtotime($row['trade_expiry_date']))?></td>
							<td>$<?php echo number_format($row['trade_premium_price'],4)?></td>
							<td>$<?php echo number_format($row['trade_strikeprice'],2)?></td>

							<td>$<?php echo number_format($row['trade_value'],2)?></td>
							<td><?php echo $row['status']?></td>
						</tr>
					<?php endforeach;?>

					</tbody>
				</table>
			</div>
		<?php endif;

		if($user['trading_type'] == 2 || $user['trading_type'] == 3):?>
			<div id="hist_stock_head" class="table-responsive tab-pane <?php if(!$activated){ $activated = true; echo 'active';}?>">
				<table class="display table table-bordered table-hover table-striped dynamic-tables">
					<thead>
					<tr>
						<td><?php echo getLang('hist_trade_date')?></td>
						<td><?php echo getLang('hist_trade_id')?></td>
						<td><?php echo getLang('hist_trade_detail')?></td>
						<td><?php echo getLang('hist_trade_price')?></td>
						<td><?php echo getLang('hist_trade_status')?></td>
					</tr>
					</thead>
					<tbody>
					<?php foreach($hist_stock_head as $row): ?>
						<tr>
							<td><?php echo date('d M Y',strtotime($row['trade_date'])) ?></td>
							<td><?php echo $row['trade_ref'] ?></td>
							<td><?php echo $row['trade_details'] ?></td>
							<td>$<?php echo number_format($row['trade_value'],2) ?></td>
							<td><?php echo $row['status'] ?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
		<?php endif;?>

			<div id="hist_fund_head" class="table-responsive tab-pane <?php if(!$activated){ $activated = true; echo 'active';}?>">
				<table class="display table table-bordered table-hover table-striped dynamic-tables">
					<thead>
					<tr>
						<td><?php echo getLang('hist_fund_date')?></td>
						<td><?php echo getLang('hist_fund_id')?></td>
						<td><?php echo getLang('hist_fund_type')?></td>
						<td><?php echo getLang('hist_fund_valdate')?></td>
						<td><?php echo getLang('hist_fund_amount')?></td>
						<td><?php echo getLang('hist_fund_fees')?></td>
						<td><?php echo getLang('hist_fund_total')?></td>
						<td><?php echo getLang('hist_fund_status')?></td>
						<td><?php echo getLang('hist_fund_notes')?></td>
					</tr>
					</thead>
					<tbody>
					<?php foreach($hist_fund_head as $row): ?>
						<tr>
							<td><?php echo date('d M Y',strtotime($row['tr_date']))?></td>
							<td><?php echo $row['tr_ref']?></td>
							<td><?php echo $transfersOptions[$row['tr_type']]?></td>
							<td><?php echo date('d M Y',strtotime($row['tr_date']))?></td>
							<td>$<?php echo number_format($row['tr_value'],2)?></td>
							<td>$<?php echo number_format($row['tr_fees'],2)?></td>
							<td>$<?php echo number_format($row['tr_total'],2)?></td>
							<td><?php echo $depositOptions[$row['tr_status']]?></td>
							<td><?php echo $row['tr_notes']?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</section>

<div class="row">
	<div class="col-md-12">
		<!--pagination start-->
		<section class="panel">
			<header class="panel-heading">
				Account Actions
							<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							</span>
			</header>
			<div class="panel-body">

				<?php if(isset($_SESSION['history_msg'])):?>
					<div class="alert alert-success fade in">
						<button data-dismiss="alert" class="close close-sm" type="button">
							<i class="fa fa-times"></i>
						</button>
						<?php echo $_SESSION['history_msg']?>
					</div>
					<?php unset($_SESSION['history_msg']); endif;?>

				<p>For trade request, please inform us using this form.  You will be contacted by an advisor after your request.</p>
				<p><b>Buy or Sell Request:</b> &nbsp; <a class="btn btn-primary" data-toggle="modal" href="#myModal2">Trade Request</a></p>

				<!-- Modal -->
				<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form class="cmxform valid_form form-horizontal" role="form" action="history.php" method="post">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Trade Request</h4>
								</div>
								<div class="modal-body">

                                    <div class="alert alert-info fade in">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <p>Please leave your note and alternate contact method here</p>
                                    </div>

									<div class="form-group">
										<label for="details" class="col-sm-5 control-label"><p>Request Details <br /> <span>Comments about your request</span></p></label>
										<div class="col-sm-7">
											<textarea name="details" id="details" class="form-control" required="required"></textarea>
										</div>
									</div>

									<div class="form-group">
										<label for="alternate_phone" class="col-sm-5 control-label">Alternate Phone <br /> <span>Optional alternate phone number</span></label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="alternate_phone" id="alternate_phone" required="required">
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
									<input type="submit" class="btn btn-primary" />
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- modal -->
			</div>
		</section>
		<!--pagination end-->
	</div>
</div>
