<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_code = $lib->code_generator_pelanggan();
$get_data = $auth->get_data_pln();
$view_tarif = $lib->view_tarif();
$view_kota = $lib->view_kota();

if (!$auth->logged_pln()) {
	header("Location: ../../auth/login");
}

if (isset($_POST['kirim'])) {
	$id_pelanggan = "";
	$id_tarif = "";
	$id_kota = "";
	$nometer = "";
	$nama_pelanggan = "";
	$alamat = "";
	$simpan = $lib->input_pelanggan($id_pelanggan, $id_tarif, $id_kota, $nometer, $nama_pelanggan, $alamat);
	if ($simpan == "SUCCESS") {
		echo "
		<script>
		alert('Data berhasil di simpan!');
		window.location.href='.';
		</script>
		";
	} else {
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
					<h1 class="mt-4">Add Pelanggan Data Form</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="./index.php">Pelanggan</a></li>
						<li class="breadcrumb-item active">Add Pelanggan Data</li>
					</ol>
					<div class="row">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-7">
									<div class="card shadow-lg border-0 rounded-lg mt-5">
										<div class="card-header">
											<h3 class="text-center font-weight-light my-4">Add Pelanggan Data</h3>
										</div>
										<div class="card-body">
											<form class="form-horizontal row-fluid" action="" method="post">
												<input type="hidden" name="id_pelanggan" value="<?= $get_code; ?>">
												<div class="row mb-3">
													<div class="row g-2">
														<div class="col-md">
															<div class="form-floating">
																<input type="text" name="nama_pelanggan" id="nama_pelanggan"
																	class="form-control" required="">
																<label for="floatingInputGrid">Nama Pelanggan</label>
															</div>
														</div>
														<div class="col-md">
															<div class="form-floating">
																<input type="number" name="nometer"
																	id="nometer" class="form-control" required="">
																<label for="floatingInputGrid">Nomor Meter </label>
															</div>
														</div>
													</div>
												</div>
												<div class="row mb-3">
													<div class="row g-2">
														<div class="col-md">
															<div class="form-floating">
																<select class="form-select" name="id_tarif" required="">
																	<option value="" disabled selected>Select Tipe Daya
																	</option>
																	<?php while ($data = $view_tarif->fetch(PDO::FETCH_OBJ)) { ?>
																		<option value="<?= $data->id_tarif ?>">
																			<?= $data->id_tarif ?> |
																			<?= $data->daya ?> VA
																		</option>
																	<?php } ?>
																</select>
																<label for="floatingSelectGrid">Tipe Daya (VA)</label>
															</div>
														</div>
														<div class="col-md">
															<div class="form-floating">
																<select class="form-select" name="id_kota" required="">
																	<option value="" disabled selected>Select Kota
																	</option>
																	<?php while ($data = $view_kota->fetch(PDO::FETCH_OBJ)) { ?>
																		<option value="<?= $data->id_kota ?>">
																			<?= $data->id_kota ?> -
																			<?= $data->nama_kota ?>
																		</option>
																	<?php } ?>
																</select>
																<label for="floatingInputGrid">Kota</label>
															</div>
														</div>
													</div>
												</div>
												<div class="row mb-3">
													<div class="row g-1">
														<div class="form-floating">
															<textarea class="form-control" name="alamat" id="alamat"
																style="height: 80px" required=""></textarea>
															<label for="floatingTextarea2">Alamat</label>
														</div>
													</div>
												</div>
												<div class="mt-4 mb-0">
													<div class="d-grid"><button type="submit" name="kirim"
															class="btn btn-primary btn-block">
															<i class="fa fa-plus icon-form"></i>&ensp;Add data
														</button>
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