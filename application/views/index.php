<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $this->apk[0]->nama_apk; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.css') ?>">
    <!-- Theme style -->
    <link href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url('assets/plugins/iCheck/square/blue.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body class="login-page" style="background-color:white">

    <div class="login-box border" style="">
        <div class="col-md-11">
            <form id="form_login" method="post">

                <center>
                    <?php if (!empty($this->paslon)) { ?>
                        <img src="<?php echo base_url('uploads/foto/') . $this->paslon[0]->photo; ?>" alt="User Image" style="width:70%" />
                        <h3> <?= $this->paslon[0]->nama; ?> </h3>
                    <?php } else { ?>
                        <img src="<?php echo base_url('assets/img/login.svg'); ?>" alt="User Image" style="width:70%" />
                        <h3> <?php echo $this->apk[0]->nama_apk; ?></h3>
                    <?php } ?>
                    <hr>
                    <!--<span style="color:gray">Aplikasi Tim Sukses dan Perhitungan Cepat Perolehan Suara</span>-->
                </center><br>
                <label for="inputEmail" class="sr-only">Username</label>
                <input type="text" id="username" class="form-control " style="margin-bottom: 7px; line-height: 5em;height:45px" id="username" placeholder="Username" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="password" class="form-control" id="password" placeholder="Password" style=" margin-bottom: 7px; line-height: 5em;height:45px" required>
                <button class="btn btn-lg btn-primary  btn-block mt-1 mb-2 bg-purple" style="color:white " type="submit">Masuk</button>
            </form>
            <br>
            <br>
            <br>
            <br>
            <br>
            <center class="text-gray"><small>
                    Application Version : 3.2</small>
            </center>
            <!-- <center>
                Developer : appco
            </center> -->
        </div>



        <!-- </div>/.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert2.js') ?>"></script>

    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_login').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('Login/aksi_login'); ?>',
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    dataType: "json",
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Akses diterima'
                        })
                        console.log(data.role);
                        if (data.role == 'saksi') {
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('Suara/suara'); ?>';
                                window.clearTimeout();
                            }, 1000);
                        } else {
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/dashboard'); ?>';
                                window.clearTimeout();
                            }, 1000);
                        }



                    },
                    error: function(request, status, error) {
                        console.log(request.responseText);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'error',
                            title: 'Akses ditolak, Username atau Password Salah'
                        })
                    }

                });

            });


        })

        
    </script>   
</style>     
<!-- html {
            font-size: 13px;
        }    -->
</body>
</html>
