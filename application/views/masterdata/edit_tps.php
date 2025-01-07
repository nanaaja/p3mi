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
                          <form id="tambah-kriteria">
                              <div class="form-group">
                                  <label for="exampleFormControlInput1">No TPS</label>
                                  <input type="hidden" class="form-control" name="tipe_form" value="edit">
                                  <input type="hidden" class="form-control" name="id_tps"
                                      value="<?php echo $data_tps[0]->id_tps;?>">
                                  <input type="text" class="form-control" name="no_tps" placeholder="" required
                                      value="<?php echo $data_tps[0]->no_tps;?>" >
                              </div>
                              
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama TPS</label> 
                            <input type="text" class="form-control" name="nama_tps"   value="<?php echo $data_tps[0]->nama_tps;?>"placeholder="" required>
                        </div>  
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Alamat</label> 
                            <input type="text" class="form-control" name="alamat"   value="<?php echo $data_tps[0]->alamat;?>"placeholder="" required>
                        </div>  
                        <div class="form-group">
                            <label for="exampleFormControlInput1">DPT</label> 
                            <input type="text" class="form-control" name="dpt"   value="<?php echo $data_tps[0]->dpt;?>"placeholder="" required>
                        </div> 
                       
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kelurahan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan" required>
                                <?php foreach($data_kelurahan as $r){?>
                                <option value='<?= $r->id_kel;?>' <?= $data_tps[0]->id_kel == $r->id_kel ? 'selected' : '';?>><?= $r->nama_kel;?></option> 
                                <?php } ?>
                            </select>
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
                  url: '<?php echo site_url('MasterData/add_tps'); ?>',
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
                              '<?php echo site_url('MasterData/tps');?>';
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