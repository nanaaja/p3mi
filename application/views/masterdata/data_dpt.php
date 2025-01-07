<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-5'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Setting Data DPT </h3> <br>
                    <small>Data Dpt untuk Pembanding Suara Dukungan</small>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="modal-body">
                        <form id="tambah-dpt" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Tipe Penggunaan</label>
                                <select class="form-control select2_instance" id="tipe_penggunaan" required name="tipe_penggunaan">
                                    <option value='2' <?php echo $dpt[0]->tipe == "2" ? 'selected' : ''; ?>>Pemilihan Gubernur</option>
                                    <option value='3' <?php echo $dpt[0]->tipe == "3" ? 'selected' : ''; ?>>Pemilihan Bupati / Walikota</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="tipe">Nama Provinsi </label>
                                <input type="hidden" class="form-control" name="id_dpt" value="<?= $dpt[0]->id_dpt; ?>">
                                <select class="form-control select2_instance" required name="nama_kabkota">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah Kecamatan</label>
                                <input type="text" class="form-control" name="jml_kec" placeholder="" value="<?= $dpt[0]->jml_kec; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah Kelurahan</label>
                                <input type="text" class="form-control" name="jml_kel" placeholder="" value="<?= $dpt[0]->jml_kel; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah TPS</label>
                                <input type="text" class="form-control" name="jml_tps" placeholder="" value="<?= $dpt[0]->jml_tps; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah DPT Laki-Laki</label>
                                <input type="text" class="form-control sum" name="jml_dpt_lk" placeholder="" value="<?= $dpt[0]->jml_dpt_lk; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah DPT Perempuan</label>
                                <input type="text" class="form-control sum" name="jml_dpt_p" placeholder="" value="<?= $dpt[0]->jml_dpt_p; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah DPT</label> &nbsp;<small class="btn-danger">&nbsp;( digunakan sebagai pembanding suara dukungan )&nbsp;</small>
                                <input type="text" class="form-control" name="jml_dpt" placeholder="" value="<?= (int)$dpt[0]->jml_dpt_lk + (int)$dpt[0]->jml_dpt_p; ?>" required readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan DPT</button>
                            <br>
                            <br>

                    </div>
                    </form>
                </div>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col-->

    <script type="text/javascript">
        $(document).ready(function() {
            var id_wil = '<?= $dpt[0]->nama_kabkota; ?>';

            $(".sum").on('keyup', function(event) {
                var dpt_lk = parseInt($("input[name='jml_dpt_lk']").val());
                var dpt_p = parseInt($("input[name='jml_dpt_p']").val());
                $("input[name='jml_dpt']").val(dpt_lk + dpt_p);
            });

            setTimeout(() => {
                $("#tipe_penggunaan").trigger('change');
            }, 500);

            $("#tipe_penggunaan").on('change', function(event) {
                var tipe = parseInt($(this).val());
                if (tipe == '2') {
                    $(".tipe").text('Nama Provinsi');
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_prov'); ?>',
                        success: function(data) {
                            $("select[name='nama_kabkota']").html(data)

                            setTimeout(() => {
                                $("select[name='nama_kabkota']").val(id_wil).change()
                            }, 300);

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }
                    });

                } else {
                    $(".tipe").text('Nama Kabupaten / Kota');
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_kab'); ?>',
                        success: function(data) {
                            $("select[name='nama_kabkota']").html(data)

                            setTimeout(() => {
                                $("select[name='nama_kabkota']").val(id_wil).change()
                            }, 300);

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }
                    });

                }
            });
            $('.select2_instance').select2();



            $('#tambah-dpt').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('MasterData/add_dpt'); ?>',
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
                        $('#tambah-dpt').trigger("reset");
                        setTimeout(function() {
                            window.location.href =
                                '<?php echo site_url('MasterData/dpt'); ?>';
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