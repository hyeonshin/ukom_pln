<?php
require_once '../../../config/library.php';
require_once '../../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_data = $auth->get_data_pln();

if (!$auth->logged_pln()) {
	header("Location: ../../../auth/login");
}

if (isset($_GET['id'])) {
	$id = base64_decode($_GET['id']);

	$select_pelanggan = $lib->select_v_pelanggan($id);
	$select_tagihan = $lib->select_tagihan_pelanggan($id);

	$data_pelanggan = $select_pelanggan->fetch(PDO::FETCH_OBJ);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tune-der</title>
	<link href="../../../css/styles.css" rel="stylesheet" />
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
						<a class="nav-link" href="../../index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
							Dashboard
						</a>
						<div class="sb-sidenav-menu-heading">Menu Management</div>
						<a class="nav-link" href="../../tarif/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-bolt"></i></div>
							Tarif
						</a>
						<a class="nav-link" href="../../kota/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
							Kota
						</a>
						<a class="nav-link" href="../../pelanggan/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
							Pelanggan
						</a>
						<div class="sb-sidenav-menu-heading">Logout Menu</div>
						<a class="nav-link" href="../../logout.php">
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
					<h1 class="mt-4">Menu Pelanggan</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="../index.php">Pelanggan</a></li>
						<li class="breadcrumb-item active">Tagihan</li>
					</ol>
					<div class="row">
						<div class="card mb-4 p-0">
							<div class="card-header">
								<i class="fas fa-table me-1"></i>
								Table Tagihan
							</div>
							<div class="d-flex justify-content-start m-3">
								<a href="../penggunaan-listrik?id=<?= base64_encode($data_pelanggan->id_pelanggan); ?>"
									class="btn btn-success"><i class="fa fa-eye"></i>&ensp;Lihat Penggunaan</a>
							</div>
							<div class="card-body">
								<table id="datatablesSimple">
									<thead>
										<tr>
											<th>Kode Tagihan</th>
											<th>Kode Penggunaan</th>
											<th>Bulan / Tahun</th>
											<th>Stand Meter</th>
											<th>Jumlah Pemakaian</th>
											<th>Biaya Tagihan</th>
											<th>Status</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kode Tagihan</th>
											<th>Kode Penggunaan</th>
											<th>Bulan / Tahun</th>
											<th>Stand Meter</th>
											<th>Jumlah Pemakaian</th>
											<th>Biaya Tagihan</th>
											<th>Status</th>
										</tr>
									</tfoot>
									<tbody>
										<?php while ($data_tagihan = $select_tagihan->fetch(PDO::FETCH_OBJ)) { ?>
											<?php

											$biaya_tagihan = "Rp. " . number_format($data_tagihan->biaya_tagihan, 2, ',', '.');
											?>
											<tr>

												<td>
													<?php echo $data_tagihan->id_tagihan; ?>
												</td>
												<td>
													<?php echo $data_tagihan->id_penggunaan; ?>
												</td>
												<td>
													<?php echo $data_tagihan->bulan; ?> /
													<?php echo $data_tagihan->tahun; ?>
												</td>
												<td>
													<?php echo $data_tagihan->meter_awal . " - " . $data_tagihan->meter_akhir; ?>
													VA
												</td>
												<td>
													<?php echo $data_tagihan->jumlah_meter; ?> KWH
												</td>
												<td>
													<?php echo $biaya_tagihan; ?>
												</td>
												<td>
													<?php if ($data_tagihan->status == "Belum Dibayar"): ?>
														<span class="label-status grey white-text">&emsp;Belum
															Dibayar&emsp;</span>
													<?php else: ?>
														<span class="label-status green white-text">&emsp;Sudah
															Dibayar&emsp;</span>
													<?php endif ?>
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
	<script src="../../../js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
		crossorigin="anonymous"></script>
	<script src="../../../js/datatables-simple-demo.js"></script>
</body>