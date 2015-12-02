<h2>Trading Overview</h2>

<table width="100%" cellspacing="0" cellpadding="0" border="1">
    <tr>
        <td><b>Date</b></td>
        <td><b>REF #</b></td>
        <td><b>Details</b></td>
        <td><b>Opt</b></td>
        <td><b>Expiry</b></td>
        <td><b>Premium</b></td>
        <td><b>Strike Price</b></td>
        <td><b>Fees</b></td>
        <td><b>Price</b></td>
        <td><b>Status</b></td>
    </tr>
    
    <?php foreach($trades as $trade): ?>
        <tr>
            <td><?php echo date('d M Y', strtotime($trade['trade_date'])); ?></td>
            <td><?php echo $trade['trade_ref']; ?></td>
            <td><?php echo $trade['trade_details']; ?></td>
            <td><?php echo $tradesBuyOptions[$trade['trade_option']]; ?></td>
            <td><?php echo date('d M Y', strtotime($trade['trade_expiry_date'])); ?></td>
            <td>$<?php echo number_format($trade['trade_premium_price'], 4); ?></td>
            <td>$<?php echo number_format($trade['trade_strikeprice'], 2); ?></td>
            <td>$<?php echo number_format($trade['trade_fees'], 2); ?></td>
            <td>$<?php echo number_format($trade['trade_value'], 2); ?></td>
            <td><?php echo $trade['trade_type'] == 1 ? $buyStatuses[$trade['trade_status']] : $sellStatuses[$trade['trade_status']]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Funding Overview</h2>

<table width="100%" cellspacing="0" cellpadding="0" border="1">
    <tr>
        <td><b>Date</b></td>
        <td><b>REF #</b></td>
        <td><b>Type</b></td>
        <td><b>Value Date</b></td>
        <td><b>Amount</b></td>
        <td><b>Fees</b></td>
        <td><b>Withdraw</b></td>
        <td><b>Status</b></td>
        <td><b>Notes</b></td>
    </tr>
    
    <?php foreach($transfers as $transfer): ?>
        <tr>
            <td><?php echo date('d M Y', strtotime($transfer['tr_date'])); ?></td>
            <td><?php echo $transfer['tr_ref']; ?></td>
            <td><?php echo $transfersOptions[$transfer['tr_type']]; ?></td>
            <td><?php echo date('d M Y', strtotime($transfer['tr_date'])); ?></td>
            <td>$<?php echo number_format($transfer['tr_value'], 2); ?></td>
            <td>$<?php echo number_format($transfer['tr_fees'], 2); ?></td>
            <td>$<?php echo number_format($transfer['tr_total'], 2); ?></td>
            <td><?php echo $depositOptions[$transfer['tr_status']]; ?></td>
            <td><?php echo $transfer['tr_notes']; ?>&nbsp;</td>
        </tr>
    <?php endforeach; ?>
</table>