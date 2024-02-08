<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$view = $lib->view_pelanggan();
$get_data = $auth->get_data_admin();

if (!$auth->logged_admin()) {
	header("Location: ../../auth/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tune-der</title>
	<link href="../../css/styles.css" rel="stylesheet" />
	<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
		<!-- Navbar Brand-->
		<a class="navbar-brand ps-3" href="#">Tune-der</a>
		<!-- Sidebar Toggle-->
		<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
				class="fas fa-bars"></i>
		</button>
	</nav>
	<div id="layoutSidenav">
		<div id="layoutSidenav_nav">
			<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
				<div class="sb-sidenav-menu">
					<div class="nav">
						<div class="sb-sidenav-menu-heading">Core</div>
						<a class="nav-link" href="../index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
							Dashboard
						</a>
						<div class="sb-sidenav-menu-heading">User Management</div>
						<a class="nav-link" href="../user/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
							User Data
						</a>
						<div class="sb-sidenav-menu-heading">Datas Management</div>
						<a class="nav-link" href="../pln/tarif.php">
							<div class="sb-nav-link-icon"><i class="fas fa-bolt"></i></div>
							Data Tarif
						</a>
						<a class="nav-link" href="../pln/kota.php">
							<div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
							Data Kota
						</a>
						<a class="nav-link" href="../pln/pelanggan.php">
							<div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
							Data Pelanggan
						</a>
						<div class="sb-sidenav-menu-heading">Logout Menu</div>
						<a class="nav-link" href="../logout.php">
							<div class="sb-nav-link-icon"><i class="fas fa-sign-out"></i></div>
							Logout
						</a>
					</div>
				</div>
				<div class="sb-sidenav-footer">
					<div class="small">Logged in as:</div>
					<?= $get_data['nama_user']; ?>
					(
					<?= $get_data['level']; ?>)
				</div>
			</nav>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid px-4">
					<h1 class="mt-4">Data Pelanggan</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Data Tarif</li>
					</ol>
					<div class="row">
						<div class="card mb-4 p-0">
							<div class="card-header">
								<i class="fas fa-table me-1"></i>
								Table Data Pelanggan
							</div>
							<div class="card-body">
								<table id="datatablesSimple">
									<thead>
										<tr>
											<th>Kode</th>
											<th>Nama</th>
											<th>Nometer</th>
											<th>Kota</th>
											<th>Daya</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kode</th>
											<th>Nama</th>
											<th>Nometer</th>
											<th>Kota</th>
											<th>Daya</th>
										</tr>
									</tfoot>
									<tbody>
										<?php while ($data = $view->fetch(PDO::FETCH_OBJ)) { ?>
											<?php
											$daya = number_format($data->daya, 0, ',', '.');
											?>
											<tr>
												<td>
													<?php echo $data->id_pelanggan; ?>
												</td>
												<td>
													<?php echo $data->nama_pelanggan; ?>
												</td>
												<td>
													<?php echo $data->nometer; ?>
												</td>
												<td>
													<?php echo $data->nama_kota; ?>
												</td>
												<td>
													<?php echo $daya; ?> VA
												</td>

											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</main>
			<footer class="py-4 bg-light mt-auto">
				<div class="container-fluid px-4">
					<div class="d-flex align-items-center justify-content-between small">
						<div class="text-muted">Copyright &copy; Tune-der 2018 - 2024</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
		crossorigin="anonymous"></script>
	<script src="../../js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
		crossorigin="anonymous"></script>
	<script src="../../js/datatables-simple-demo.js"></script>
</body>
<!-- old -->

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i></a><a class="brand" href="../../index.php">
					<center><img src="../../resource/foto/logo_tuneder.png" class="navbar-brand" width="44%"> </center>
				</a>
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
							<li><a href="../user/index.php"><i class="menu-icon icon-paste"></i>User Data</a>
							</li>
							<li><a href="tarif.php"><i class="menu-icon fa fa-bolt"></i>Tarif</a>
							</li>
							<li><a href="kota.php"><i class="menu-icon fa fa-building"></i>Kota</a>
							</li>
							<li><a href="pelanggan.php"><i class="menu-icon icon-group" p></i>Pelanggan</a>
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
							<div class="module-head clearfix">
								<div class="pull-left">
									<h3>Table Data Pelanggan</h3>
								</div>

							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0"
									class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>Kode</th>
											<th>Nama</th>
											<th>Nometer</th>
											<th>Kota</th>
											<th>Daya</th>
										</tr>
									</thead>
									<tbody>

										<?php while ($data = $view->fetch(PDO::FETCH_OBJ)) { ?>
											<?php
											$daya = number_format($data->daya, 0, ',', '.');
											?>
											<tr>
												<td>
													<?php echo $data->id_pelanggan; ?>
												</td>
												<td>
													<?php echo $data->nama_pelanggan; ?>
												</td>
												<td>
													<?php echo $data->nometer; ?>
												</td>
												<td>
													<?php echo $data->nama_kota; ?>
												</td>
												<td>
													<?php echo $daya; ?> VA
												</td>

											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div><!--/.module-->

						<br />

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

	<script src="../../scripts/jquery-1.9.1.min.js"></script>
	<script src="../../scripts/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function () {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		});
	</script>
</body>