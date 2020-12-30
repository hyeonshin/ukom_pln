<?php
require_once '../config/library.php';
require_once '../config/authentication.php';

$lib = new Library();
$auth = new Authentication();

if (!$auth->logged_pembayaran()) {
    header("Location: ../auth/login.php");
}

$jumlah_biaya_admin = $lib->jumlah_biaya_admin();
$jumlah_pembayaran = $lib->jumlah_pembayaran();
$get_data = $auth->get_data_pembayaran();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tune-der</title>
        <link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="../css/theme.css" rel="stylesheet">
        <link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='../http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="..//font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="../index.php"><center><img src="../resource/foto/logo_tuneder.png" class="navbar-brand" width="44%"> </center></a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="index.php"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                                <li><a href="pengaturan-biaya?id=<?= base64_encode(1); ?>"><i class="menu-icon fa fa-wrench"></i>Pengaturan Biaya</a>
                                </li>
                                <li><a href="cek"><i class="menu-icon fa fa-money"></i>Pembayaran</a>
                                </li>
                            </ul>
                            <!--/.widget-nav-->
                            
                            
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li><a href="logout.php"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <div class="btn-box big span8">
                                        <img src="../resource/foto//logo_tuneder.png"><br>
                                        <h3>Welcome back,<?= $get_data['nama_user']; ?>!</h3>

                                    </div><div class="btn-box big span4"><i class="icon-user"></i><b><?= $get_data['nama_user']; ?></b>
                                        <p class="text-muted">
                                            <?= $get_data['level']; ?></p>
                                    </div>
                                </div>
                                <div class="btn-box-row row-fluid">
                                    <div class="span8">
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div  class="btn-box small span12"><i class="fa fa-money"></i><b><?= $jumlah_pembayaran ?></b><b><small>Jumlah Data Pembayaran</small></b>
                                                </div>
                                            </div>
                                            <div class="span6">
                                                <div class="btn-box small span12"><i class="fa fa-wrench"></i><b>Rp.<?= $jumlah_biaya_admin ?>,00</b><b><small> Biaya Admin</small></b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            
                                        </div>
                                        <div class="row-fluid">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/#btn-controls-->
                            
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">Copyright &copy; 2018 Tune-der. </b>All rights reserved.
            </div>
        </div>
        <script src="../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="../scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="../scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../scripts/common.js" type="text/javascript"></script>
      
    </body>



