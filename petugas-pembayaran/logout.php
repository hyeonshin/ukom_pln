<?php
require_once '../config/authentication.php';
$auth = new Authentication();
$auth->logout_pembayaran();
header("Location: ../auth/login.php");
?>