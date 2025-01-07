<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Suara
    <small>Input Suara</small>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class='row'>
    <div class='col-md-12'>
      <div class='box '>
        <div class='box-body pad'>
          <form id="simpan_suara" method="POST">
            <div class="row">
              <div class="col-md-3">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Daerah</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- select -->
                        <div class="form-group">
                          <label>Kecamatan</label>
                          <select class="form-control js-example-basic-single" style="width:100%" id="id_kecamatan" name="id_kecamatan">
                            <?php foreach ($data_kecamatan as $r) { ?>
                              <option value='<?= $r->id_kec; ?>'><?= $r->nama_kec; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Dapil</label>
                          <select class="form-control js-example-basic-single" style="width:100%" id="id_dapil" name="id_dapil">
                            <?php foreach ($data_dapil as $r) { ?>
                              <option value='<?= $r->id_dapil; ?>'><?= $r->nama_dapil; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- select -->
                        <div class="form-group">
                          <label>Kelurahan</label>
                          <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan">
                            <?php foreach ($data_kelurahan as $r) { ?>
                              <option value='<?= $r->id_kel; ?>'><?= $r->nama_kel; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- select -->
                        <div class="form-group">
                          <label>TPS</label>
                          <select class="form-control js-example-basic-single" style="width:100%" name="id_tps" required>
                            <?php foreach ($data_tps as $r) { ?>
                              <option value='<?= $r->id_tps; ?>'><?= $r->nama_tps; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Card Kolom Kanan -->
              <div class="col-md-9">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Input Suara Pemilu</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group row">


                      <?php foreach ($data_caleg as $c) { ?>
                        <div class="col-sm-8">
                          <div class="form-group">
                            <label for="exampleFormControlSelect1"><?= $c->nama; ?></label>
                            <input type="hidden" class="form-control" name="id_caleg[]" placeholder="" required value="<?= $c->id_caleg; ?>">
                            <input type="number" class="form-control" name="suara_caleg[]" placeholder="" required>

                          </div>
                        </div>
                      <?php } ?>
                    </div>
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Simpan">
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.box -->
    </div><!-- /.col-->
  </div><!-- ./row -->



  <script type="text/javascript">
    $(document).ready(function() {
      var role = '<?php echo $_SESSION['jabatan']; ?>';


      $('#simpan_suara').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: '<?php echo site_url('Suara/add_suara_pemilu'); ?>',
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
              title: 'Suara Berhasil disimpan'
            });
            $('#tambah-caleg').trigger("reset");
            setTimeout(function() {
              window.location.href =
                '<?php echo site_url('Suara/suara_pemilu'); ?>';
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


      setTimeout(() => {
        $("select[name='id_kecamatan']").trigger('change');
      }, 1000);
      $(document).on('change', 'select[name="id_kecamatan"]', function() {

        $.ajax({
          type: "POST",
          url: '<?php echo site_url('MasterData/get_kec_by_kel'); ?>',
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



    });
  </script>