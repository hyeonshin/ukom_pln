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
	<link type="text/css" href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../../../css/theme.css" rel="stylesheet">
	<link type="text/css" href="../../../images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../../../font-awesome/css/font-awesome.min.css">

</head>
<body>

	<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="../../index.php"><center><img src="../../../resource/foto/logo_tuneder.png" class="navbar-brand" width="44%"> </center></a>
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
                                <li class="active"><a href="../../index.php"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                                <li><a href="../../tarif/index.php"><i class="menu-icon fa fa-bolt"></i>Tarif</a>
                                </li>
                                <li><a href="../../kota/index.php"><i class="menu-icon fa fa-building"></i>Kota</a>
                                </li>
                                <li><a href="../../pelanggan/index.php"><i class="menu-icon icon-group"p></i>Pelanggan</a>
                                </li>
                            </ul>
                            <!--/.widget-nav-->
                            
                            
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li><a href="../../logout.php"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>
                        </div><!--/.sidebar-->
				</div><!--/.span3-->


				<div class="span9">
					<div class="content">
						<div class="module">
							<div class="module-head clearfix">
                                    <div class="pull-left">
                                        <h3>Table Data Penggunaan</h3>
                                    </div>
                                    <div class="pull-right">
                                        <a href="../penggunaan-listrik?id=<?= base64_encode($data_pelanggan->id_pelanggan); ?>" class="btn btn-success"><i class="fa fa-eye"></i>&ensp;Lihat Penggunaan</a>
                                    </div>
                                </div
>							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
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
										</tr>
									</thead>
									<tbody>
										
						<?php while ($data_tagihan = $select_tagihan->fetch(PDO::FETCH_OBJ)) { ?>
							<?php
							
							$biaya_tagihan = "Rp. " . number_format($data_tagihan->biaya_tagihan,2,',','.');
							?>
							<tr>
								
								<td><?php echo $data_tagihan->id_tagihan; ?></td>
								<td><?php echo $data_tagihan->id_penggunaan; ?></td>
								<td><?php echo $data_tagihan->bulan; ?> / <?php echo $data_tagihan->tahun; ?></td>
								<td><?php echo $data_tagihan->meter_awal." - ".$data_tagihan->meter_akhir; ?> VA</td>
								<td><?php echo $data_tagihan->jumlah_meter; ?> KWH</td>
								<td><?php echo $biaya_tagihan; ?></td>
								<td>
									<?php if ($data_tagihan->status == "Belum Dibayar"): ?>
										<span class="label-status grey white-text">&emsp;Belum Dibayar&emsp;</span>
									<?php else: ?>
										<span class="label-status green white-text">&emsp;Sudah Dibayar&emsp;</span>
									<?php endif ?>
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

	<script src="../../../scripts/jquery-1.9.1.min.js"></script>
	<script src="../../../scripts/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>