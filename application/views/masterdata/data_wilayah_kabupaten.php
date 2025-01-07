<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Wilayah Kabupaten</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Wilayah Kabupaten </h3>
                    <button class="btn btn-primary my-2 pull-right" data-toggle="modal" data-target="#add-wilayah_kabupaten"><i class="fa fa-plus"></i> Tambah Data</button>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="wilayah_kabupaten-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Kabupaten</th>
                                        <th>Nama Kabupaten</th>
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

    <!-- Modal tambah data -->
    <div class="modal fade add-wilayah_kabupaten" id="add-wilayah_kabupaten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="label_tipe">Tambah</span> Kabupaten</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="tambah-wilayah_kabupaten" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">ID Kabupaten <span class="text-danger">(ID Tidak Bisa diubah setelah diinput)</span></label>
                            <input type="hidden" class="form-control" name="id_prov">
                            <input type="hidden" class="form-control" name="tipe_form" value="add">
                            <input type="text" class="form-control" name="id_prov" placeholder="" required maxlength="2">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Kabupaten</label>
                            <input type="text" class="form-control" name="nama_wilayah_kabupaten" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Provinsi</label>
                            <input type="text" class="form-control" name="nama_wilayah_kabupaten" placeholder="" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'
                var role = '<?php echo $_SESSION['jabatan']; ?>';
                console.log(role)

                var table = $('#wilayah_kabupaten-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/wilayah_kabupaten_page"); ?>',
                        type: 'POST'
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data wilayah_kabupaten',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    }],
                    "columnDefs": [{
                        "data": [0],
                        "targets": -1,
                        "render": function(data, type, row, meta) {
                            return "<button class='btn btn-primary btn-md edit-wilayah_kabupaten' id_prov='" + data + "' ><i class='fa fa-edit  text-white-50 mr-1'></i>  </button> <button type='button' class='btn btn-danger btn-md' name='hapus' id_prov=" +
                                data + " onclick='edit(`" + data +
                                "`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";

                        }
                    }, {
                        "defaultContent": "-",
                        "targets": "_all"
                    }]
                });

                $(document).on('click', '.add_data', function() {
                    $('#tambah-wilayah_kabupaten').trigger("reset");
                    $("input[name='tipe_form']").val('add');
                    $("input[name='id_prov']").prop('readonly', false);
                    $("#label_tipe").text('Tambah');
                });

                $(document).on('click', '.edit-wilayah_kabupaten', function() {
                    $('#add-wilayah_kabupaten').modal('show');
                    $("input[name='tipe_form']").val('edit');
                    $("input[name='id_prov']").prop('readonly', true);

                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_wilayah_kabupaten'); ?>',
                        data: {
                            "id_prov": $(this).attr('id_prov'),
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#label_tipe").text('Ubah');
                            $("input[name='id_prov']").val(data[0].id_prov)
                            $("input[name='nama_wilayah_kabupaten']").val(data[0].nama_prov)
                        },
                        error: function(request, status, error) {
                            console.log('Gagal ke Server')
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


                $('#tambah-wilayah_kabupaten').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_wilayah_kabupaten'); ?>',
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
                            $('#tambah-wilayah_kabupaten').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/wilayah_kabupaten'); ?>';
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
                                title: 'Gagal menghubungkan Ke Server / ID Sudah Ada'
                            })
                        }

                    });

                });

                $(document).on('click', '.add-wilayah_kabupaten', function() {
                    var id_po_produk = $(this).attr('id_po_produk');
                    $('#m_add_wilayah_kabupaten').modal('show');
                });



            });



            function edit(id) {

                var id_prov = id;
                console.log(id_prov)
                Swal.fire({
                    title: 'Anda yakin hapus wilayah_kabupaten ini..?',
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
                            url: '<?php echo site_url('MasterData/hapus_wilayah_kabupaten'); ?>',
                            data: {
                                id_prov: id_prov
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
                                        '<?php echo site_url('MasterData/wilayah_kabupaten'); ?>';
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