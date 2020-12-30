<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_data = $auth->get_data_pln();
$view_tarif = $lib->view_tarif();
$view_kota = $lib->view_kota();

if (!$auth->logged_pln()) {
	header("Location: ../../auth/login");
}

if (isset($_GET['id'])) {
	$id = base64_decode($_GET['id']);

	$select = $lib->select_pelanggan($id);
	$data = $select->fetch(PDO::FETCH_OBJ);
}

if (isset($_POST['kirim'])) {
	$id_pelanggan = "";
	$id_tarif = "";
	$id_kota = "";
	$nometer = "";
	$nama_pelanggan = "";
	$alamat = "";
	$edit = $lib->edit_pelanggan($id_pelanggan, $id_tarif, $id_kota, $nometer, $nama_pelanggan, $alamat);
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
                                <li class="active"><a href="../index.php"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                                <li><a href="index.php"><i class="menu-icon fa fa-bolt"></i>Tarif</a>
                                </li>
                                <li><a href="../kota/index.php"><i class="menu-icon fa fa-building"></i>Kota</a>
                                </li>
                                <li><a href="../pelanggan/index.php"><i class="menu-icon icon-group"p></i>Pelanggan</a>
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
										<input type="hidden" name="id_pelanggan" value="<?= $data->id_pelanggan; ?>">
										<div class="control-group">
											<label class="controls" for="basicinput">Nama Pelanggan</label>
											<div class="controls">
												<input type="text" name="nama_pelanggan" id="nama_pelanggan" class="span8" required="" value="<?= $data->nama_pelanggan ?>">
											</div>

										</div>

										<div class="control-group">
											<label class="controls" for="basicinput">Nometer</label>
											<div class="controls ">
												<input type="number" name="nometer" id="nometer" class="span8" required="" value="<?= $data->nometer ?>"">
											</div>
										</div>
										
										<div class="control-group">
											<label class="controls" for="basicinput">Tipe Daya</label>
											<div class="controls">
												<select name="id_tarif" required="">
													<option value="" disabled selected>--- Pilih Data ---</option>
													<?php while ($data_tarif = $view_tarif->fetch(PDO::FETCH_OBJ)) { 
													$selected = $data_tarif->id_tarif == $data->id_tarif ? "selected" : "";
													?>
													<option value="<?= $data_tarif->id_tarif ?>" <?= $selected ?>><?= $data_tarif->id_tarif ?> | <?= $data_tarif->daya ?> VA</option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="controls" for="basicinput">Kota</label>
											<div class="controls">
												<select name="id_kota" required="">
												<option value="" disabled selected>--- Pilih Data ---</option>
												<?php while ($data_kota = $view_kota->fetch(PDO::FETCH_OBJ)) {
													$selected = $data_kota->id_kota == $data->id_kota ? "selected" : "";
												?>
												<option value="<?= $data_kota->id_kota ?>" <?= $selected ?>><?= $data_kota->id_kota ?> - <?= $data_kota->nama_kota ?></option>
												<?php } ?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="controls" for="basicinput">Alamat</label>
											<div class="controls">
												<textarea name="alamat" id="alamat" class="span8" required=""><?= $data->alamat ?></textarea>
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