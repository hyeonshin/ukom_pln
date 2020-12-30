<?php
require_once '../config/authentication.php';
$auth = new Authentication();
$auth->logout_pln();
header("Location: ../auth/login.php");
?>