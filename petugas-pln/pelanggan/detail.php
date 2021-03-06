<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_data = $auth->get_data_pln();

if (!$auth->logged_pln()) {
	header("Location: ../../auth/login");
}

if (isset($_GET['id'])) {
	$id = base64_decode($_GET['id']);

	$select = $lib->select_v_pelanggan($id);
	$data = $select->fetch(PDO::FETCH_OBJ);
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
								<h3>Detail Data Pelanggan</h3>
							</div>
							<div class="module-body">
									
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<table>
							<thead>
								
							</thead>
							<tbody>
								<?php
								$daya = number_format($data->daya,0,',','.');
								?>
								<tr>
									<td width="20%">ID Pelanggan</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->id_pelanggan ?></td>
								</tr>
								<tr>
									<td width="20%">Nama Pelanggan</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->nama_pelanggan ?></td>
								</tr>
								<tr>
									<td width="20%">Nometer</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->nometer ?></td>
								</tr>
								<tr>
									<td width="20%">ID Kota</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->id_kota ?></td>
								</tr>
								<tr>
									<td width="20%">Tempat Kota</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->nama_kota ?></td>
								</tr>
								<tr>
									<td width="20%">Alamat</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->alamat ?></td>
								</tr>
								<tr>
									<td width="20%">ID Tarif</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->id_tarif ?></td>
								</tr>
								<tr>
									<td width="20%">Tarif per KWH</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->tarif_per_kwh ?></td>
								</tr>
								<tr>
									<td width="20%">Tipe Daya</td>
									<td width="1%">:</td>
									<td width="79%"><?= $daya ?> VA</td>
								</tr>
								<tr>
									<td width="20%">PPN</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->ppn ?></td>
								</tr><tr>
									<td width="20%">PPJU</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->ppju ?></td>
								</tr><tr>
									<td width="20%">Alamat</td>
									<td width="1%">:</td>
									<td width="79%"><?= $data->denda ?></td>
								</tr>
							</tbody>
						</table>
						<br>
						<div class="card-action">
							<div class="content-center">
								<div class="col 6">
									<a href="." class="btn btn-info">
										<i class="fa fa-arrow-left icon-form"></i>&ensp;Kembali
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
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