<?php
require_once('common.php');
if(isset($_SESSION['user']) && $_SESSION['user']['is_logged']==1) {
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="images/favicon.png">

	<title>Login</title>

	<!--Core CSS -->
	<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-reset.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

	<!-- Custom styles for this template -->
	<link href="css/style.css" rel="stylesheet">
	<link href="css/style-responsive.css" rel="stylesheet" />

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]>
	<script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>

<body class="login-body">

<div class="container">




	<form class="cmxform form-signin" id="loginForm" method="post">
		<h2 class="form-signin-heading">sign in now</h2>
		<div class="login-wrap">
			<div class="user-login-info">
				<?php if(isset($_GET['error']) and $_GET['error']==1){?>

					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo getLang('lform_invalid') ?>
					</div>
				<?php }?>
				<div class="form-group">
					<input type="text" class="form-control" name="l_username" placeholder="<?php echo getLang('lform_username')?>" autofocus required>
				</div>
				<div class="form-group">
					<input type="password" name="l_password" class="form-control" placeholder="<?php echo getLang('lform_password')?>" required>
				</div>
			</div>
			<label class="checkbox">
				<!--<input type="checkbox" value="remember-me"> Remember me--> &nbsp;
				<span class="pull-right">
					<a data-toggle="modal" href="#myModal"> Forgot Password?</a>

				</span>
			</label>
			<button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

			<!--<div class="registration">
				Don't have an account yet?
				<a class="" href="registration.html">
					Create an account
				</a>
			</div>-->

		</div>
	</form>
		<!-- Modal -->
		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form class="cmxform" id="resetPassword">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><?php echo getLang('rform_title')?></h4>
						</div>
						<div class="modal-body">
							<div class="form-group email_group">
								<label><?php echo getLang('rform_email')?></label>
								<input type="email" required="" name="rform_email" id="rform_email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
							</div>
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
							<button class="btn btn-success" type="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- modal -->

	</form>

</div>



<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src="js/jquery.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<!--common script init for all pages-->
<script src="js/scripts.js"></script>
<!--this page script-->
<script src="js/validation-init.js"></script>
</body>
</html>