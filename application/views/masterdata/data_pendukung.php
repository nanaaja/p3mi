<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data
        <small>Pendukung</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-12'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Pendukung </h3>
                    <?php

                    //if ($this->session->userdata('jabatan') == 'relawan') {
                    //    $get_kec = $this->m_masterdata->getTpsDetail($this->session->userdata('id_tps'));
                    //    $id_kec = $get_kec[0]->id_kec;
					//	echo trim($id_kec);
                    //    if (trim($id_kec)!= "3603121") {
                    ?>
                            <!--<button class="btn btn-primary my-2 pull-right" data-toggle="modal" data-target="#add-pendukung"><i class="fa fa-plus"></i> Tambah Data</button> &nbsp;-->
                        <?php
                    //    }
                    //    
                    //}
					
					//if (($this->session->userdata('jabatan') == 'superadmin')) {
                        ?>
                            <!--<button class="btn btn-success my-2 pull-right mx-2" data-toggle="modal" data-target="#m_import" style="margin-right: 3px;"><i class="fa fa-upload"></i> Import Data</button> &nbsp;-->
                    <?php
                    //    }
                    ?>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="pendukung-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Pendukung</th>
                                        <th>Nama</th>
                                        <th>Nik</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Umur</th>
                                        <th>No HP</th>
                                        <th>Relawan</th>
                                        <th>Prov</th>
                                        <th>KabKota</th>
                                        <th>Kec</th>
                                        <th>Kel</th>
                                        <th>Tps</th>
                                        <!-- <th>No Rek</th>
                                        <th>Nama Bank</th>
                                        <th>Jenis Bayar</th>
                                        <th>KTP</th> -->
                                        <th>Status</th>
                                        <th>Fungsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col-->
    </div><!-- ./row -->

    <!-- Modal import data -->
    <div class="modal fade" id="m_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <form action="<?= site_url('ImportController/import_excel_pendukung'); ?>" method="post" enctype="multipart/form-data">
                        <h5 class="modal-title" id="exampleModalLabel">Import Pendukung</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <a href="<?php echo base_url('uploads/template_pendukung.xlsx'); ?>">Download Template Import </a><br><br>

                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" name="fileExcel">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class='btn btn-success' type="submit">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Import
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal tambah data -->
    <div class="modal fade add-pendukung" id="add-pendukung" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="label_tipe">Tambah</span> Pendukung</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="tambah-pendukung" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Pendukung</label>
                            <input type="hidden" class="form-control" name="id_pendukung">
                            <input type="hidden" class="form-control" name="tipe_form" value="add">
                            <input type="text" class="form-control" name="nama_pendukung" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik" placeholder="" minlength="16" maxlength="16" required>
                            <cite></cite>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                            <select class="form-control" name="jk" required>
                                <option value='L'>Laki-Laki</option>
                                <option value='P'>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Umur</label>
                            <input type="text" class="form-control" name="umur" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">No HP</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select class="form-control" style="width:100%" name="id_provinsi" readonly>
                                <!-- <option value=''>Pilih Provinsi</option> -->
                                <?php foreach ($data_tps as $r) { ?>
                                    <option value='<?= $r->id_prov; ?>'><?= $r->nama_prov; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kabupaten / Kota</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="id_kabupaten" name="id_kabupaten" readonly>
                            <?php foreach ($data_tps as $r) { ?>
                                    <option value='<?= $r->id_kab; ?>'><?= $r->nama_kab; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" id="id_kecamatan" name="id_kecamatan" readonly>
                                <?php foreach ($data_tps as $r) { ?>
                                        <option value='<?= $r->id_kec; ?>'><?= $r->nama_kec; ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_kelurahan" readonly>
                                <?php foreach ($data_tps as $r) { ?>
                                    <option value='<?= $r->id_kel; ?>'><?= $r->nama_kel; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tps</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_tps"  required>
                                <?php foreach ($data_tps as $r) { ?>
                                    <option value='<?= $r->id_tps; ?>'><?= $r->nama_tps; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Relawan</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="id_relawan" readonly>
                                <?php foreach ($data_relawan as $r) { ?>
                                    <option value='<?= $r->id_relawan; ?>'><?= $r->nama_relawan; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleFormControlInput1">No Rekening</label>
                            <input type="text" class="form-control" name="no_rek" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Bank</label>
                            <input type="text" class="form-control" name="nama_bank" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Bayar</label>
                            <select class="form-control js-example-basic-single" style="width:100%" name="jenis_bayar">
                                <option value='Cash'>Cash</option>
                                <option value='Transfer'>Transfer</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Upload KTP(Optional)</label>
                            <input type="file" accept="image/*" class="form-control" name="dokumen_ktp" placeholder="Upload KTP (optional)">
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleFormControlInput1">Upload Bukti</label>
                            <input type="file" accept="*" class="form-control" name="dokumen" placeholder="Upload Bukti (optional)">
                        </div> -->



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var base_image_url = '<?php echo base_url('uploads/foto/'); ?>'
                var role = '<?php echo $_SESSION['jabatan']; ?>';
				var idtpss = '<?php echo $id_data_tps; ?>';
                console.log(role)

                var table = $('#pendukung-table').DataTable({
                    "ajax": {
                        url: '<?php echo site_url("MasterData/pendukung_page"); ?>',
                        type: 'POST',
						data: {
                            "id_data_tps": idtpss
                        }
                    },
                    dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Data Pendukung',
                        text: 'Export ke Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] // Hanya kolom ke-0 sampai ke-3 yang diekspor
                        }
                    }],
                    "columnDefs": [{
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        },

                        {
                            "data": [0],
                            "targets": -1,
                            "render": function(data, type, row, meta) {
                                 if(role != 'viewer'){
                                    if(role == 'superadmin' ){
                                        //return "<button class='btn btn-primary btn-md edit-pendukung' id_pendukung=" + data + "  name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button>";
                                        return "<button class='btn btn-primary btn-md edit-pendukung' id_pendukung=" + data + "  name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button> <button type='button' class='btn btn-danger btn-md' name='hapus' id_pendukung=" +
                                        data + " onclick='edit(`" + data +
                                        "`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";
                                    }else{
                                        return "<button class='btn btn-primary btn-md edit-pendukung' id_pendukung=" + data + "  name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button>";
                                        // return "<button class='btn btn-primary btn-md edit-pendukung' id_pendukung=" + data + "  name='edit'><i class='fa fa-edit  text-white-50 mr-1'></i>  </button> <button type='button' class='btn btn-danger btn-md' name='hapus' id_pendukung=" +
                                        //     data + " onclick='edit(`" + data +
                                        //     "`)'><i class='fa fa-trash-o text-white-50 mr-1'></i>  </button>";
                                    }
                                 }else{
                                     return null;
                                 }
                            }
                        }, {
                            "defaultContent": "-",
                            "targets": "_all"
                        }
                    ]
                });

                $(document).on('click', '.add_data', function() {
                    $('#tambah-pendukung').trigger("reset");
                    $("input[name='tipe_form']").val('add');
                    $("#label_tipe").text('Tambah');
                });

                $(document).on('click', '.edit-pendukung', function() {
                    $('#add-pendukung').modal('show');
                    $("input[name='tipe_form']").val('edit');

                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/get_pendukung'); ?>',
                        data: {
                            "id_pendukung": $(this).attr('id_pendukung'),
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#label_tipe").text('Ubah');
                            $("input[name='id_pendukung']").val(data[0].id_pendukung)
                            $("input[name='nama_pendukung']").val(data[0].nama)
                            $("input[name='nik']").val(data[0].nik)
                            $("input[name='alamat']").val(data[0].alamat)
                            $("input[name='umur']").val(data[0].umur)
                            $("input[name='no_hp']").val(data[0].no_hp)
                            $("select[name='jk']").val(data[0].jk)
                            $("select[name='id_tps']").val(data[0].id_tps).trigger('change')
                            $("select[name='id_relawan']").val(data[0].id_relawan).trigger("change");
                            // $("input[name='no_rek']").val(data[0].norek)
                            // $("input[name='nama_bank']").val(data[0].nama_bank)
                            // $("select[name='jenis_bayar']").val(data[0].jenis_bayar)
                        },
                        error: function(request, status, error) {
                            console.log('Gagal ke Server')
                        }
                    });
                });
                // $(document).on('click', 'select[name="id_provinsi"]', function() {
                //     $.ajax({
                //         type: "POST",
                //         url: '<?php echo site_url('MasterData/get_kab_by_prov'); ?>',
                //         data: {
                //             id_prov: $(this).val()
                //         },
                //         success: function(data) {
                //             $("select[name='id_kabupaten']").html(data)

                //         },
                //         error: function(request, status, error) {
                //             console.log(request.responseText);

                //         }
                //     });
                // });

                // $(document).on('change', 'select[name="id_kabupaten"]', function() {
                //     $.ajax({
                //         type: "POST",
                //         url: '<?php echo site_url('MasterData/get_kec_by_kab'); ?>',
                //         data: {
                //             id_kabupaten: $(this).val()
                //         },
                //         success: function(data) {
                //             $("select[name='id_kecamatan']").html(data)

                //         },
                //         error: function(request, status, error) {
                //             console.log(request.responseText);

                //         }
                //     });
                // });

                // $(document).on('change', 'select[name="id_kecamatan"]', function() {

                //     $.ajax({
                //         type: "POST",
                //         url: '<?php echo site_url('MasterData/get_kel_by_kec'); ?>',
                //         data: {
                //             id_kecamatan: $(this).val()
                //         },
                //         success: function(data) {
                //             $("select[name='id_kelurahan']").html(data)

                //         },
                //         error: function(request, status, error) {
                //             console.log(request.responseText);

                //         }

                //     });

                // });


                // $(document).on('change', 'select[name="id_kelurahan"]', function() {
                //     $.ajax({
                //         type: "POST",
                //         url: '<?php echo site_url('MasterData/get_tps_by_kel'); ?>',
                //         data: {
                //             id_kelurahan: $(this).val()
                //         },
                //         success: function(data) {
                //             $("select[name='id_tps']").html(data)

                //         },
                //         error: function(request, status, error) {
                //             console.log(request.responseText);

                //         }

                //     });

                // });


                $('#tambah-pendukung').on('submit', function(event) {
                    event.preventDefault();
                    var len = $('#nik').val().length;
                    if (len < 16 && len > 16) {
                        this.submit();
                    }
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('MasterData/add_pendukung'); ?>',
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
                                title: 'Data Berhasil Disimpan'
                            });
                            $('#tambah-pendukung').trigger("reset");
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo site_url('MasterData/pendukung'); ?>';
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
                                title: 'Gagal menghubungkan Ke Server Nik Sudah Ada/Max 50 Pendukung'
                            })
                        }

                    });

                });

                $(document).on('click', '.add-pendukung', function() {
                    var id_po_produk = $(this).attr('id_po_produk');
                    $('#m_add_pendukung').modal('show');
                });

                var minLength = 16;
                var maxLength = 16;

                $('#nik').on('keydown keyup change', function(){
                    var char = $(this).val();
                    var charLength = $(this).val().length;
                    if(charLength < minLength){
                        $('cite').text('Length is short, minimum '+minLength+' required.');
                    }else if(charLength > maxLength){
                        $('cite').text('Length is not valid, maximum '+maxLength+' allowed.');
                        $(this).val(char.substring(0, maxLength));
                    }else{
                        $('cite').text('NIK is valid');
                    }
                });


            });



            function edit(id) {

                var id_pendukung = id;
                console.log(id_pendukung)
                Swal.fire({
                    title: 'Anda yakin hapus pendukung ini..?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url('MasterData/hapus_pendukung'); ?>',
                            data: {
                                id_pendukung: id_pendukung
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
                                    title: 'OK, Berhasil Dihapus'
                                });

                                setTimeout(function() {
                                    window.location.href =
                                        '<?php echo site_url('MasterData/pendukung'); ?>';
                                    window.clearTimeout();
                                }, 1000);

                            },
                            error: function(request, status, error) {
                                console.log('Gagal ke Server')


                            }

                        });
                    }
                    if (result.dismiss == "cancel") {
                        console.log('batal');
                    }

                });

            }
        </script>