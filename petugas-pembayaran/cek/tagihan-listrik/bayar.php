<?php
require_once '../../../config/library.php';
require_once '../../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$get_code = $lib->code_generator_pembayaran();
$get_data = $auth->get_data_pembayaran();

if (!$auth->logged_pembayaran()) {
	header("Location: ../../../auth/login");
}

if (isset($_GET['id'])) {
	$id = base64_decode($_GET['id']);

	$select_biaya_admin = $lib->view_biaya_admin();
	$select_tagihan = $lib->select_tagihan_pembayaran($id);

	$data_biaya_admin = $select_biaya_admin->fetch(PDO::FETCH_OBJ);
	$data_tagihan = $select_tagihan->fetch(PDO::FETCH_OBJ);
}

if (isset($_POST['kirim'])) {
	$id_pembayaran = "";
	$id_pelanggan = "";
	$id_tagihan = "";
	$id_biaya_admin = "";
	$id_user = "";
	$tgl_pembayaran = "";
	$biaya_denda = "";
	$biaya_admin = "";
	$jumlah_biaya = "";
	$simpan = $lib->input_pembayaran($id_pembayaran, $id_pelanggan, $id_tagihan, $id_biaya_admin, $id_user, $tgl_pembayaran, $biaya_denda, $biaya_admin, $jumlah_biaya);
	if ($simpan == "SUCCESS") {
		echo "
		<script>
		alert('Pembayaran telah berhasil!');
		window.location.href='.?id=" . base64_encode($data_tagihan->id_pelanggan) . "';
		</script>
		";
	} else {
		echo "
		<script>
		alert('Pembayaran telah gagal, silahkan cek data Anda kembali!');
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
	<link href="../../../css/styles.css" rel="stylesheet" />
	<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
	<link type="text/css" href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../../../css/theme.css" rel="stylesheet">
	<link type="text/css" href="../../../images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
		rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../../../font-awesome/css/font-awesome.min.css">

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
						<a class="nav-link" href="../../pengaturan-biaya?id=<?= base64_encode(1); ?>">
							<div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
							Pengaturan Biaya
						</a>
						<a class="nav-link" href="../../cek">
							<div class="sb-nav-link-icon"><i class="fas fa-dollar"></i></div>
							Pembayaran
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
					<h1 class="mt-4">Menu Pembayaran</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="../index.php">Pembayaran</a></li>
						<li class="breadcrumb-item active">Konfirmasi</li>
					</ol>
					<div class="row">
						<div class="card">
							<div class="card-content">
								<table>
									<thead>
										<form action="" method="POST">
											<?php $date_input_now = date("Y-m-d"); ?>
											<?php $date_now = date(" Y F, d"); ?>
											<input type="hidden" name="id_pembayaran" value="<?= $get_code; ?>">
											<input type="hidden" name="id_pelanggan"
												value="<?= $data_tagihan->id_pelanggan; ?>">
											<input type="hidden" name="id_tagihan"
												value="<?= $data_tagihan->id_tagihan; ?>">
											<input type="hidden" name="id_biaya_admin"
												value="<?= $data_biaya_admin->id_biaya_admin; ?>">
											<input type="hidden" name="id_user" value="<?= $get_data['id_user']; ?>">
											<input type="hidden" name="tgl_pembayaran" value="<?= $date_input_now; ?>">
											<div class="pull-right">
												<p class="card-title-welcome text-center">
													Tanggal Pembayaran :
													<?= $date_now; ?>
												</p>
											</div>
											<div class="left">
												<p class="brand-login">
													<img src="../../../resource/foto/logo_tuneder.png" alt="Tune-der"
														class="img-brand-login">
												</p>
											</div>
											<div class="clearfix"></div>
											<hr>
											<table>
												<div class="col-sm-2">
													<tr>
														<td width="20%">
															<p style="font-size: 18px;"><b><u>Alamat Pelanggan</u></b>
															</p>
														</td>
														<td width="80%">
															<div class="pull-right">
																<p style="font-size: 18px;"><b>No. Pembayaran : #
																		<?= $get_code; ?>
																	</b></p>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<p>
																<?= $data_tagihan->alamat ?>,
																<br>
																<?= $data_tagihan->nama_kota ?>
															</p>
														</td>
														<td>
															<div class="pull-right">

																<table class="pull-right">
																	<tbody>
																		<tr>
																			<td>Nometer</td>
																			<td>:</td>
																			<td>
																				<?= $data_tagihan->nometer ?>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="3">
																				<hr>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<br>

																<br>
															</div>
														</td>
													</tr>
												</div>
											</table>

											<br><br>
											<table border="0"
												class="datatable-1 table table-bordered table-striped	 display"
												width="1024px">
												<tbody>
													<tr>
														<td>Nama</td>
														<td>
															:&emsp;
															<?= $data_tagihan->nama_pelanggan ?>
														</td>
														<td>Stand Meter</td>
														<td>
															:&emsp;
															<?php
															$meter_awal = number_format($data_tagihan->meter_awal, 0, '', '.');
															$meter_akhir = number_format($data_tagihan->meter_akhir, 0, '', '.');
															?>
															<?= $meter_awal ?> -
															<?= $meter_akhir ?> VA
														</td>
													</tr>
													<tr>
														<td>Jenis Daya</td>
														<td>
															:&emsp;
															<?php
															$daya = number_format($data_tagihan->daya, 0, '', '.');
															?>
															<?= $daya ?> VA
														</td>
														<td>PPN</td>
														<td>
															:&emsp;
															<?= $data_tagihan->ppn ?>%
														</td>
													</tr>
													<tr>
														<td>Bulan / Tahun</td>
														<td>
															:&emsp;
															<?= $data_tagihan->bulan ?> /
															<?= $data_tagihan->tahun ?>
														</td>
														<td>PPJU</td>
														<td>
															:&emsp;
															<?= $data_tagihan->ppju ?>%
														</td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td>Biaya Tagihan</td>
														<td>
															:&emsp;
															<b>
																<?php $biaya_tagihan = "Rp. " . number_format($data_tagihan->biaya_tagihan, 2, ',', '.'); ?>
																<?= $biaya_tagihan ?>
															</b>
														</td>
													</tr>
												</tbody>
											</table>
											<br>
											<p style="font-size: 18px; text-align: center;">
												<i>PLN menyatakan struk ini sebagai bukti pembayaran yang sah, mohon
													disimpan</i>
											</p>
											<br>
											<table>
												<tr>
													<td width="40%">
														<div class="col s6 text-center" style="text-align: center;">
															<hr>
															<hr>
															<br>
															TERIMA KASIH
															<br>"Rincian Tagihan bisa dilihat di www.pln.co.id atau PLN
															terdekat"
															<br>INFORMASI HUB : 123
															<br><br>
															<hr>
															<hr>
														</div>
													</td>


													<td width="60%">
														<div class="col s6">
															<?php
															$bulan_now = date("F");
															$denda = 0;
															if ($bulan_now != $data_tagihan->bulan) {
																$denda = $data_tagihan->denda;
															} elseif ($bulan_now == $data_tagihan->bulan) {
																if (date("d") > 20) {
																	$denda = $data_tagihan->denda;
																}
															} else {
																$denda = 0;
															}

															// Total
															$total_tagihan = $data_tagihan->biaya_tagihan + $denda + $data_biaya_admin->biaya_admin;

															$rp_denda = "Rp. " . number_format($denda, 2, ',', '.');
															$rp_total_tagihan = "Rp. " . number_format($total_tagihan, 2, ',', '.');
															?>
															<table
																class="datatable-1 table table-bordered table-striped display">
																<tbody>
																	<tr>
																		<td>Denda</td>
																		<td>
																			:&emsp;
																			<?= $rp_denda ?>
																		</td>
																	</tr>
																	<tr>
																		<td>Biaya Admin</td>
																		<td>
																			:&emsp;
																			<?php $biaya_admin = "Rp. " . number_format($data_biaya_admin->biaya_admin, 2, ',', '.'); ?>
																			<?= $biaya_admin ?>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Total Biaya</b></td>
																		<td>
																			:&emsp;
																			<b>
																				<?= $rp_total_tagihan ?>
																			</b>
																		</td>
																	</tr>
																</tbody>
															</table>
													</td>
												</tr>

											</table>
											<br>
											<input type="hidden" name="biaya_denda" value="<?= $denda ?>">
											<input type="hidden" name="biaya_admin"
												value="<?= $data_biaya_admin->biaya_admin ?>">
											<input type="hidden" name="jumlah_biaya" value="<?= $total_tagihan ?>">

											<div class="pull-right">

												<button type="submit" name="kirim" class="btn btn-primary"
													onclick="return confirm('Anda yakin ingin melakukan pembayaran?');">
													<i class="fa fa-credit-card icon-form"></i>&emsp;Konfirmasi
													Pembayaran
												</button>
											</div>
							</div>
							<div class="clearfix"></div>
							<br>
							</form>
						</div>
					</div><!--/.module-->
					<br />

				</div><!--/.content-->
		</div><!--/.span9-->
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
	<script>
		function print() {

			window.open('print.php?id=<?= base64_encode($data_tagihan->id_tagihan); ?>');

		}
	</script>
</body>

</html>