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
              <div class="col-md-5">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Daerah</h3>
                    <hr>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php if ($this->session->userdata('jabatan') !== 'saksi') { ?>
                      <div class="row">
                        <div class="col-sm-12">
                          <!-- select -->
                          <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan">
                              <option value=''>Pilih Wilayah </option>
                              <?php foreach ($data_kelurahan as $r) { ?>
                                <option value='<?= $r->id_kel; ?>'><?= $r->nama_prov . ' / ' . $r->nama_kab . ' / ' . $r->nama_kec . ' / ' . $r->nama_kel; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>TPS</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_tps" required>
                            </select>
                          </div>
                        </div>
                      </div>
                    <?php } else { ?>
                      <div class="row">
                        <div class="col-sm-12">
                          <!-- select -->
                          <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan">
                              <option value='<?= $data_tps_saksi[0]->id_kel; ?>'> <?= $data_tps_saksi[0]->nama_prov . ' / ' . $data_tps_saksi[0]->nama_kab . ' / ' . $data_tps_saksi[0]->nama_kec . ' / ' . $data_tps_saksi[0]->nama_kel; ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- select -->
                          <div class="form-group">
                            <label>TPS</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_tps">
                              <option value='<?= $data_tps_saksi[0]->id_tps; ?>'> <?= $data_tps_saksi[0]->nama_tps; ?></option>
                            </select>
                            </select>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <hr>
                    <div class="row">
                      <div class="col-sm-8">
                        <!-- select -->
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Upload Berkas C1</label>
                          <input type="file" accept="image/*" class="form-control" name="dokumen" placeholder="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Card Kolom Kanan -->
              <div class="col-md-4">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Input Suara Paslon</h3>
                    <hr>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group row">
                      <?php foreach ($data_calon as $c) { ?>
                        <div class="col-sm-8">
                          <div class="form-group">
                            <label for="exampleFormControlSelect1"><?= $c->nama; ?> </label>
                            <input type="hidden" class="form-control" name="id_caleg[]" placeholder="" required value="<?= $c->id_caleg; ?>">
                            <input type="number" class="form-control suara_paslon" name="suara[]" placeholder="" value="0" required>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                    <?php if ($this->session->userdata('jabatan') === 'saksi') {
                      if ((int)$cek_terisi < 1) {  ?>
                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Simpan">
                      <?php  } else { ?>
                      <?php echo '<span class="badge badge-primary badge-xl" style="background-color:red">Data Suara di Tps ini Sudah diisi</span>';
                      } ?>
                    <?php } else { ?>
                      <input class="btn btn-success btn-sm" type="submit" name="submit" value="Simpan">
                    <?php } ?>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>

              <!-- Card Kolom Kanan -->
              <div class="col-md-3">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Total Suara</h3>
                    <hr>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-sm-8">
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Suara Sah </label>
                          <input class="form-control suara_sah" name="tot_suara_sah" placeholder="" value="0" readonly>
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Suara Tidak Sah </label>
                          <input type="number" class="form-control suara_tdk_sah" name="tot_suara_tdk_sah" placeholder="" value="0" required>
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Total</label>
                          <input type="number" class="form-control" name="total_suara" placeholder="" value="0" required readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
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

      $('#simpan_suara').one('submit', function(event) {
        event.preventDefault();
		$(this).find('input[type="submit"]').attr('disabled', 'disabled');
        $.ajax({
          type: "POST",
          url: '<?php echo site_url('Suara/add_suara'); ?>',
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
                '<?php echo site_url('Suara/suara'); ?>';
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
      $(document).on('keyup', '.suara_paslon,.suara_tdk_sah', function() {
        var tot_suara_sah = 0;
        var tot_suara_tdk_sah = $("input[name='tot_suara_tdk_sah']").val();
        $('.suara_paslon').each(function() {
          tot_suara_sah += parseInt($(this).val());
          console.log(parseInt($(this).val()));
        });

        $("input[name='tot_suara_sah']").val(tot_suara_sah);
        $("input[name='total_suara']").val(parseInt(tot_suara_sah) + parseInt(tot_suara_tdk_sah));

      });


      setTimeout(() => {
        $("select[name='id_provinsi']").trigger('change');
      }, 1000);


      $(document).on('change', 'select[name="id_provinsi"]', function() {
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




    });
  </script>