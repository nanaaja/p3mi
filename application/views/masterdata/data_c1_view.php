<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Dokumen C1</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Dokumen C1 </h3>

                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="caleg-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Kategori</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Tps</th>
                                        <th>Waktu Input</th>
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


    <script type="text/javascript">
        $(document).ready(function() {
            var role = '<?php echo $_SESSION['jabatan']; ?>';

            var base_image_url = '<?php echo base_url('uploads/c1/'); ?>'

            var table = $('#caleg-table').DataTable({
                "ajax": {
                    url: '<?php echo site_url("Suara/c1_page"); ?>',
                    type: 'POST'
                },
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },

                    {
                        "data": [6],
                        "targets": -1,
                        "render": function(data, type, row, meta) {
                            return "<a href=" + base_image_url +
                                data +
                                " target='__BLANK'>Download</a>";

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
                            title: 'Caleg Berhasil ditambahkan'
                        });
                        $('#tambah-caleg').trigger("reset");
                        setTimeout(function() {
                            window.location.href =
                                '<?php echo site_url('MasterData/caleg'); ?>';
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
                                    '<?php echo site_url('MasterData/caleg'); ?>';
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