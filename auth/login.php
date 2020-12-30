<?php
require_once '../config/authentication.php';

$auth = new Authentication();

if ($auth->logged_admin()) {
	header("Location: ../admin-sistem/dashboard.php");
}

if ($auth->logged_pln()) {
	header("Location: ../petugas-pln/dashboard.php");
}

if ($auth->logged_pembayaran()) {
	header("Location: ../petugas-pembayaran/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tune-der</title>
	<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../css/theme.css" rel="stylesheet">
	<link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body style="background:url('../resource/foto/bg_bg.jpg') no-repeat; background-size: cover;">

	



		<div class="container">
			<div class="row">
				<center>
		    		
				<div class="span4 offset4">
					<img src="../resource/foto/logo_tuneder.png" height="60" style="margin-top: 7%">
		    		
		  		</center>
				<div class="module module-login span4 offset4">
					<form class="form-vertical" action="login-process.php" method="post">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label class="text">Username</label>
									<input class="form-control" type="text" id="inputEmail" placeholder="Username" name="username" required="">
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label class="text">Password</label>
									<input class="span12" type="password" id="inputPassword" placeholder="Password" name="password" required="">
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	
	<script src="../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>