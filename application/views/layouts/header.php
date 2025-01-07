<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $this->apk[0]->nama_apk; ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url('assets/css/fa.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url('assets/css/select2.css'); ?>" rel="stylesheet">

    <link href="<?php echo base_url('assets/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url('assets/plugins/iCheck/flat/blue.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo base_url('assets/plugins/morris/morris.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Date Picker -->
    <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.css') ?>">
    <!-- old jquery -->
    <!-- <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script> -->
    <script src="<?php echo base_url('assets/js/jquery-new.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/yearpicker.css'); ?>">

    <script src="<?php echo base_url('assets/js/select2.js') ?>"></script>

    <style>
        .swal-wide {
            width: 250px !important;
        }
    </style>



</head>

<body class="<?php echo $this->apk[0]->warna_tema; ?>" style="font-size:15px">
    <div class="wrapper">
        <header class="main-header text-lg">
            <!-- Logo -->
            <a href="#" class="logo">
                <?php if (!empty($this->paslon)) { ?>
                    <img src="<?php echo base_url('uploads/foto/') . $this->paslon[0]->photo; ?>" alt="User Image" style="width:20%" />
                <?php } else { ?>
                    <?php echo $this->apk[0]->nama_apk; ?>
                <?php } ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url('assets/img/avatar5.png'); ?>" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?php echo base_url('assets/img/avatar5.png'); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $_SESSION['username']; ?>
                                        <small>( <?php echo $_SESSION['jabatan']; ?> )</small>
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <center>
                                        <div class=" ">
                                            <a href="<?php echo site_url('Login/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </center>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo base_url('assets/img/avatar5.png'); ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $_SESSION['username']; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <?php if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'koordinator'|| $this->session->userdata('jabatan') == 'admin_it') { ?>

                        <li><a href="<?php echo site_url('MasterData/dashboard'); ?>"><i class="fa fa-home"></i>
                                Dashboard</a></li>
                    <?php } ?>

                    <?php if ($this->session->userdata('jabatan') == 'superadmin') { ?>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Masterdata</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <!-- <li><a href="<?php echo site_url('MasterData/partai'); ?>"><i class="fa fa-folder"></i>
                                    Data Partai</a></li> -->
                                <li><a href="<?php echo site_url('MasterData/data_wilayah?level=1'); ?>"><i class="fa fa-folder"></i>
                                        Regional</a></li>
                                <li><a href="<?php echo site_url('MasterData/blk'); ?>"><i class="fa fa-folder"></i>
                                        BLK</a></li>
                                <li><a href="<?php echo site_url('MasterData/lsp'); ?>"><i class="fa fa-folder"></i>
                                        LSP</a></li>
                                <li><a href="<?php echo site_url('MasterData/tuk'); ?>"><i class="fa fa-folder"></i>
                                        TUK</a></li>
                                <li><a href="<?php echo site_url('MasterData/sarkes'); ?>"><i class="fa fa-folder"></i>
                                        SARKES</a></li>
                                <li><a href="<?php echo site_url('MasterData/agency'); ?>"><i class="fa fa-folder"></i>
                                        Agency</a></li>
                                <li><a href="<?php echo site_url('MasterData/country'); ?>"><i class="fa fa-folder"></i>
                                        Country</a></li>
                                <li><a href="<?php echo site_url('MasterData/district'); ?>"><i class="fa fa-folder"></i>
                                        District</a></li>
                                <li><a href="<?php echo site_url('MasterData/grant'); ?>"><i class="fa fa-folder"></i>
                                        Jobs</a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($this->session->userdata('jabatan') == 'superadmin' ) { ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>P3MI </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left  pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->session->userdata('jabatan') == 'superadmin' ) { ?>

                                    <li><a href="<?php echo site_url('MasterData/candidates'); ?>"><i class="fa fa-folder"></i>
                                            Candidates</a></li>
                                    <li><a href="<?php echo site_url('MasterData/candidates_blk'); ?>"><i class="fa fa-folder"></i>
                                            BLK-LN</a></li>
                                    <li><a href="<?php echo site_url('MasterData/candidates_lsp'); ?>"><i class="fa fa-folder"></i>
                                            LSP</a></li>
                                    <li><a href="<?php echo site_url('MasterData/candidates_sarkes'); ?>"><i class="fa fa-folder"></i>
                                            SARKES</a></li>
                                <?php } ?>
                                
                                
                            </ul>
                        </li>
                    <?php } ?>
                    

                    <hr>

                    <?php if ($this->session->userdata('jabatan') == 'superadmin') { ?>
                        <li><a href="<?php echo site_url('MasterData/pengguna'); ?>"><i class="fa fa-user"></i>
                                Data User</a></li>
                    <?php } ?>
                    <?php if ($this->session->userdata('jabatan') == 'superadmin') { ?>
                        <li><a href="<?php echo site_url('MasterData/konfig'); ?>"><i class="fa fa-gear"></i>
                                Konfig Sistem</a></li>
                    <?php } ?>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">