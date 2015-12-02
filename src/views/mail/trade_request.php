<p>Trade request has been sent.</p>

<p><strong>Summary:</strong></p>

<p>
    <strong>Name:</strong> <?php echo $user['user_account_name']; ?><br />
    <strong>E-mail:</strong> <a href="mailto:<?php echo $user['user_email']; ?>"><?php echo $user['user_email']; ?></a><br />
    <strong>Phone:</strong> <?php echo $user['user_phone']; ?><br />
    <strong>Alternate phone:</strong> <?php echo htmlspecialchars($form['alternate_phone']); ?>
</p>

<p><strong>Details:</strong></p>

<p><?php echo htmlspecialchars($form['details']); ?></p>