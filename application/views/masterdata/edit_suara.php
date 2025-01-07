  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
          Suara
      </h1>
  </section>

  <!-- Main content -->
  <section class="content">
      <div class='row'>
          <div class='col-md-12'>
              <div class='box '>
                  <div class='box-header'>
                      <h3 class='box-title'>Edit Data
                      </h3>
                  </div><!-- /.box-header -->
                  <div class='box-body pad'>
                      <div class="modal-body">
                          <form id="simpan_suara" method="POST">
                              <div class="form-group">
                                  <label>Kelurahan</label>
                                  <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan">
                                      <option value=''>Pilih Wilayah </option>
                                      <?php foreach ($data_kelurahan as $r) { ?>
                                          <option value='<?= $r->id_kel; ?>' <?= $r->id_kel == $data_suara_join[0]->id_kel ? 'selected' : ''; ?>><?= $r->nama_prov . ' / ' . $r->nama_kab . ' / ' . $r->nama_kec . ' / ' . $r->nama_kel; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                              <div class="row">
                                  <div class="col-sm-6">
                                      <!-- select -->
                                      <div class="form-group">
                                          <label>TPS</label>
                                          <select class="form-control js-example-basic-single" style="width:100%" name="id_tps" required>
                                              <?php foreach ($data_tps as $r) { ?>
                                                  <option value='<?= $r->id_tps; ?>' <?= $r->id_tps == $data_suara_join[0]->id_tps ? 'selected' : ''; ?>><?= $r->nama_tps; ?></option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label>Paslon</label>
                                  <select class="form-control js-example-basic-single" style="width:100%" name="id_caleg">
                                      <option value=''>Pilih Paslon </option>
                                      <?php foreach ($data_calon as $r) { ?>
                                          <option value='<?= $r->id_caleg; ?>' <?= $r->id_caleg == $data_suara_join[0]->id_caleg ? 'selected' : ''; ?>><?= $r->nama; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="exampleFormControlInput1">Suara</label>
                                  <input type="hidden" class="form-control" name="tipe_form" value="edit">
                                  <input type="hidden" class="form-control" name="id_suara" value="<?php echo $data_suara[0]->id_suara; ?>">
                                  <input type="text" class="form-control" name="suara" placeholder="" required value="<?php echo $data_suara[0]->suara; ?>">
                              </div>


                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                      </form>
                  </div>
              </div><!-- /.box -->
          </div><!-- /.col-->
      </div><!-- ./row -->

      <script>
          $(document).ready(function() {
              $('#simpan_suara').on('submit', function(event) {
                  event.preventDefault();
                  $.ajax({
                      type: "POST",
                      url: '<?php echo site_url('Suara/update_suara'); ?>',
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
                              title: 'Suara Berhasil Update'
                          });
                          setTimeout(function() {
                              window.location.href =
                                  '<?php echo site_url('Suara/data_suara'); ?>';
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


          })
      </script>