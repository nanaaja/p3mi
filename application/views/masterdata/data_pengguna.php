<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        MasterData
        <small>User</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data User </h3>
                    <button class="btn btn-primary my-2 pull-right" data-toggle="modal" data-target="#add-pengguna"><i class="fa fa-plus"></i> Add User</button>

                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="pengguna-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Grant</th>
                                        <th>Create Date</th>
                                        <th>Last Login</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col-->
    </div><!-- ./row -->


    <!-- Modal tambah data -->
    <div class="modal fade add-pengguna" id="add-pengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="tambah-pengguna">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="hidden" class="form-control" id="tipe_form" value="add">
                            <input type="text" class="form-control" id="username" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Grant</label>
                            <select class="form-control" id="grant" required>
                                <?php if ($this->session->userdata('jabatan') == 'superadmin') { ?>
                                    <option value='superadmin'>Super Admin</option>
                                    <option value='p3mi'>P3MI</option>
                                    <option value='blh'>BLH</option>
                                    <option value='lps'>LPS</option>
									<option value='sarkes'>SARKES</option>
                                    <option value='agency'>AGENCY</option>
                                <?php
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" id="status" required>
                                <option value='1'>Aktif</option>
                                <option value='2'>Non Aktif</option>
                            </select>
                        </div>
                        


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
                </form>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var role = '<?php echo $_SESSION['jabatan']; ?>';

                var table = $('#pengguna-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/pengguna_page"); ?>',
                        type: 'POST'
                    },
                    "columnDefs": [{
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [3],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "data": [0],
                            "targets": -1,
                            "render": function(data, type, row, meta) {
                                // if (row[1] != 'koordinator' && row[1] != 'super' && row[1] != 'relawan' && row[1] != 'saksi') {
                                //     console.log(row[1])
                                return "<a href=<?php echo site_url('MasterData/edit_pengguna/'); ?>" +
                                    data +
                                    "><button class='btn btn-primary btn-md' name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button></a> <button type='button' class='btn btn-danger btn-md' name='hapus' id_pengguna=" +
                                    data + " onclick='edit(`" + data +
                                    "`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";

                                // } else {
                                //     return '';
                                // }
                            }
                        }
                    ]
                });
                $(document).on('change', 'select[name="id_kelurahan"]', function() {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_tps_by_kel'); ?>',
                        data: {
                            id_kelurahan: $(this).val()
                        },
                        success: function(data) {
                            $("select[name='id_tps']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }

                    });

                });

                $('#tambah-pengguna').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_pengguna'); ?>',
                        data: {
                            tipe_form: $('#tipe_form').val(),
                            username: $('#username').val(),
                            name: $('#name').val(),
                            status: $('#status').val(),
                            password: $('#password').val(),
                            grant: $('#grant').val(),
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
                                title: 'Pengguna Berhasil ditambahkan'
                            });
                            $('#tambah-pengguna').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/pengguna'); ?>';
                                window.clearTimeout();
                            }, 1000);

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
                                title: 'Username Sudah Terdaftar'
                            })
                        }

                    });

                });

                $(document).on('click', '.add-pengguna', function() {
                    var id_po_produk = $(this).attr('id_po_produk');
                    $('#m_add_pengguna').modal('show');
                });



            });



            function edit(id) {

                var id_user = id;
                console.log(id_user)
                Swal.fire({
                    title: 'Are you sure delete this user..?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url('MasterData/hapus_pengguna'); ?>',
                            data: {
                                id_user: id_user
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
                                    title: 'OK, Berhasil Dihapus'
                                });

                                setTimeout(function() {
                                    window.location.href =
                                        '<?php echo site_url('MasterData/pengguna'); ?>';
                                    window.clearTimeout();
                                }, 1000);

                            },
                            error: function(request, status, error) {
                                console.log('Gagal ke Server')


                            }

                        });
                    }
                    if (result.dismiss == "cancel") {
                        console.log('batal');
                    }

                });

            }
        </script>