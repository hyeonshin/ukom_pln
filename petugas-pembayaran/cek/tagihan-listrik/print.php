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
		window.location.href='.?id=".base64_encode($data_tagihan->id_pelanggan)."';
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
	<link type="text/css" href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../../../css/theme.css" rel="stylesheet">
	<link type="text/css" href="../../../images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../../../font-awesome/css/font-awesome.min.css">

</head>
<body>

	



	<div class="wrapper">
		<div class="container">
			<div class="row">
				


				<div class="span12">
					<div class="module">
							
							<div class="module-body">
									
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<table>
							<thead>
								<form action="" method="POST">
							<?php $date_input_now = date("Y-m-d"); ?>
							<?php $date_now = date(" Y F, d"); ?>
							<input type="hidden" name="id_pembayaran" value="<?= $get_code; ?>">
							<input type="hidden" name="id_pelanggan" value="<?= $data_tagihan->id_pelanggan; ?>">
							<input type="hidden" name="id_tagihan" value="<?= $data_tagihan->id_tagihan; ?>">
							<input type="hidden" name="id_biaya_admin" value="<?= $data_biaya_admin->id_biaya_admin; ?>">
							<input type="hidden" name="id_user" value="<?= $get_data['id_user']; ?>">
							<input type="hidden" name="tgl_pembayaran" value="<?= $date_input_now; ?>">
							<div class="pull-right">
								<p class="card-title-welcome text-center">
									Tanggal Pembayaran : <?= $date_now; ?>
								</p>
							</div>
							<div class="left">
								<p class="brand-login">
									<img src="../../../resource/foto/logo_tuneder.png" alt="Tune-der" class="img-brand-login">
								</p>
							</div>
							
							<div class="clearfix"></div>
							<hr>
							<table >
							<div class="col-sm-2">
							<tr>
								<td width="20%">
								<p style="font-size: 18px;"><b><u>Alamat Pelanggan</u></b></p>
								</td>
								<td width="80%">
								<div class="pull-right">
									<p style="font-size: 18px;"><b>No. Pembayaran : #<?= $get_code; ?></b></p>
								</div>	
								</td>
							</tr>
							<tr>
								<td>
									<p>
									<?= $data_tagihan->alamat ?>,
									<br><?= $data_tagihan->nama_kota ?>
									</p>	
								</td>
								<td>
									<div class="pull-right">
									
								<table class="pull-right">
									<tbody>
										<tr>
											<td>Nometer</td>
											<td>:</td>
											<td><?= $data_tagihan->nometer ?></td>
										</tr>
										<tr>
											<td colspan="3"><hr></td>
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
							<table border="0" class="datatable-1 table table-bordered table-striped	 display" width="1024px">
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
											$meter_awal = number_format($data_tagihan->meter_awal,0,'','.');
											$meter_akhir = number_format($data_tagihan->meter_akhir,0,'','.');
											?>
											<?= $meter_awal ?> - <?= $meter_akhir ?> VA
										</td>
									</tr>
									<tr>
										<td>Jenis Daya</td>
										<td>
											:&emsp;
											<?php
											$daya = number_format($data_tagihan->daya,0,'','.');
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
											<?= $data_tagihan->bulan ?> / <?= $data_tagihan->tahun ?>
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
												<?php $biaya_tagihan = "Rp. ".number_format($data_tagihan->biaya_tagihan,2,',','.'); ?>
												<?= $biaya_tagihan ?>
											</b>
										</td>
									</tr>
								</tbody>
							</table>
							<br>
							<p style="font-size: 18px; text-align: center;">
								<i>PLN menyatakan struk ini sebagai bukti pembayaran yang sah, mohon disimpan</i>
							</p>
							<br>
							<table>
							<tr>
								<td width="40%">
									<center>
							
								<hr><hr>
								<br>
								TERIMA KASIH
								<br>"Rincian Tagihan bisa dilihat di www.pln.co.id atau PLN terdekat"
								<br>INFORMASI HUB : 123
								<br><br>
								<hr><hr>
							
									</center>
								</td>
							
			
							<td width="20%">
							<div class="">
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

								$rp_denda = "Rp. ".number_format($denda,2,',','.');
								$rp_total_tagihan = "Rp. ".number_format($total_tagihan,2,',','.');
								?>
								<div class="hidden">
								<table class="datatable-1 table table-bordered table-striped display" >
									<tbody>
										<tr>
											<td width="30%">Denda</td>
											<td width="7o%">
												:&emsp;
												<?= $rp_denda ?>
											</td>
										</tr>
										<tr>
											<td width="30%">Biaya Admin</td>
											<td width="70%">
												:&emsp;
												<?php $biaya_admin = "Rp. ".number_format($data_biaya_admin->biaya_admin,2,',','.'); ?>
												<?= $biaya_admin ?>
											</td>
										</tr>
										<tr>
											<td width="30%"><b>Total Biaya</b></td>
											<td width="70%">
												:&emsp;
												<b><?= $rp_total_tagihan ?></b>
											</td>
										</tr>
									</tbody>

								</table>
							</div>
								
							</td>
							<td width="40%">
								<table class="datatable-1 table table-bordered table-striped display" >
									<tbody>
										<tr>
											<td width="30%">Denda</td>
											<td width="7o%">
												:&emsp;
												<?= $rp_denda ?>
											</td>
										</tr>
										<tr>
											<td width="30%">Biaya Admin</td>
											<td width="70%">
												:&emsp;
												<?php $biaya_admin = "Rp. ".number_format($data_biaya_admin->biaya_admin,2,',','.'); ?>
												<?= $biaya_admin ?>
											</td>
										</tr>
										<tr>
											<td width="30%"><b>Total Biaya</b></td>
											<td width="70%">
												:&emsp;
												<b><?= $rp_total_tagihan ?></b>
											</td>
										</tr>
									</tbody>

								</table>
							</td>
							</tr>
						
							</table>
								<br>
								<input type="hidden" name="biaya_denda" value="<?= $denda ?>">
								<input type="hidden" name="biaya_admin" value="<?= $data_biaya_admin->biaya_admin ?>">
								<input type="hidden" name="jumlah_biaya" value="<?= $total_tagihan ?>">
								
								
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
		</div><!--/.container-->
	</div><!--/.wrapper-->

	

	<script src="../../../scripts/jquery-1.9.1.min.js"></script>
	<script src="../../../scripts/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../scripts/datatables/jquery.dataTables.js"></script>
	<script>
		window.print();
	</script>
</body>
</html>