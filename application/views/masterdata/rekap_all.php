 <!-- Content Header (Page header) -->
 <section class="content-header">
   <h1>
     Laporan
     <small>Rekap Suara</small>
   </h1>
 </section>

 <?php
  function tgl_new($tanggal)
  {
    $pecahkan = explode('-', $tanggal);
    return  $pecahkan[2] . '/' .  $pecahkan[1]  . '/' . $pecahkan[0];
  }  ?>
 <!-- Main content -->
 <section class="content">
   <div class='row'>
     <div class='col-md-12'>
       <div class="box box-primary">
         <div class="box-header">
           <h3 class="box-title">Filter Data Laporan</h3>
         </div>
         <div class="box-body">
           <div class="row">
             <form method="get" action="">

               <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">Tipe Suara</label>
                 <select class="form-control" name="tipe_suara" required>

                   <option value='1' <?php if (!empty($_GET)) {
                                        if ($_GET['tipe_suara'] == '1') {
                                          echo 'selected';
                                        } else {
                                          echo '';
                                        }
                                      };
                                      ?>>Caleg</option>
                   <option value='2' <?php if (!empty($_GET)) {
                                        if ($_GET['tipe_suara'] == '2') {
                                          echo 'selected';
                                        } else {
                                          echo '';
                                        }
                                      };
                                      ?>>Pemilu</option>

                 </select>
               </div>
               <!-- <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">Kelurahan</label>
                 <select class="form-control" name="kelurahan">
                   <option value=''>---- Semua ----</option>
                   <?php foreach ($data_kelurahan as $r) { ?>
                     <option value='<?= $r->id_kel; ?>'><?= $r->nama_kel; ?></option>
                   <?php } ?>

                 </select>
               </div>
               <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">TPS</label>
                 <select class="form-control" name="tps">
                   <option value=''>---- Semua ----</option>
                   <?php foreach ($data_tps as $r) { ?>
                     <option value='<?= $r->id_tps; ?>'><?= $r->nama_tps; ?></option>
                   <?php } ?>

                 </select>
               </div>

               <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">Kecamatan</label>
                 <select class="form-control" name="kecamatan">
                   <option value=''>---- Semua ----</option>
                   <?php foreach ($data_kecamatan as $r) { ?>
                     <option value='<?= $r->id_kec; ?>'><?= $r->nama_kec; ?></option>
                   <?php } ?>

                 </select>
               </div>
               <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">Dapil</label>
                 <select class="form-control" name="tps">
                   <option value=''>---- Semua ----</option>
                   <?php foreach ($data_kecamatan as $r) { ?>
                     <option value='<?= $r->id_kec; ?>'><?= $r->nama_kec; ?></option>
                   <?php } ?>

                 </select>
               </div> -->
               <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">Pengelompokan</label>
                 <select class="form-control js-example-basic-single" style="width:100%" name="kelompok">
                   <option value='1' <?php if (!empty($_GET)) {
                                        if ($_GET['kelompok'] == '1') {
                                          echo 'selected';
                                        } else {
                                          echo '';
                                        }
                                      };
                                      ?>>Partai</option>
                   <option value='2' <?php if (!empty($_GET)) {
                                        if ($_GET['kelompok'] == '2') {
                                          echo 'selected';
                                        } else {
                                          echo '';
                                        }
                                      };
                                      ?>>Tps</option>
                   <option value='3' <?php if (!empty($_GET)) {
                                        if ($_GET['kelompok'] == '3') {
                                          echo 'selected';
                                        } else {
                                          echo '';
                                        }
                                      };
                                      ?>>Kelurahan</option>
                   <option value='4      <?php if (!empty($_GET)) {
                                            if ($_GET['kelompok'] == '4') {
                                              echo 'selected';
                                            } else {
                                              echo '';
                                            }
                                          };
                                          ?>'>Kecamatan</option>
                 </select>
               </div>
               <div class="col-xs-4">
                 <label for="exampleFormControlSelect1">&nbsp;</label>
                 <button type="submit" class="btn btn-primary form-control" placeholder=".col-xs-4"> <i class="fa fa-eye"> </i> &nbsp;Tampilkan</button>
               </div>
               <div class="col-xs-2">
                 <label for="exampleFormControlSelect1">&nbsp;</label>

                 <button type="button" onclick="printDiv('printMe')" class="btn btn-success form-control" placeholder=".col-xs-4"> <i class="fa fa-print"> </i> &nbsp;Print</button>
               </div>
             </form>
           </div>
         </div><!-- /.box-body -->
       </div><!-- /.box -->
       <!-- Form Element sizes -->
       <div class="box box-primary" id='printMe' style="font-size: 14px;">
         <div class=" ">
           <div style="position: absolute; /*or fixed*/
    right: 0px;">

             <center><br><br><br><br><br>


               <!-- <?php if ($_POST != null) {
                      // echo $kelurahan != null ? $kelurahan[0]->nm_kelurahan : '';
                    }
                    ?></h5> -->

             </center>
           </div>
           <?php if (isset($_GET['tipe_suara'])) {
              if ($_GET['tipe_suara'] == '1') {
            ?> <center>
                 <h3> Rekap Data Suara Pileg</h3>
                 <?php if ($_GET['kelompok'] == '1') { ?>
                   <div class="box-body table-responsive no-padding">
                     <?php $no = 1; ?>
                     <table class="table table-bordered mt-2" style="margin-top:5px">
                       <tr>
                         <th style="text-align:center">Partai</th>
                         <th style="text-align:center">Suara Partai</th>
                         <?php
                          foreach ($data_caleg as $r) {
                          ?>
                           <th><?php echo $r->nama; ?></th>
                         <?php }
                          ?>
                       </tr>

                       <?php
                        foreach ($data_partai as $p) { ?>
                         <tr>
                           <td>
                             <?= $p->nama_partai; ?>
                           </td>
                           <td>
                             <?php
                              $query = "SELECT COALESCE(SUM(suara_partai),0) as dsp FROM data_suara WHERE id_partai = '" . $p->id_partai . "'";

                              $sql = $this->db->query($query);
                              $hasil2 = $sql->result();
                              echo $hasil2[0]->dsp;
                              ?>
                           </td>
                           <?php
                            foreach ($data_caleg as $r) {

                              $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara WHERE id_caleg = '" . $r->id_caleg . "' AND id_partai = '" . $p->id_partai . "'";

                              $sql = $this->db->query($query);
                              $hasil = $sql->result();
                            ?>

                             <td>
                               <?= $hasil[0]->ds; ?>
                             </td>

                           <?php } ?>
                         </tr>
                       <?php } ?>
                     </table>
                   </div><!-- /.box-body -->
                 <?php }

                  if ($_GET['kelompok'] == '2') { ?>
                   <div class="box-body table-responsive no-padding">
                     <?php $no = 1; ?>
                     <table class="table table-bordered mt-2" style="margin-top:5px">
                       <tr>
                         <th style="text-align:center">TPS</th>
                         <th style="text-align:center">Suara Partai</th>
                         <?php
                          foreach ($data_caleg as $r) {
                          ?>
                           <th><?php echo $r->nama; ?></th>
                         <?php }
                          ?>
                       </tr>

                       <?php
                        foreach ($data_tps as $p) { ?>
                         <tr>
                           <td>
                             <?= $p->nama_tps; ?>
                           </td>
                           <td>
                             <?php
                              $query = "SELECT COALESCE(SUM(suara_partai),0) as dsp FROM data_suara WHERE id_tps = '" . $p->id_tps . "' ";

                              $sql = $this->db->query($query);
                              $hasil2 = $sql->result();
                              echo $hasil2[0]->dsp;
                              ?>
                           </td>
                           <?php
                            foreach ($data_caleg as $r) {

                              $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara WHERE id_caleg = '" . $r->id_caleg . "' AND id_tps = '" . $p->id_tps . "'";

                              $sql = $this->db->query($query);
                              $hasil = $sql->result();
                            ?>

                             <td>
                               <?= $hasil[0]->ds; ?>
                             </td>

                           <?php } ?>
                         </tr>
                       <?php } ?>
                     </table>
                   </div><!-- /.box-body -->

                 <?php }
                  if ($_GET['kelompok'] == '3') { ?>
                   <div class="box-body table-responsive no-padding">
                     <?php $no = 1; ?>
                     <table class="table table-bordered mt-2" style="margin-top:5px">
                       <tr>
                         <th style="text-align:center">Kelurahan</th>
                         <th style="text-align:center">Suara Partai</th>
                         <?php
                          foreach ($data_caleg as $r) {
                          ?>
                           <th><?php echo $r->nama; ?></th>
                         <?php }
                          ?>
                       </tr>

                       <?php
                        foreach ($data_kelurahan as $p) { ?>
                         <tr>
                           <td>
                             <?= $p->nama_kel; ?>
                           </td>
                           <td>
                             <?php
                              $query = "SELECT COALESCE(SUM(suara_partai),0) as dsp FROM data_suara WHERE id_kel = '" . $p->id_kel . "' ";

                              $sql = $this->db->query($query);
                              $hasil2 = $sql->result();
                              echo $hasil2[0]->dsp;
                              ?>
                           </td>
                           <?php
                            foreach ($data_caleg as $r) {

                              $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara WHERE id_caleg = '" . $r->id_caleg . "' AND id_kel = '" . $p->id_kel . "'";

                              $sql = $this->db->query($query);
                              $hasil = $sql->result();
                            ?>

                             <td>
                               <?= $hasil[0]->ds; ?>
                             </td>

                           <?php } ?>
                         </tr>
                       <?php } ?>
                     </table>
                   </div><!-- /.box-body -->

                 <?php }
                  if ($_GET['kelompok'] == '4') { ?>
                   <div class="box-body table-responsive no-padding">
                     <?php $no = 1; ?>
                     <table class="table table-bordered mt-2" style="margin-top:5px">
                       <tr>
                         <th style="text-align:center">Kelurahan</th>
                         <th style="text-align:center">Suara Partai</th>
                         <?php
                          foreach ($data_caleg as $r) {
                          ?>
                           <th><?php echo $r->nama; ?></th>
                         <?php }
                          ?>
                       </tr>

                       <?php
                        foreach ($data_kecamatan as $p) { ?>
                         <tr>
                           <td>
                             <?= $p->nama_kec; ?>
                           </td>
                           <td>
                             <?php
                              $query = "SELECT COALESCE(SUM(suara_partai),0) as dsp FROM data_suara WHERE id_kec = '" . $p->id_kel . "' ";

                              $sql = $this->db->query($query);
                              $hasil2 = $sql->result();
                              echo $hasil2[0]->dsp;
                              ?>
                           </td>
                           <?php
                            foreach ($data_caleg as $r) {

                              $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara WHERE id_caleg = '" . $r->id_caleg . "' AND id_kec = '" . $p->id_kec . "'";

                              $sql = $this->db->query($query);
                              $hasil = $sql->result();
                            ?>

                             <td>
                               <?= $hasil[0]->ds; ?>
                             </td>

                           <?php } ?>
                         </tr>
                       <?php } ?>
                     </table>
                   </div><!-- /.box-body -->

                 <?php } ?>
               <?php } else {
                ?> <center>
                   <h3> Rekap Data Suara Pemilu</h3>
                   <?php
                    if ($_GET['kelompok'] == '1') { ?>

                     <div class="box-body table-responsive no-padding">
                       <?php $no = 1; ?>
                       <table class="table table-bordered mt-2" style="margin-top:5px">
                         <tr>
                           <th style="text-align:center">Partai</th>
                           <?php
                            foreach ($data_calegpres as $r) {
                            ?>
                             <th><?php echo $r->nama; ?></th>
                           <?php }
                            ?>
                         </tr>

                         <?php
                          foreach ($data_partai as $p) { ?>
                           <tr>
                             <td>
                               <?= $p->nama_partai; ?>
                             </td>

                             <?php
                              foreach ($data_calegpres as $r) {

                                $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara_pemilu JOIN data_caleg ON data_caleg.id_caleg = data_suara_pemilu.id_caleg WHERE data_suara_pemilu.id_caleg = '" . $r->id_caleg . "' AND data_caleg.id_partai = '" . $p->id_partai . "'";

                                $sql = $this->db->query($query);
                                $hasil = $sql->result();
                              ?>

                               <td>
                                 <?= $hasil[0]->ds; ?>
                               </td>

                             <?php } ?>
                           </tr>
                         <?php } ?>
                       </table>
                     </div><!-- /.box-body -->
                   <?php }

                    if ($_GET['kelompok'] == '2') { ?>
                     <div class="box-body table-responsive no-padding">
                       <?php $no = 1; ?>
                       <table class="table table-bordered mt-2" style="margin-top:5px">
                         <tr>
                           <th style="text-align:center">TPS</th>
                           <?php
                            foreach ($data_calegpres as $r) {
                            ?>
                             <th><?php echo $r->nama; ?></th>
                           <?php }
                            ?>
                         </tr>

                         <?php
                          foreach ($data_tps as $p) { ?>
                           <tr>
                             <td>
                               <?= $p->nama_tps; ?>
                             </td>

                             <?php
                              foreach ($data_calegpres as $r) {
                                $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara_pemilu WHERE id_caleg = '" . $r->id_caleg . "' AND id_tps = '" . $p->id_tps . "'";

                                $sql = $this->db->query($query);
                                $hasil = $sql->result();
                              ?>

                               <td>
                                 <?= $hasil[0]->ds; ?>
                               </td>

                             <?php } ?>
                           </tr>
                         <?php } ?>
                       </table>
                     </div><!-- /.box-body -->

                   <?php }
                    if ($_GET['kelompok'] == '3') { ?>
                     <div class="box-body table-responsive no-padding">
                       <?php $no = 1; ?>
                       <table class="table table-bordered mt-2" style="margin-top:5px">
                         <tr>
                           <th style="text-align:center">Kelurahan</th>
                           <?php
                            foreach ($data_calegpres as $r) {
                            ?>
                             <th><?php echo $r->nama; ?></th>
                           <?php }
                            ?>
                         </tr>

                         <?php
                          foreach ($data_kelurahan as $p) { ?>
                           <tr>
                             <td>
                               <?= $p->nama_kel; ?>
                             </td>

                             <?php
                              foreach ($data_calegpres as $r) {

                                $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara_pemilu WHERE id_caleg = '" . $r->id_caleg . "' AND id_kel = '" . $p->id_kel . "'";

                                $sql = $this->db->query($query);
                                $hasil = $sql->result();
                              ?>

                               <td>
                                 <?= $hasil[0]->ds; ?>
                               </td>

                             <?php } ?>
                           </tr>
                         <?php } ?>
                       </table>
                     </div><!-- /.box-body -->

                   <?php }
                    if ($_GET['kelompok'] == '4') { ?>
                     <div class="box-body table-responsive no-padding">
                       <?php $no = 1; ?>
                       <table class="table table-bordered mt-2" style="margin-top:5px">
                         <tr>
                           <th style="text-align:center">Kelurahan</th>
                           <?php
                            foreach ($data_calegpres as $r) {
                            ?>
                             <th><?php echo $r->nama; ?></th>
                           <?php }
                            ?>
                         </tr>

                         <?php
                          foreach ($data_kecamatan as $p) { ?>
                           <tr>
                             <td>
                               <?= $p->nama_kec; ?>
                             </td>

                             <?php
                              foreach ($data_calegpres as $r) {

                                $query = "SELECT COALESCE(SUM(suara),0) as ds FROM data_suara_pemilu WHERE id_caleg = '" . $r->id_caleg . "' AND id_kec = '" . $p->id_kec . "'";

                                $sql = $this->db->query($query);
                                $hasil = $sql->result();
                              ?>

                               <td>
                                 <?= $hasil[0]->ds; ?>
                               </td>

                             <?php } ?>
                           </tr>
                         <?php } ?>
                       </table>
                     </div><!-- /.box-body -->

                   <?php } ?>
                 <?php } ?>
               <?php } ?>

         </div><!-- /.box -->
       </div><!-- /.col-->
     </div><!-- ./row -->


     <script>
       function printDiv(divName) {
         var printContents = document.getElementById(divName).innerHTML;
         var originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;

         window.print();

         document.body.innerHTML = originalContents;

       }
       $(document).ready(function() {
         $('.yearpicker').yearpicker({
           // Initial Year 
           year: new Date().getFullYear(),
           // Start Year 
           startYear: null,
           // End Year 
           endYear: null,
           // Element tag 
           itemTag: 'li',
           // Default CSS classes 
           selectedClass: 'selected',
           disabledClass: 'disabled',
           hideClass: 'hide',
           // Custom template 
           template: `<div class="yearpicker-container">
 
	              <div class="yearpicker-header">
 
	                  <div class="yearpicker-prev" data-view="yearpicker-prev">&lsaquo;</div>
 
	                  <div class="yearpicker-current" data-view="yearpicker-current">SelectedYear</div>
 
	                  <div class="yearpicker-next" data-view="yearpicker-next">&rsaquo;</div>
 
	              </div>
 
	              <div class="yearpicker-body">
 
	                  <ul class="yearpicker-year" data-view="years">
 
	                  </ul>
 
	              </div>
 
	          </div> 
	  `,
         });
       });
     </script>
     <style>
       div {
         font-family: Arial;
       }

       h1 {
         font-family: Arial;
       }

       h2 {
         font-family: Arial;
       }

       h3 {
         font-family: Arial;
       }

       h4 {
         font-family: Arial;
       }

       h5 {
         font-family: Arial;
       }
     </style>