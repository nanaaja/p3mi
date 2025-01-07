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
              <div class='box box-info'>
                  <div class='box-header'>
                      <h3 class='box-title'>Edit Data 
                    </h3>
                  </div><!-- /.box-header -->
                  <div class='box-body pad'>
                      <div class="modal-body">
                        <form id="edit-district">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label> 
                            <input type="hidden" class="form-control" name="tipe_form" value="edit">
                            <input type="hidden" class="form-control" name="district_id" id="district_name"
                                      value="<?php echo $data_district[0]->district_id;?>">
                            <input type="text" class="form-control" name="district_name" id="district_name"    value="<?php echo $data_district[0]->dis_name;?>"placeholder="" required>
                            
                        </div>  
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" style="width:100%" name="country_id" id="country_id" required>
                                <option value=''>Choose Country</option>
                                <?php foreach ($data_country as $r) { ?>
                                    <option value='<?= $r->country_id; ?>' <?= $r->country_id == $data_district[0]->count_id ? 'selected' : ''; ?>><?= $r->country_name; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" id="district_status" name="district_status" required>
                                <option value='1' <?php echo $data_district[0]->dis_status == "1" ? 'selected' : ''; ?>>Aktif</option>
                                <option value='2' <?php echo $data_district[0]->dis_status == "2" ? 'selected' : ''; ?>>Non Aktif</option>
                            </select>
                        </div>
                              
                      </div>
                      <div class="modal-footer"> 
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                      </form>
                  </div>
              </div><!-- /.box -->
          </div><!-- /.col-->
      </div><!-- ./row -->

      <script>
      $(document).ready(function() {
          $('#edit-district').on('submit', function(event) {
              event.preventDefault();
              $.ajax({
                  type: "POST",
                  url: '<?php echo site_url('MasterData/add_district'); ?>',
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
                              '<?php echo site_url('MasterData/district');?>';
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

          $(document).on('click', 'select[name="id_provinsi"]', function() {
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
                            $("select[name='district_district']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }

                    });

                });


      })
      </script>