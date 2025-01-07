<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Suara Calon</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Suara Paslon </h3>
                    <button class="btn btn-success my-2 pull-right mx-2" data-toggle="modal" data-target="#m_import" style="margin-right: 3px;"><i class="fa fa-upload"></i> Import Data</button> &nbsp;
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="caleg-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama Paslon</th>
                                        <th>Prov</th>
                                        <th>KabKota</th>
                                        <th>Kec</th>
                                        <th>Kel</th>
                                        <th>No Tps</th>
                                        <th>Suara</th>
                                        <th>Waktu Input</th>
                                        <th>Dokumen C1</th>
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
                    <form action="<?= site_url('ImportController/import_excel_suara'); ?>" method="post" enctype="multipart/form-data">
                        <h5 class="modal-title" id="exampleModalLabel">Import Relawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <a href="<?php echo base_url('uploads/template_suara.xlsx'); ?>">Download Template Import </a><br><br>

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

    <script type="text/javascript">
        $(document).ready(function() {
            var role = '<?php echo $_SESSION['jabatan']; ?>';
            var base_image_url = '<?php echo base_url('uploads/c1/'); ?>'
            var idtpss = '<?php echo $id_data_tps; ?>';

            var table = $('#caleg-table').DataTable({
                "ajax": {
                    url: '<?php echo site_url("Suara/suara_pileg_page"); ?>',
                    type: 'POST',
                    data: {
                            "id_data_tps": idtpss
                        }
                },
                dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data Suara Realcount',
                    text: 'Export ke Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8] // Hanya kolom ke-0 sampai ke-3 yang diekspor
                    }
                }],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }, {
                        "data": [9],
                        "targets": -1,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' href=" + base_image_url +
                                data +
                                " target='__BLANK'>Download</a><a href=<?php echo site_url('Suara/edit_suara/'); ?>" +
                                row[0] +
                                "> <button class='btn btn-primary btn-md' name='edit' title='Edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button></a> ";

                        }
                    }


                ]
            });
        });
    </script>