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
                                  <input type="hidden" class="form-control" name="id_dapil" value="<?php echo $data_dapil[0]->id_dapil; ?>">
                                  <input type="text" class="form-control" name="nama_dapil" placeholder="" required value="<?php echo $data_dapil[0]->nama_dapil; ?>">
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
                      url: '<?php echo site_url('MasterData/add_dapil'); ?>',
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
                          $('#tambah-kriteria').trigger("reset");
                          setTimeout(function() {
                              window.location.href =
                                  '<?php echo site_url('MasterData/dapil'); ?>';
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