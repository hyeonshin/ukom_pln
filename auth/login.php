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
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
		rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
	<section class="vh-100" style="background-color: #059FDC;">
		<div class="container">
			<div class="row">
				<div class="col-3">
				</div>
				<div class="col-md-6">
					<div class="d-flex justify-content-center">
						<img src="../resource/foto/logo_tuneder.png" style="margin-top: 7%">
					</div>
					<div class="module module-login">
						<form class="form-vertical" action="login-process.php" method="post">
							<div class="module-body">
								<div class="form-floating mb-3">
									<input type="text" class="form-control" id="inputEmail" placeholder="Username"
										name="username" required="">
									<label for="floatingInput">Username</label>
								</div>
								<div class="form-floating">
									<input type="password" class="form-control" id="inputPassword"
										placeholder="Password" name="password" required="">
									<label for="floatingPassword">Password</label>
								</div>
							</div>
							<div class="module-foot">
								<div class="control-group">
									<div class="controls clearfix">
										<button type="submit" class="btn btn-primary btn-block"
											name="login">Login</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-3">
				</div>

			</div>
		</div>
	</section>


	<script src="../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
		integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
		integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
		crossorigin="anonymous"></script>
</body>