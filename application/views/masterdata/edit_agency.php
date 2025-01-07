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
                        <form id="edit-agency">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label> 
                            <input type="hidden" class="form-control" name="tipe_form" value="edit">
                            <input type="hidden" class="form-control" name="agency_id"
                                      value="<?php echo $data_agency[0]->agency_id;?>">
                            <input type="text" class="form-control" name="agency_name"   value="<?php echo $data_agency[0]->agency_name;?>"placeholder="" required>
                            
                        </div>  
                        <div class="form-group">
                            <label for="exampleFormControlInput1">License</label> 
                            <input type="text" class="form-control" name="agency_license"   value="<?php echo $data_agency[0]->agency_license;?>"placeholder="" required>
                        </div>  
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Address</label> 
                            <textarea class="form-control" name="agency_address" placeholder="" required><?php echo $data_agency[0]->agency_address;?></textarea>
                        </div> 
                        <div class="form-group">
                            <label>Provience</label>
                            <select class="form-control" style="width:100%" name="id_provinsi">
                                <option value=''>Pilih Provinsi</option>
                                <?php foreach ($data_provinsi as $r) { ?>
                                    <option value='<?= $r->id_prov; ?>' <?= $data_agency[0]->e_id_prov == $r->id_prov ? 'selected' : '';?>><?= $r->nama_prov; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="id_kabupaten" name="id_kabupaten">
                                <?php foreach ($data_kabupaten as $r) { ?>
                                    <option value='<?= $r->id_kab; ?>' <?= $data_agency[0]->d_id_kab == $r->id_kab ? 'selected' : '';?>><?= $r->nama_kab; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Subdistrict</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="id_kecamatan" name="id_kecamatan">
                                <?php foreach ($data_kecamatan as $r) { ?>
                                    <option value='<?= $r->id_kec; ?>' <?= $data_agency[0]->c_id_kec == $r->id_kec ? 'selected' : '';?>><?= $r->nama_kec; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>District</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="bagency_district" name="agency_district">
                                <?php foreach ($data_kelurahan as $r) { ?>
                                    <option value='<?= $r->id_kel; ?>' <?= $data_agency[0]->b_id_kel== $r->id_kel ? 'selected' : '';?>><?= $r->nama_kel; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" id="agency_status" name="agency_status" required>
                                <option value='1' <?php echo $data_agency[0]->agency_status == "1" ? 'selected' : ''; ?>>Aktif</option>
                                <option value='2' <?php echo $data_agency[0]->agency_status == "2" ? 'selected' : ''; ?>>Non Aktif</option>
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
          $('#edit-agency').on('submit', function(event) {
              event.preventDefault();
              $.ajax({
                  type: "POST",
                  url: '<?php echo site_url('MasterData/add_agency'); ?>',
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
                              '<?php echo site_url('MasterData/agency');?>';
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
                            $("select[name='agency_district']").html(data)

                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);

                        }

                    });

                });


      })
      </script>