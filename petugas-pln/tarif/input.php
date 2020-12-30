<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_code = $lib->code_generator_tarif();
$get_data = $auth->get_data_pln();

if (!$auth->logged_pln()) {
	header("Location: ../../auth/login");
}

if (isset($_POST['kirim'])) {
	$id_tarif = $get_code;
	$daya = "";
	$tarif_per_kwh = "";
	$ppn = "";
	$denda = "";
	$simpan = $lib->input_tarif($id_tarif, $daya, $tarif_per_kwh, $ppn, $denda);
	if ($simpan == "SUCCESS") {
		echo "
		<script>
		alert('Data berhasil di simpan!');
		window.location.href='.';
		</script>
		";
	} 
	elseif ($simpan == "TIDAK VALID") {
		echo "
		<script>
		alert('Data yang dimasukkan tidak valid!');
		window.location.href='.';
		</script>
		";
	}
	else {
		echo "
		<script>
		alert('Data gagal di simpan!');
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
								<h3>Input Data Tarif</h3>
							</div>
							<div class="module-body">


									<form class="form-horizontal row-fluid" action="" method="post">
										<input type="hidden" name="id_tarif" value="<?= $get_code; ?>">
										<div class="control-group">
											<label class="controls" for="basicinput">Daya</label>
											<div class="controls">
												<input type="number" name="daya" id="daya" class="span8" required="" placeholder="Example : 450">
												<span class="right-text" id="format_volt">VA</span>
											</div>

										</div>

										<div class="control-group">
											<label class="controls" for="basicinput">Tarif per kwh</label>
											<div class="controls ">
												<span class="left-text" id="format_rupiah_tarif">Rp. </span>
												<input type="number" name="tarif_per_kwh" id="tarif_per_kwh" class="span8" required="" placeholder="Example : 2500">
												<span class="right-text" id="format_rupiah_tarif">,00</span>
											</div>
										</div>
										
										<div class="control-group">
											<label class="controls" for="basicinput">PPN</label>
											<div class="controls">
												<input type="number" name="ppn" id="ppn" class="span8" required="" placeholder="Example : 2">
												<span class="right grey-text" id="format_persen">%</span>
											</div>
										</div>

										<div class="control-group">
											<label class="controls" for="basicinput">Denda</label>
											<div class="controls">
												<span class="left-text" id="format_rupiah_denda">Rp. </span>
												<input type="number" name="denda" id="denda" class="span8" required="" placeholder="Example : 2000">
												<span class="right grey-text" id="format_rupiah_denda">,00/Bulan</span>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" name="kirim" class="btn btn-info">
												<i class="fa fa-plus icon-form"></i>&ensp;Add Data
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