<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Paslon</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Paslon </h3>
                    <button class="btn btn-primary my-2 pull-right mx-3" data-toggle="modal" data-target="#add-caleg"><i class="fa fa-plus"></i> Tambah Data</button> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="caleg-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Paslon</th>
                                        <th>Nama</th>
                                        <th>No Urut</th>
                                        <th>Kota</th>
                                        <th>Photo</th>
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
    <div class="modal fade add-caleg" id="add-caleg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Paslon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="tambah-caleg" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama</label>
                            <input type="hidden" class="form-control" name="tipe_form" value="add">
                            <input type="text" class="form-control" name="nama" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">No Urut</label>
                            <input type="text" class="form-control" name="no_urut" placeholder="" required>
                        </div>

                        <!-- <div class="form-group">
                            <label for="exampleFormControlSelect1">Partai</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_partai" required>
                                <?php foreach ($data_partai as $r) { ?>
                                    <option value='<?= $r->id_partai; ?>'><?= $r->nama_partai; ?></option>
                                <?php } ?>
                            </select>
                        </div> -->

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kota</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kab" required>
                                <?php foreach ($data_kota as $r) { ?>
                                    <option value='<?= $r->id_kab; ?>'><?= $r->nama_kab; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlInput1">Photo</label>
                            <input type="file" accept="image/*" class="form-control" name="image" placeholder="">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Paslon</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal import data -->
    <div class="modal fade" id="m_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <form action="<?= site_url('ImportController/import_excel'); ?>" method="post" enctype="multipart/form-data">

                        <h5 class="modal-title" id="exampleModalLabel">Tambah Paslon</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
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

        <script type="text/javascript">
            $(document).ready(function() {
                var role = '<?php echo $_SESSION['jabatan']; ?>';

                var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'

                var table = $('#caleg-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/caleg_page"); ?>',
                        type: 'POST'
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data Paslon',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, ] // Hanya kolom ke-0 sampai ke-3 yang diekspor
                        }
                    }],
                    "columnDefs": [{
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "data": [4],
                            "targets": -2,
                            "render": function(data, type, row, meta) {
                                return "<img src= " + base_image_url +
                                    data + " width='100'>  ";
                            }
                        },
                        {
                            "data": [0],
                            "targets": -1,
                            "render": function(data, type, row, meta) {
                                return "<a href=<?php echo site_url('MasterData/edit_paslon/'); ?>" +
                                    data +
                                    "><button class='btn btn-primary btn-md' name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button></a> <button type='button' class='btn btn-danger btn-md' name='hapus' id_caleg=" +
                                    data + " onclick='edit(`" + data +
                                    "`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";

                            }
                        }
                    ]
                });


                $('#tambah-caleg').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_caleg'); ?>',
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
                                title: 'Berhasil ditambahkan'
                            });
                            $('#tambah-caleg').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/paslon'); ?>';
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
                                title: 'Gagal menghubungkan Ke Server'
                            })
                        }

                    });

                });

                $(document).on('click', '.add-caleg', function() {
                    var id_po_produk = $(this).attr('id_po_produk');
                    $('#m_add_caleg').modal('show');
                });
                $(document).on('click', '.import', function() {
                    $('#m_import').modal('show');
                });





            });



            function edit(id) {

                var id_caleg = id;
                console.log(id_caleg)
                Swal.fire({
                    title: 'Anda yakin hapus caleg ini..?',
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
                            url: '<?php echo site_url('MasterData/hapus_caleg'); ?>',
                            data: {
                                id_caleg: id_caleg
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
                                        '<?php echo site_url('MasterData/paslon'); ?>';
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