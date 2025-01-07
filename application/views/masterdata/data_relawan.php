<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Relawan</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Relawan </h3>
                    <?php
                        //if ($this->session->userdata('jabatan') != 'viewer'){
						//	$get_kec = $this->m_masterdata->get_relawansssss($this->session->userdata('id_user'));
                        //$id_kec = $get_kec[0]->id_kec;
                        //if ($id_kec != "3603120") {
                    ?>
                           <!--<button class="btn btn-primary my-2 pull-right add_data" data-toggle="modal" data-target="#add-relawan"><i class="fa fa-plus"></i> Tambah Data</button>-->
                        <?php
                        //}
                          ?>
                    
                    <?php
                        //if (($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('username') == 'Itdata')){
                        
                        
                    ?>
                    <!--<button class="btn btn-success my-2 pull-right mx-2" data-toggle="modal" data-target="#m_import" style="margin-right: 3px;"><i class="fa fa-upload"></i> Import Data</button> &nbsp;-->
                    
                    <?php 
                        //} 
                        //}
                        ?>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="relawan-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Relawan</th>
                                        <th>Nama Relawan</th>
                                        <th>Nik</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Usia</th>
                                        <th>No Telepon</th>
                                        <th>Koordinator</th>
										<th>Kecamatan</th>
                                        <th>Area (Kel/Kec/Kabkota/Prov)</th>
										<th>TPS</th>
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
                    <form action="<?= site_url('ImportController/import_excel_relawan'); ?>" method="post" enctype="multipart/form-data">
                        <h5 class="modal-title" id="exampleModalLabel">Import Relawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <a href="<?php echo base_url('uploads/template_relawan_update.xlsx'); ?>">Download Template Import </a><br><br>

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
    <div class="modal fade add-relawan" id="add-relawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="label_tipe">Tambah</span> Relawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="tambah-relawan" enctype="multipart/form-data">
                    <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="hidden" class="form-control" name="id_relawan">
                            <input type="hidden" class="form-control" name="id_user">
                            <input type="hidden" class="form-control" name="tipe_form" value="add">
                            <input type="text" class="form-control" name="usernames" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Relawan</label>
                            <input type="text" class="form-control" name="nama_relawan" placeholder="" required>
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
                            <label for="exampleFormControlInput1">Usia (Th)</label>
                            <input type="number" class="form-control" name="usia" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">No Telepon</label>
                            <input type="text" class="form-control" name="no_telp" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Koordinator</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_koordinator">
                                <?php foreach ($data_koordinator as $r) { ?>
                                    <option value='<?= $r->id_koordinator; ?>'><?= $r->nama_koordinator; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label>Provinsi</label>
                            <select class="form-control" style="width:100%" name="id_provinsi">
                                <option value=''>Pilih Provinsi</option>
                                <?php foreach ($data_provinsi as $r) { ?>
                                    <option value='<?= $r->id_prov; ?>'><?= $r->nama_prov; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kabupaten / Kota</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="id_kabupaten" name="id_kabupaten">
                                <?php foreach ($data_kabupaten as $r) { ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="id_kecamatan" name="id_kecamatan">
                                <?php foreach ($data_kecamatan as $r) { ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan">
                                <?php foreach ($data_kelurahan as $r) { ?>
                                <?php } ?>
                            </select>
                        </div> -->
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan">
                                        <option value=''>Pilih Wilayah </option>
                                        <?php foreach ($data_kelurahan as $r) { ?>
                                            <option value='<?= $r->id_kel; ?>'><?= $r->nama_prov . ' / ' . $r->nama_kab . ' / ' . $r->nama_kec . ' / ' . $r->nama_kel; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>TPS</label>
                                    <select class="form-control js-example-basic-single" style="width:100%" name="id_tps" id="id_tps" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Relawan</button>
                </div>
                </form>
            </div>
        </div>


        <script type="text/javascript">
            $(document).ready(function() {
                var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'
                var role = '<?php echo $_SESSION['jabatan']; ?>';
                console.log(role)

                var table = $('#relawan-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/relawan_page"); ?>',
                        type: 'POST'
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data Relawan',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Hanya kolom ke-0 sampai ke-3 yang diekspor
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
                                if(role == 'superadmin'){
                                    return "<button class='btn btn-primary btn-md edit-relawan' id_relawan=" + data + "  name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button>  <button type='button' class='btn btn-danger btn-md' name='hapus' id_relawan=" +
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
                    $('#tambah-relawan').trigger("reset");
                    $("input[name='tipe_form']").val('add');
                    $("#label_tipe").text('Tambah');
                });

                $(document).on('click', '.edit-relawan', function() {
                    $('#add-relawan').modal('show');

                    $("input[name='tipe_form']").val('edit');

                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_relawan'); ?>',
                        data: {
                            "id_relawan": $(this).attr('id_relawan'),
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#label_tipe").text('Ubah');
                            $("input[name='usernames']").val(data[0].username)
                            $("input[name='id_relawan']").val(data[0].id_relawan)
                            $("input[name='id_user']").val(data[0].id_user)
                            $("select[name='id_koordinator']").val(data[0].id_koordinator).trigger('change');
                            $("input[name='nama_relawan']").val(data[0].nama_relawan)
                            $("input[name='nik']").val(data[0].nik)
                            $("select[name='jk']").val(data[0].jk)
                            $("input[name='usia']").val(data[0].usia)
                            $("input[name='no_telp']").val(data[0].no_telp)
                            

                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('MasterData/get_detail_wil_by_id_kel'); ?>',
                                data: {
                                    "id_kel": data[0].id_kel,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // $("select[name='id_provinsi']").val(data[0].id_prov);
                                    // setTimeout(() => {
                                    //     $("select[name='id_kelurahan']").append($('<option>', {
                                    //         value: data[0].id_kel,
                                    //         text: data[0].nama_kel
                                    //     }));
                                    //     $("select[name='id_kecamatan']").append($('<option>', {
                                    //         value: data[0].id_kec,
                                    //         text: data[0].nama_kec
                                    //     }));
                                    //     $("select[name='id_kabupaten']").append($('<option>', {
                                    //         value: data[0].id_kab,
                                    //         text: data[0].nama_kab
                                    //     }));


                                    // }, 500);

                                },
                                error: function(request, status, error) {
                                    console.log('Gagal ke Server')
                                }
                            });

                        },
                        error: function(request, status, error) {
                            console.log('Gagal ke Server')
                        }
                    });
                });


                $('#tambah-relawan').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_relawan'); ?>',
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
                            $('#tambah-relawan').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/relawan'); ?>';
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
                                title: 'Username atau NIK Sudah Terdaftar'
                            })
                        }

                    });

                });



                $(document).on('click', 'select[name="id_provinsi"]', function() {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_kab_by_prov'); ?>',
                        data: {
                            id_prov: $(this).val()
                        },
                        success: function(data) {
                            $("select[name='id_kabupaten']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }
                    });
                });

                $(document).on('change', 'select[name="id_kabupaten"]', function() {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_kec_by_kab'); ?>',
                        data: {
                            id_kabupaten: $(this).val()
                        },
                        success: function(data) {
                            $("select[name='id_kecamatan']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }
                    });
                });

                $(document).on('change', 'select[name="id_kecamatan"]', function() {

                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_kel_by_kec'); ?>',
                        data: {
                            id_kecamatan: $(this).val()
                        },
                        success: function(data) {
                            $("select[name='id_kelurahan']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }

                    });

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





            });



            function edit(id) {

                var id_relawan = id;
                console.log(id_relawan)
                Swal.fire({
                    title: 'Anda yakin hapus relawan ini..?',
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
                            url: '<?php echo site_url('MasterData/hapus_relawan'); ?>',
                            data: {
                                id_relawan: id_relawan
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
                                        '<?php echo site_url('MasterData/relawan'); ?>';
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