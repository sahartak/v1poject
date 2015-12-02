<div class="row">
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				<?php echo getLang('home_trade')?>
							<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body ">
				<table class="table table-hover">
					<tbody>
						<tr>
							<td colspan="2"><?php echo getLang('home_trade_purchase')?></td>
							<td colspan="2">$<?php echo number_format($total_purchase, 2);?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo getLang('home_trade_sale')?></td>
							<td colspan="2">$<?php echo number_format($total_sales, 2);?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo getLang('home_trade_fees')?></td>
							<td colspan="2">$<?php echo number_format($total_fees, 2);?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo getLang('home_trade_total')?></td>
							<td colspan="2"><?php echo $total_trading?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				<?php echo getLang('home_fund')?>
				<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body ">
				<table class="table table-hover">
					<tbody>
					<tr>
						<td colspan="2"><?php echo getLang('home_fund_deposit')?></td>
						<td colspan="2">$<?php echo $total_deposit;?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_fund_withdraw')?></td>
						<td colspan="2">$<?php echo $total_withdraw;?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_fund_fees')?></td>
						<td colspan="2">$<?php echo $total_fees2;?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_fund_total')?></td>
						<td colspan="2"><?php echo $total_funding;?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<section class="panel ">
			<header class="panel-heading">
				<?php echo getLang('home_total')?>
				<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body alert-success">
				<table class="table table-hover">
					<tbody>
					<tr>
						<td colspan="2"><?php echo getLang('home_total_trade')?></td>
						<td colspan="2"><?php echo $total_trading2;?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_total_fund')?></td>
						<td colspan="2"><?php echo $total_funding2;?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_total_fees')?></td>
						<td colspan="2"><?php echo $total_total_fees;?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_total_balance')?></td>
						<td colspan="2"><?php echo $account_balance?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				<?php echo getLang('home_acc')?>
				<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body">
				<table class="table table-hover">
					<tbody>
					<tr>
						<td colspan="2"><?php echo getLang('home_acc_ref')?></td>
						<td colspan="2"><?php echo $row['user_ref'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_acc_num')?></td>
						<td colspan="2"><?php echo $row['user_account_num'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_acc_name')?></td>
						<td colspan="2"><?php echo $row['user_account_name'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_acc_date')?></td>
						<td colspan="2"><?php echo date('d M Y',strtotime($row['user_app_date']))?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				<?php echo getLang('home_contact')?>
				<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body">
				<table class="table table-hover ">
					<tbody>
					<tr>
						<td colspan="2"><?php echo getLang('home_contact_name')?></td>
						<td colspan="2"><?php echo $userTitles[$row['user_title']],' ',$row['user_firstname'],' ',$row['user_lastname'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_contact_firm')?></td>
						<td colspan="2"><?php echo $row['user_company'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_contact_email')?></td>
						<td colspan="2"><?php echo $row['user_email'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_contact_phone')?></td>
						<td colspan="2"><?php echo $row['user_phone']?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_contact_maddress')?></td>
						<td colspan="2">
							<?php echo $row['user_mailing_address'];
							if($row['user_city']!='') echo ', '.$row['user_city'];
							if($row['user_state']!='') echo ', '.$row['user_state'];
							if($row['user_postal']!='') echo ', '.$row['user_postal'];
							if($row['user_country']!='') echo ', '.$row['user_country'];?>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
<?php if($row2):?>
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				<?php echo getLang('home_advisor')?>
				<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body">
				<table class="table table-hover">
					<tbody>
					<tr>
						<td colspan="2"><?php echo getLang('home_advisor_rep')?></td>
						<td colspan="2"><?php echo $row2['advisor_names'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_advisor_firm')?></td>
						<td colspan="2"><?php echo $row2['advisor_firm'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_advisor_contact')?></td>
						<td colspan="2"><?php echo $row2['advisor_contacts'];?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
<?php endif;

if($row3) :
	if($row2)
		echo '<div class="row">';?>

	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				<?php echo getLang('home_advisor2')?>
				<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
								<a href="javascript:;" class="fa fa-cog"></a>
								<a href="javascript:;" class="fa fa-times"></a>
							 </span>
			</header>
			<div class="panel-body">
				<table class="table table-hover">
					<tbody>
					<tr>
						<td colspan="2"><?php echo getLang('home_advisor_rep')?></td>
						<td colspan="2"><?php echo $row3['advisor_names'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_advisor_firm')?></td>
						<td colspan="2"><?php echo $row3['advisor_firm'];?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo getLang('home_advisor_contact')?></td>
						<td colspan="2"><?php echo $row3['advisor_contacts'];?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>


<?php if($row2)
	echo '</div>';
endif;?>



</div>