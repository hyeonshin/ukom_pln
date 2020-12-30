<?php
require_once '../config/authentication.php';

$auth = new Authentication();

if (isset($_POST['login'])) {
	$username = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);
	$login = $auth->login($username, $password);

	if ($login) {
		if ($login == "TIDAK AKTIF") {
			echo "
			<script>
			alert('Akun sudah di non-aktifkan!');
			window.location.href = 'login.php';
			</script>
			";
		} else {
			if ($login == "WRONG") {
				echo "
				<script>
				alert('Username atau password salah!');
				window.location.href = 'login.php';
				</script>
				";
			} else {
				if (isset($_SESSION['admin_session'])) {
					echo "<script>window.location.href = '../admin-sistem/dashboard.php';</script>";
				} elseif (isset($_SESSION['pln_session'])) {
					echo "<script>window.location.href = '../petugas-pln/dashboard.php';</script>";
				} elseif (isset($_SESSION['pembayaran_session'])) {
					echo "<script>window.location.href = '../petugas-pembayaran/dashboard.php';</script>";
				}
			}
		}
	}
}
?>