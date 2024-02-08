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
	$edit = $lib->edit_user($id_user, $nama_user, $level, $status);
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
						<a class="nav-link" href="./index.php">
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
					<h1 class="mt-4">Edit User Data Form</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="./index.php">User Data</a></li>
						<li class="breadcrumb-item active">Edit User Data</li>
					</ol>
					<div class="row">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-7">
									<div class="card shadow-lg border-0 rounded-lg mt-5">
										<div class="card-header">
											<h3 class="text-center font-weight-light my-4">Edit User Data</h3>
										</div>
										<div class="card-body">
											<form class="form-horizontal row-fluid" action="" method="post">
												<input type="hidden" name="id_user" value="<?= $data->id_user; ?>">
												<div class="row mb-3">
													<div class="row g-2">
														<div class="col-md">
															<div class="form-floating">
																<input type="text" name="nama_user" id="nama_user"
																	class="form-control" value="<?= $data->nama_user ?>"
																	required="">
																<label for="floatingInputGrid">Nama User</label>
															</div>
														</div>
														<div class="col-md">
															<div class="form-floating">
																<select class="form-select" tabindex="1"
																	data-placeholder="Select here.." name="level"
																	required="">
																	<option value="Petugas PLN" <?php if ($data->level == "Petugas PLN") {
																		echo "selected";
																	} ?>>Petugas PLN</option>
																	<option value="Petugas Pembayaran" <?php if ($data->level == "Petugas Pembayaran") {
																		echo "selected";
																	} ?>>Petugas Pembayaran</option>
																</select>
																<label for="floatingSelectGrid">Level User</label>
															</div>
														</div>
													</div>
												</div>
												<div class="form-floating m-2">
													<div class="form-check form-check-inline">
														<input type="radio" class="form-check-input" name="status"
															id="status" value="AKTIF" <?php if ($data->status == "AKTIF") {
																echo "checked";
															} ?>>
														<label class="form-check-label" for="status1">Aktif</label>
													</div>
													<div class="form-check form-check-inline">
														<input type="radio" class="form-check-input" name="status"
															id="status" value="TIDAK AKTIF" <?php if ($data->status == "TIDAK AKTIF") {
																echo "checked";
															} ?>>
														<label class="form-check-label" for="status2">Tidak
															Aktif</label>
													</div>
												</div>
												<div class="mt-4 mb-0">
													<div class="d-grid"><button type="submit" name="kirim"
															class="btn btn-primary btn-block">
															<i class="fa fa-pencil icon-form"></i>&ensp;Edit
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