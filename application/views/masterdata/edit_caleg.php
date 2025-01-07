  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
          MasterData
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
                          <form id="tambah-kriteria">
                              <div class="form-group">
                                  <label for="exampleFormControlInput1">Nama</label>
                                  <input type="hidden" class="form-control" name="tipe_form" value="edit">
                                  <input type="hidden" class="form-control" name="id_caleg" value="<?php echo $data_caleg[0]->id_caleg; ?>">
                                  <input type="text" class="form-control" name="nama" placeholder="" required value="<?php echo $data_caleg[0]->nama; ?>">
                              </div>

                              <div class="form-group">
                                  <label for="exampleFormControlInput1">No Urut</label>
                                  <input type="text" class="form-control" name="no_urut" value="<?php echo $data_caleg[0]->no_urut; ?>" placeholder="" required>
                              </div>

                            <!-- <div class="form-group">
                                <label for="exampleFormControlSelect1">Partai</label>
                                <select class="form-control js-example-basic-single" style="width:100%" name="id_partai" required>
                                    <?php foreach ($data_partai as $r) { ?>
                                        <option value='<?= $r->id_partai; ?>' <?= $data_caleg[0]->id_partai == $r->id_partai ? 'selected' : ''; ?>><?= $r->nama_partai; ?></option>
                                    <?php } ?>
                                </select>
                            </div> -->

                              <div class="form-group">
                                  <label for="exampleFormControlSelect1">Kota</label>
                                  <select class="form-control js-example-basic-single" style="width:100%" name="id_kab" required>
                                      <?php foreach ($data_kota as $r) { ?>
                                          <option value='<?= $r->id_kab; ?>' <?= $data_caleg[0]->id_kab == $r->id_kab ? 'selected' : ''; ?>><?= $r->nama_kab; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>

                              <div class="form-group">
                                  <label for="exampleFormControlInput1">Photo</label>
                                  <input type="file" accept="image/*" class="form-control" name="image" placeholder="">
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
              $('#tambah-kriteria').on('submit', function(event) {
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
                              title: 'Data Berhasil diupdate'
                          });
                          setTimeout(function() {
                              window.location.href =
                                  '<?php echo site_url('MasterData/paslon'); ?>';
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

              })


          })
      </script>