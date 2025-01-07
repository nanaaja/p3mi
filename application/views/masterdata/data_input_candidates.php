<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add
    <small>Candidates</small>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class='row'>
    <div class='col-md-12'>
      <div class='box '>
        <div class='box-body pad'>
          <form id="simpan_candidates" method="POST">
            <div class="row">
              <div class="col-md-5">
                <!-- general form elements disabled -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Add Candidates</h3>
                    <hr>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php if ($this->session->userdata('jabatan') !== 'super') { ?>
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="exampleFormControlInput1">Name</label>
                              <input type="text" class="form-control" id="candidates_name" name="candidates_name" placeholder="SUHERMAN" required>
                              <input type="hidden" class="form-control" name="tipe_form" value="add">
                          </div>
                          <div class="form-group">
                              <label for="exampleFormControlInput1">NIK</label>
                              <input type="number" class="form-control" id="candidates_nik" name="candidates_nik" placeholder="367012344440002" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleFormControlSelect1">Gender</label>
                              <select class="form-control" id="candidates_gender" name="candidates_gender" required>
                                  <option value='L'>Male</option>
                                  <option value='P'>Female</option>
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Place Of Birth</label>
                            <input type="text" class="form-control" id="candidates_pob" name="candidates_pob" placeholder="Kota Tangerang" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleFormControlInput1">Date Of Birth</label>
                              <input type="date" class="form-control" id="candidates_dob" name="candidates_dob" placeholder="12/01/1994" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleFormControlInput1">Address</label>
                              <textarea class="form-control" id="candidates_address" name="candidates_address" placeholder="JL ABC"  required></textarea>
                          </div>
                          <div class="form-group">
                            <label>Provience</label>
                            <select class="form-control" style="width:100%" name="id_provinsi" required>
                                <option value=''>Choose Provience</option>
                                <?php foreach ($data_provinsi as $r) { ?>
                                    <option value='<?= $r->id_prov; ?>'><?= $r->nama_prov; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <label>City</label>
                              <select class="form-control js-example-basic-single" style="width:100%" id="id_kabupaten" name="id_kabupaten" required>
                                  <?php foreach ($data_kabupaten as $r) { ?>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Subdistrict</label>
                              <select class="form-control js-example-basic-single" style="width:100%" id="id_kecamatan" name="id_kecamatan" required>
                                  <?php foreach ($data_kecamatan as $r) { ?>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>District</label>
                              <select class="form-control js-example-basic-single" style="width:100%" id="candidates_district" name="candidates_district" required>
                                  <?php foreach ($data_kelurahan as $r) { ?>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Agency</label>
                              <select class="form-control" style="width:100%" name="agency_id" required>
                                  <option value=''>Choose Agency</option>
                                  <?php foreach ($data_agency as $r) { ?>
                                      <option value='<?= $r->agency_id; ?>'><?= $r->agency_name; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Grant</label>
                            <select class="form-control" style="width:100%" name="grant_id" id="grant_id" required>
                                <option value=''>Choose Grant</option>
                                <?php foreach ($data_grant as $r) { ?>
                                    <option value='<?= $r->grant_id ; ?>'><?= $r->grant_name; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleFormControlSelect1">Country</label>
                              <select class="form-control" style="width:100%" name="country_id" id="country_id" required>
                                  <option value=''>Choose Country</option>
                                  <?php foreach ($data_country as $r) { ?>
                                      <option value='<?= $r->country_id ; ?>'><?= $r->country_name; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Country Area</label>
                              <select class="form-control js-example-basic-single" style="width:100%" id="district_area" name="district_area" required>
                                  <?php foreach ($data_kabupaten as $r) { ?>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Upload Photo</label>
                            <input type="file" accept="image/*" class="form-control" name="dokumen" placeholder="" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleFormControlSelect1">Status</label>
                              <select class="form-control" id="candidates_status" name="candidates_status" required>
                                  <option value='1'>Aktif</option>
                                  <option value='2'>Non Aktif</option>
                              </select>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                        <!-- Card Kolom Kanan -->
                      <div class="col-md-4">
                        <!-- general form elements disabled -->
                        <div class="card card-primary">
                          <!-- /.card-header -->
                          <div class="card-body">

                            <?php if ($this->session->userdata('jabatan') === 'superadmin') { ?>
                                <input class="btn btn-success btn-sm" type="submit" name="submit" value="Simpan">

                            <?php } else { ?>
                              <input class="btn btn-success btn-sm" type="submit" name="submit" value="Simpan">
                            <?php } ?>
                          </div>
                          <!-- /.card-body -->
                        </div>
                      </div>
                  </div>
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

      $('#simpan_candidates').one('submit', function(event) {
        event.preventDefault();
		$(this).find('input[type="submit"]').attr('disabled', 'disabled');
        $.ajax({
          type: "POST",
          url: '<?php echo site_url('masterdata/add_candidates'); ?>',
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
              title: 'candidates Berhasil disimpan'
            });
            $('#tambah-caleg').trigger("reset");
            setTimeout(function() {
              window.location.href =
                '<?php echo site_url('masterdata/candidates'); ?>';
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
      $(document).on('keyup', '.candidates_paslon,.candidates_tdk_sah', function() {
        var tot_candidates_sah = 0;
        var tot_candidates_tdk_sah = $("input[name='tot_candidates_tdk_sah']").val();
        $('.candidates_paslon').each(function() {
          tot_candidates_sah += parseInt($(this).val());
          console.log(parseInt($(this).val()));
        });

        $("input[name='tot_candidates_sah']").val(tot_candidates_sah);
        $("input[name='total_candidates']").val(parseInt(tot_candidates_sah) + parseInt(tot_candidates_tdk_sah));

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
            $("select[name='candidates_district']").html(data)

          },
          error: function(request, status, error) {
            console.log(request.responseText);

          }

        });

      });

      $(document).on('click', 'select[name="country_id"]', function() {
          $.ajax({
              type: "POST",
              url: '<?php echo site_url('MasterData/get_district_by_countryid'); ?>',
              data: {
                  country_id: $(this).val()
              },
              success: function(data) {
                  $("select[name='district_area']").html(data)

              },
              error: function(request, status, error) {
                  console.log(request.responseText);

              }
          });
      });


      // $(document).on('change', 'select[name="id_kelurahan"]', function() {
      //   $.ajax({
      //     type: "POST",
      //     url: '<?php echo site_url('MasterData/get_tps_by_kel'); ?>',
      //     data: {
      //       id_kelurahan: $(this).val()
      //     },
      //     success: function(data) {
      //       $("select[name='id_tps']").html(data)

      //     },
      //     error: function(request, status, error) {
      //       console.log(request.responseText);

      //     }

      //   });

      // });




    });
  </script>