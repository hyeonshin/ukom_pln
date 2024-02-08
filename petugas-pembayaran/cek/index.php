<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$view = $lib->view_pelanggan();
$get_data = $auth->get_data_pembayaran();

if (!$auth->logged_pembayaran()) {
	header("Location: ../../auth/login");
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
						<div class="sb-sidenav-menu-heading">Menu Management</div>
						<a class="nav-link" href="../pengaturan-biaya?id=<?= base64_encode(1); ?>">
							<div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
							Pengaturan Biaya
						</a>
						<a class="nav-link" href="../cek">
							<div class="sb-nav-link-icon"><i class="fas fa-dollar"></i></div>
							Pembayaran
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
					<h1 class="mt-4">Menu Pembayaran</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Pembayaran</li>
					</ol>
					<div class="row">
						<div class="card mb-4 p-0">
							<div class="card-header">
								<i class="fas fa-table me-1"></i>
								Table Pembayaran
							</div>
							<div class="card-body">
								<table id="datatablesSimple">
									<thead>
										<tr>
											<th>Kode</th>
											<th>Nama</th>
											<th>Nometer</th>
											<th>Tempat Kota</th>
											<th>Tipe Daya</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kode</th>
											<th>Nama</th>
											<th>Nometer</th>
											<th>Tempat Kota</th>
											<th>Tipe Daya</th>
											<th>Aksi</th>
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
												<td>
													<a href="tagihan-listrik?id=<?= base64_encode($data->id_pelanggan); ?>"
														class="btn btn-primary" data-position="top" data-delay="50"
														data-tooltip="Lihat Tagihan">
														<i class="fa fa-credit-card white-text"></i>
													</a>
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
</html>