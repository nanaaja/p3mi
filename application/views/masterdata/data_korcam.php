<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Koordinator Kecamatan</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Koordinator Kecamatan</h3>
                    <?php
                        if ($this->session->userdata('jabatan') != 'viewer'){
                          ?>
                        <button class="btn btn-primary my-2 pull-right add_data" data-toggle="modal" data-target="#add-koordinator"><i class="fa fa-plus"></i> Tambah Data</button>
                        <button class="btn btn-success my-2 pull-right mx-2" data-toggle="modal" data-target="#m_import" style="margin-right: 3px;"><i class="fa fa-upload"></i> Import Data</button> &nbsp;

                          <?php  
                        }
                        ?>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="koordinator-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Koordinator</th>
                                        <th>Nama Koordinator</th>
                                        <th>Nik</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>No Telepon</th>
                                        <th>Kecamatan</th>
                                        <th>Fungsi</th>
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


    <!-- Modal import data -->
    <div class="modal fade" id="m_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <form action="<?= site_url('ImportController/import_excel_koordinator'); ?>" method="post" enctype="multipart/form-data">
                        <h5 class="modal-title" id="exampleModalLabel">Import Koordinator</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <a href="<?php echo base_url('uploads/template_koordinator.xlsx'); ?>">Download Template Import </a><br><br>

                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" name="fileExcel">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class='btn btn-success' type="submit">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Import
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal tambah data -->
    <div class="modal fade add-koordinator" id="add-koordinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="label_tipe">Tambah</span> Koordinator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="tambah-koordinator" enctype="multipart/form-data">
                    <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="hidden" class="form-control" name="tipe_form" value="add">
                            <input type="hidden" class="form-control" name="id_koordinator">
                            <input type="hidden" class="form-control" name="id_user">
                            <input type="text" class="form-control" name="username" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Koordinator</label>
                            
                            <input type="text" class="form-control" name="nama_koordinator" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">NIK</label>
                            <input type="text" class="form-control" name="nik" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                            <select class="form-control" name="jk" required>
                                <option value='L'>Laki-Laki</option>
                                <option value='P'>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">No Telepon</label>
                            <input type="text" class="form-control" name="no_telp" placeholder="" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select class="form-control js-example-basic-single" style="width:100%" name="id_kecamatan" required>
                                        <option value=''>Pilih Wilayah </option>
                                        <?php foreach ($data_kecamatan as $r) { ?>
                                            <option value='<?= $r->id_kec; ?>'><?= $r->nama_prov . ' / ' . $r->nama_kab . ' / ' . $r->nama_kec; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Koordinator</button>
                </div>
                </form>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'
                var role = '<?php echo $_SESSION['jabatan']; ?>';
                console.log(role)

                var table = $('#koordinator-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/korcam_page"); ?>',
                        type: 'POST'
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data Koordinator',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Hanya kolom ke-0 sampai ke-3 yang diekspor
                        }
                    }],
                    "columnDefs": [{
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        },

                        {
                            "data": [0],
                            "targets": -1,
                            "render": function(data, type, row, meta) {
                                if(role != 'viewer'){
                                    return "<button class='btn btn-primary btn-md edit-koordinator' id_koordinator=" + data + "  name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button>  <button type='button' class='btn btn-danger btn-md' name='hapus' id_koordinator=" +
                                    data + " onclick='edit(`" + data +
                                    "`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";
                                }else{
                                    return null;
                                }
                                

                            }
                        }
                    ]
                });


                $(document).on('click', '.add_data', function() {
                    $('#tambah-koordinator').trigger("reset");
                    $("input[name='tipe_form']").val('add');
                    $("#label_tipe").text('Tambah');
                });

                $(document).on('click', '.edit-koordinator', function() {
                    $('#add-koordinator').modal('show');

                    $("input[name='tipe_form']").val('edit');

                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_korcam'); ?>',
                        data: {
                            "id_koordinator": $(this).attr('id_koordinator'),
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#label_tipe").text('Ubah');

                            $("input[name='username']").val(data[0].username)
                            $("input[name='id_user']").val(data[0].userid)
                            $("input[name='id_koordinator']").val(data[0].id_koordinator)
                            $("input[name='nama_koordinator']").val(data[0].nama_koordinator)
                            $("input[name='nik']").val(data[0].nik)
                            $("select[name='jk']").val(data[0].jk)
                            $("input[name='alamat']").val(data[0].alamat)
                            $("input[name='no_telp']").val(data[0].no_telp)
                            $("input[name='id_kecamatan']").val(data[0].id_kec)

                        },
                        error: function(request, status, error) {
                            console.log('Gagal ke Server')
                        }
                    });
                });


                $('#tambah-koordinator').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_korcam'); ?>',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
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
                                title: 'Data Berhasil Disimpan'
                            });
                            $('#tambah-koordinator').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/korcam'); ?>';
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
                                title: 'NIK atau Username Sudah Terdaptar'
                            })
                        }

                    });

                });

            });



            function edit(id) {

                var id_koordinator = id;
                console.log(id_koordinator)
                Swal.fire({
                    title: 'Anda yakin hapus koordinator ini..?',
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
                            url: '<?php echo site_url('MasterData/hapus_korcam'); ?>',
                            data: {
                                id_koordinator: id_koordinator
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
                                        '<?php echo site_url('MasterData/korcam'); ?>';
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