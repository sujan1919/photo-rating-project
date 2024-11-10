<?php
ob_start();
session_start();
require_once("db/config.php");
require_once("db/function_xss.php");
require_once("db/CSRF_Protect.php");
$csrf = new CSRF_Protect();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="Admin Panel">
	<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL; ?>/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL; ?>/css/custom.css">
	<link rel="icon" href="<?php echo ADMIN_URL; ?>/favicon.png" type="image/png"> 
</head>

<body>
<div id="logreg-forms" class="shadow">
	<div class="modal-header justify-content-center bg-secondary">
		<img src="<?php echo ADMIN_URL; ?>/images/siteLogo.png" class="img-fluid"  alt="Logo">
	</div>
			<?php 
					if(! empty($_SESSION['error_message'])){ ?>
						<div  class="alert alert-danger errorMessage">
						<button type="button" class="close float-right" aria-label="Close" >
						  <span aria-hidden="true" id="hide">&times;</span>
						</button>
				<?php
						echo $_SESSION['error_message'] ;
						unset($_SESSION['error_message']);
				?>
						</div>
			<?php } ?>
        	<form action="<?php echo ADMIN_URL; ?>/login.php" class="form-signin" method="post">
				<?php  $csrf->echoInputField(); ?>
				<h5 class="d-flex justify-content-center text-muted">Admin Login</h5>
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" maxlength="50" required autofocus>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				<div class="text-center"><button class="btn btn-success" type="submit"><i class="fa fa-sign-in"></i> Sign in</button></div>
            </form>
</div>
<script type="text/javascript" src="<?php echo ADMIN_URL; ?>/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL; ?>/js/errorMsg.js"></script>
</body>
</html>
