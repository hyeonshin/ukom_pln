<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

if (!$auth->logged_pembayaran()) {
	header("Location: ../../auth/login");
}

if (isset($_GET['id'])) {
	$id = base64_decode($_GET['id']);

	$select = $lib->select_biaya_admin($id);
	$data = $select->fetch(PDO::FETCH_OBJ);
}

$jumlah_pembayaran = $lib->jumlah_pembayaran();
$get_data = $auth->get_data_pembayaran();

if (isset($_POST['kirim'])) {
	$id_biaya_admin = "";
	$biaya_admin = "";
	$edit = $lib->edit_biaya_admin($id_biaya_admin, $biaya_admin);
	if ($edit == "SUCCESS") {
		echo "
		<script>
		alert('Data berhasil di edit!');
		window.location.href='.?id=" . base64_encode(1) . "';
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
					<h1 class="mt-4">Pengaturan Biaya Form</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Pengaturan Biaya</li>
					</ol>
					<div class="row">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-7">
									<div class="card shadow-lg border-0 rounded-lg mt-5">
										<div class="card-header">
											<h3 class="text-center font-weight-light my-4">Pengaturan Biaya</h3>
										</div>
										<div class="card-body">
											<form class="form-horizontal row-fluid" action="" method="post">
												<div class="row mb-3">
													<div class="row g-1">
														<div class="col-md">
															<div class="form-floating">
																<input class="form-control" type="number" name="biaya_admin" id="biaya_admin"
																	required=""
																	onkeyup="document.getElementById('format_rupiah').innerHTML = format_rupiah(this.value);"
																	value="<?= $data->biaya_admin ?>">
																<label for="floatingInputGrid">Pengaturan Biaya (Rp)</label>
															</div>
														</div>
													</div>
												</div>
												<div class="mt-4 mb-0">
													<div class="d-grid"><button type="submit" name="kirim"
															class="btn btn-primary btn-block">
															<i class="fa fa-pencil icon-form"></i>&ensp;Edit biaya
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