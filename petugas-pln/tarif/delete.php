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

	$select = $lib->select_tarif($id);
	$data = $select->fetch(PDO::FETCH_OBJ);
}

if (isset($_GET['confirm'])) {
	$confirm = base64_decode($_GET['confirm']);

	$delete = $lib->delete_tarif($confirm);
	if ($delete == "SUCCESS") {
		echo "
		<script>
		alert('Data berhasil di hapus!');
		window.location.href='.';
		</script>
		";
	} else {
		echo "
		<script>
		alert('Data gagal di hapus karena sedang dipakai!');
		window.location.href='.';
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
						<a class="nav-link" href="../tarif/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-bolt"></i></div>
							Tarif
						</a>
						<a class="nav-link" href="../kota/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
							Kota
						</a>
						<a class="nav-link" href="../pelanggan/index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
							Pelanggan
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
					<h1 class="mt-4">Delete Tarif Data Form</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="./index.php">Tarif</a></li>
						<li class="breadcrumb-item active">Delete Tarif Data</li>
					</ol>
					<div class="row">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-7">
									<div class="card shadow-lg border-0 rounded-lg mt-5">
										<div class="card-header">
											<h3 class="text-center font-weight-light my-4">Delete Tarif Data</h3>
										</div>
										<div class="card-body">
											<form class="form-horizontal row-fluid" action="" method="post">
												<table class="m-2 p-2">
													<thead>
														<div class="text-bg-warning p-3">
															<strong>Perhatian!</strong> Apakah anda yakin ingin
															menghapus data ini?
														</div>
													</thead>
													<tbody>
														<?php
														$daya = number_format($data->daya, 0, ',', '.');
														$tarif_per_kwh = "Rp. " . number_format($data->tarif_per_kwh, 2, ',', '.');
														$denda = "Rp. " . number_format($data->denda, 2, ',', '.');
														?>
														<tr>
															<td width="20%">Kode</td>
															<td width="1%">:</td>
															<td width="79%">
																<?= $data->id_tarif ?>
															</td>
														</tr>
														<tr>
															<td width="20%">Daya</td>
															<td width="1%">:</td>
															<td width="79%">
																<?= $daya ?> VA
															</td>
														</tr>
														<tr>
															<td width="20%">Tarif Per KWH</td>
															<td width="1%">:</td>
															<td width="79%">
																<?= $tarif_per_kwh ?>/KWH
															</td>
														</tr>
														<tr>
															<td width="20%">PPN</td>
															<td width="1%">:</td>
															<td width="79%">
																<?= $data->ppn ?>%
															</td>
														</tr>
														<tr>
															<td width="20%">Denda</td>
															<td width="1%">:</td>
															<td width="79%">
																<?= $denda ?>/Bulan
															</td>
														</tr>
													</tbody>
												</table>
												<div class="card-action">
												<div class="content-center">
													<div class="col 6">
														<a href="delete.php?confirm=<?= base64_encode($data->id_tarif) ?>"
															class="btn btn-danger">
															<i class="fa fa-trash icon-form"></i>&ensp;Hapus
														</a>
														<a href="." class="btn btn-info">
															<i class="fa fa-close icon-form"></i>&ensp;Batal
														</a>
													</div>
												</div>
											</div>
											</form>
										</div>
									</div>
								</div>
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