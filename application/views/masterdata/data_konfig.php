<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-5'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Config Application</h3> <br>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="modal-body">
                        <form id="tambah-konfig" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Application Name</label>
                                <input type="hidden" class="form-control" name="id_konfig" value="<?= $konfig[0]->id_konfig; ?>">
                                <input type="text" class="form-control" name="nama_apk" placeholder="" value="<?= $konfig[0]->nama_apk; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Config</button>
                    </div>
                    </form>
                </div>
            </div>
        </div><!-- /.box -->

    </div><!-- /.col-->
    </div><!-- ./row -->

    <script type="text/javascript">
        $('.select2_instance').select2();
        setTimeout(() => {

            $('.select2_instance').trigger('change');
        }, 400);

        $(document).ready(function() {
            $('#tambah-konfig').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('MasterData/add_konfig'); ?>',
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
                        $('#tambah-konfig').trigger("reset");
                        setTimeout(function() {
                            window.location.href =
                                '<?php echo site_url('MasterData/konfig'); ?>';
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

        });
    </script>