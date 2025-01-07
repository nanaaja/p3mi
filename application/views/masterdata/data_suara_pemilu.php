<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Suara Pemilu</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Suara Pemilu </h3>

                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="caleg-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Kelurahan</th>
                                        <th>Kecamatan</th>
                                        <th>No Tps</th>
                                        <th>Dapil</th>
                                        <th>Suara</th>
                                        <th>Waktu Input</th>
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

            var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'

            var table = $('#caleg-table').DataTable({
                "ajax": {
                    url: '<?php echo site_url("Suara/suara_pemilu_page"); ?>',
                    type: 'POST'
                },
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },


                ]
            });
        });
    </script>