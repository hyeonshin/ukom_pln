<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_data = $auth->get_data_admin();

if (!$auth->logged_admin()) {
	header("Location: ../../auth/login");
}

if (isset($_GET['id'])) {
	$id = base64_decode($_GET['id']);

	$select = $lib->select_user($id);
	$data = $select->fetch(PDO::FETCH_OBJ);
}

if (isset($_POST['kirim'])) {
	$id_user = "";
	$nama_user = "";
	$level = "";
	$status = $_POST['status'];
	$edit = $lib->edit_user($id_user, $nama_user, $level,$status);
	if ($edit == "SUCCESS") {
		echo "
		<script>
		alert('Data berhasil di edit!');
		window.location.href='.';
		</script>
		";
	} else {
		echo "
		<script>
		alert('Data gagal di edit!');
		</script>
		";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tune-der</title>
	<link type="text/css" href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../../css/theme.css" rel="stylesheet">
	<link type="text/css" href="../../images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../../font-awesome/css/font-awesome.min.css">

</head>
<body>

	<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="../../index.php"><center><img src="../../resource/foto/logo_tuneder.png" class="navbar-brand" width="44%"> </center></a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div><!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="span3">
					<div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="../../index.php"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                                <li><a href="index.php"><i class="menu-icon icon-paste"></i>User Data</a>
                                </li>
                            </ul>
                            <!--/.widget-nav-->
                            
                            
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li><a href="../logout.php"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>
                        </div><!--/.sidebar-->
				</div><!--/.span3-->


				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Forms</h3>
							</div>
							<div class="module-body">


									<form class="form-horizontal row-fluid" action="" method="post">
										<input type="hidden" name="id_user" value="<?= $data->id_user; ?>">

										<div class="control-group">
											<label class="control-label" for="basicinput">Nama User</label>
											<div class="controls">
												<input type="text" name="nama_user" id="nama_user" class="span8" value="<?= $data->nama_user ?>" required="">
											</div>
										</div>

										

										<div class="control-group">
											<label class="control-label" for="basicinput">Level</label>
											<div class="controls">
												<select tabindex="1" data-placeholder="Select here.." class="span8" name="level" required="">
													<option value="Petugas PLN" <?php if($data->level == "Petugas PLN"){echo "selected";} ?>>Petugas PLN</option>
													<option value="Petugas Pembayaran" <?php if($data->level == "Petugas Pembayaran"){echo "selected";} ?>>Petugas Pembayaran</option>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">Status</label>
											<div class="controls">
												<label class="radio inline">
													<input type="radio" name="status" id="status" value="AKTIF" <?php if($data->status == "AKTIF"){echo "checked";} ?>>
													Aktif
												</label> 
												<label class="radio inline">
													<input type="radio" name="status" id="status" value="TIDAK AKTIF" <?php if($data->status == "TIDAK AKTIF"){echo "checked";} ?>>
													Tidak Aktif
												</label> 
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" name="kirim" class="btn btn-info">
												<i class="fa fa-pencil icon-form"></i>&ensp;Edit
												</button>
											</div>
										</div>
									</form>
							</div>
						</div>

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			 

			<b class="copyright">Copyright &copy; 2018 Tune-der. </b> All rights reserved.
		</div>
	</div>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
</body>