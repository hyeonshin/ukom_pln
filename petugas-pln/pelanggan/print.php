<?php
require_once '../../config/library.php';
require_once '../../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

$view = $lib->view_pelanggan();
$get_data = $auth->get_data_pln();

if (!$auth->logged_pln()) {
	header("Location: ../../auth/login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tune-der</title>
	<link type="text/css" href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="../../css/theme.css" rel="stylesheet">
	<link type="text/css" href="../../images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../../font-awesome/css/font-awesome.min.css">

</head>
<body>
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%" id="print">
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
							$daya = number_format($data->daya,0,',','.');
							?>
							<tr>
								<td><?php echo $data->id_pelanggan; ?></td>
								<td><?php echo $data->nama_pelanggan; ?></td>
								<td><?php echo $data->nometer; ?></td>
								<td><?php echo $data->nama_kota; ?></td>
								<td><?php echo $daya; ?> VA</td>
								
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

	<script src="../../scripts/jquery-1.9.1.min.js"></script>
	<script src="../../scripts/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../scripts/datatables/jquery.dataTables.js"></script>
	
</body>
<script> 
window.print();
</script>