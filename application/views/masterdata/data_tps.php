<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>TPS</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data TPS </h3>
                    <button class="btn btn-primary my-2 pull-right mx-3" data-toggle="modal" data-target="#add-tps"><i class="fa fa-plus"></i> Tambah Data</button> &nbsp;
                    <button class="btn btn-success my-2 pull-right mx-2" data-toggle="modal" data-target="#m_import" style="margin-right: 3px;"><i class="fa fa-upload"></i> Import Data</button> &nbsp;

                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tps-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Tps</th>
                                        <th>No TPS</th>
                                        <th>Nama TPS</th>
                                        <th>Alamat</th>
                                        <th>Prov</th>
                                        <th>KabKota</th>
                                        <th>Kec</th>
                                        <th>Kelurahan</th>
                                        <th>DPT</th>
                                        <th>Saksi</th>
<!--<th>Relawan</th>-->
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
    <div class="modal fade add-tps" id="add-tps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah TPS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="tambah-tps" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">No TPS</label>
                            <input type="hidden" class="form-control" name="tipe_form" value="add">
                            <input type="text" class="form-control" name="no_tps" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama TPS</label>
                            <input type="text" class="form-control" name="nama_tps" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Total DPT</label>
                            <input type="number" class="form-control" name="dpt" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kelurahan (Prov / Kabkota / Kec / Desa)</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan" required>
                                <?php foreach ($data_kelurahan as $r) { ?>
                                    <option value='<?= $r->id_kel; ?>'><?= $r->nama_prov . ' / ' . $r->nama_kab . ' / ' . $r->nama_kec . ' / ' . $r->nama_kel . ' (' . $r->id_kel . ')'; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah TPS</button>
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
                    <form action="<?= site_url('ImportController/import_excel_tps'); ?>" method="post" enctype="multipart/form-data">
                        <h5 class="modal-title" id="exampleModalLabel">Import TPS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <a href="<?php echo base_url('uploads/template_tps_new.xlsx'); ?>">Download Template Import </a><br><br>

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
                $('.js-example-basic-single').select2();
                var role = '<?php echo $_SESSION['jabatan']; ?>';

                var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'

                var table = $('#tps-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/tps_page"); ?>',
                        type: 'POST'
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data TPS',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] // Hanya kolom ke-0 sampai ke-3 yang diekspor
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
									return "<a href=<?php echo site_url('MasterData/edit_tps/'); ?>" +
										data +
										"><button class='btn btn-primary btn-md' name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button></a> <button type='button' class='btn btn-danger btn-md' name='hapus' id_tps=" +
										data + " onclick='edit(`" + data +
										"`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";
								}else{
                                    return null;
                                }
                            }
                        }
                    ]
                });


                $('#tambah-tps').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_tps'); ?>',
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
                                title: 'TPS Berhasil ditambahkan'
                            });
                            $('#tambah-tps').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/tps'); ?>';
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

                $(document).on('click', '.add-tps', function() {
                    var id_po_produk = $(this).attr('id_po_produk');
                    $('#m_add_tps').modal('show');
                });
                $(document).on('click', '.import', function() {
                    $('#m_import').modal('show');
                });



            });



            function edit(id) {

                var id_tps = id;
                console.log(id_tps)
                Swal.fire({
                    title: 'Anda yakin hapus tps ini..?',
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
                            url: '<?php echo site_url('MasterData/hapus_tps'); ?>',
                            data: {
                                id_tps: id_tps
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
                                        '<?php echo site_url('MasterData/tps'); ?>';
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