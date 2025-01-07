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
                      <h3 class='box-title'>Edit User</h3>
                  </div><!-- /.box-header -->
                  <div class='box-body pad'>
                      <div class="modal-body">
                          <form id="tambah-pengguna">
                              <div class="form-group">
                                  <label for="exampleFormControlInput1">Username</label>
                                  <input type="hidden" class="form-control" id="tipe_form" value="edit">
                                  <input type="hidden" class="form-control" id="id_user" value="<?php echo $data_pengguna[0]->id_user; ?>">
                                  <input type="text" class="form-control" id="username" placeholder="" value="<?php echo $data_pengguna[0]->username; ?>" required>
                              </div>
                              <div class="form-group">
                                  <label for="exampleFormControlInput1">Password</label>
                                  <input type="password" class="form-control" id="password" placeholder="Kosongkan, jika tidak ada perubahan" value="">
                              </div>
                              <div class="form-group">
                                  <label for="exampleFormControlSelect1">Jabatan</label>
                                  <select class="form-control" id="grant">
                                      <?php if ($this->session->userdata('jabatan') == 'superadmin') { ?>
                                          <option value='superadmin' <?php echo $data_pengguna[0]->jabatan == "superadmin" ? 'selected' : ''; ?>>Super Admin
                                          </option>
                                          <option value='p3mi' <?php echo $data_pengguna[0]->jabatan == "p3mi" ? 'selected' : ''; ?>>P3MI
                                          </option>
										  <option value='blh' <?php echo $data_pengguna[0]->jabatan == "blh" ? 'selected' : ''; ?>>BLH
                                          </option>
                                          <option value='lps' <?php echo $data_pengguna[0]->jabatan == "lps" ? 'selected' : ''; ?>>LPS
                                          </option>
                                          <option value='sarkes' <?php echo $data_pengguna[0]->jabatan == "sarkes" ? 'selected' : ''; ?>>Sarkes
                                          </option>
                                          <option value='agency' <?php echo $data_pengguna[0]->jabatan == "agency" ? 'selected' : ''; ?>>Agency
                                          </option>
                                      <?php } ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="exampleFormControlInput1">Name</label>
                                  <input type="text" class="form-control" id="name" placeholder="" value="<?php echo $data_pengguna[0]->nama; ?>" required>
                              </div>
                              <div class="form-group">
                                  <label for="exampleFormControlSelect1">Status</label>
                                  <select class="form-control" id="status" required>
                                      <option value='1' <?php echo $data_pengguna[0]->status == "1" ? 'selected' : ''; ?>>Aktif</option>
                                      <option value='2' <?php echo $data_pengguna[0]->status == "2" ? 'selected' : ''; ?>>Non Aktif</option>
                                  </select>
                              </div>
                              
                      </div>
                      <div class="modal-footer">

                          <a href="<?php echo site_url('MasterData/pengguna'); ?>"> <button type="button" class="btn btn-secondary">Back</button></a>
                          <button type="submit" class="btn btn-primary">Save User</button>
                      </div>
                      </form>
                  </div>
              </div><!-- /.box -->
          </div><!-- /.col-->
      </div><!-- ./row -->

      <script>
          $(document).ready(function() {
              var sel = '<?php echo $data_pengguna[0]->id_tps; ?>';
              setTimeout(() => {
                  $("select[name='id_kelurahan']").trigger("change");
                  setTimeout(() => {
                      $("select[name='id_tps']").val(sel).trigger("change");
                  }, 200);
              }, 300);

              $('#tambah-pengguna').on('submit', function(event) {
                  event.preventDefault();
                  $.ajax({
                      type: "POST",
                      url: '<?php echo site_url('MasterData/add_pengguna'); ?>',
                      data: {
                          tipe_form: $('#tipe_form').val(),
                          id_user: $('#id_user').val(),
                          name: $('#name').val(),
                          username: $('#username').val(),
                          password: $('#password').val(),
                          grant: $('#grant').val(),
                          status: $('#status').val(),

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
                              title: 'Pengguna Berhasil diupdate'
                          });
                          $('#tambah-pengguna').trigger("reset");
                          setTimeout(function() {
                              window.location.href =
                                  '<?php echo site_url('MasterData/pengguna'); ?>';
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