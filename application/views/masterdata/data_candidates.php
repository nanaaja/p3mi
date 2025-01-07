<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>candidates</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data candidates </h3>
                    <a href=<?php echo site_url('MasterData/tambah_candidates/'); ?>><button class="btn btn-primary my-2 pull-right mx-3" ><i class="fa fa-plus"></i> Add Data</button></a> &nbsp;
                    <!-- <button class="btn btn-success my-2 pull-right mx-2" data-toggle="modal" data-target="#m_import" style="margin-right: 3px;"><i class="fa fa-upload"></i> Import Data</button> &nbsp; -->

                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="candidates-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>NIK</th>
                                        <th>Gender</th>
                                        <th>Agency Name</th>
                                        <th>Country</th>
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

                var table = $('#candidates-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/candidates_page"); ?>',
                        type: 'POST'
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data candidates',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] // Hanya kolom ke-0 sampai ke-3 yang diekspor
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
									return "<a href=<?php echo site_url('MasterData/edit_candidates/'); ?>" +
										data +
										"><button class='btn btn-primary btn-md' name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button></a> <button type='button' class='btn btn-danger btn-md' name='hapus' candidates_id=" +
										data + " onclick='edit(`" + data +
										"`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";
								}else{
                                    return null;
                                }
                            }
                        }
                    ]
                });


                $('#tambah-candidates').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_candidates'); ?>',
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
                                title: 'candidates Berhasil ditambahkan'
                            });
                            $('#tambah-candidates').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/candidates'); ?>';
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

                $(document).on('click', '.add-candidates', function() {
                    var id_po_produk = $(this).attr('id_po_produk');
                    $('#m_add_candidates').modal('show');
                });
                $(document).on('click', '.import', function() {
                    $('#m_import').modal('show');
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
                            $("select[name='candidates_district']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }

                    });

                });

                $(document).on('click', 'select[name="country_id"]', function() {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_district_by_countryid'); ?>',
                        data: {
                            country_id: $(this).val()
                        },
                        success: function(data) {
                            $("select[name='district_area']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }
                    });
                });



            });



            function edit(id) {

                var candidates_id = id;
                console.log(candidates_id)
                Swal.fire({
                    title: 'Are you sure delete candidates this..?',
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
                            url: '<?php echo site_url('MasterData/hapus_candidates'); ?>',
                            data: {
                                candidates_id: candidates_id
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
                                        '<?php echo site_url('MasterData/candidates'); ?>';
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