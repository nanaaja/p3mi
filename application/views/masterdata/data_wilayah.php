<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-8'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Data Wilayah </h3> (<?php
                                                                $data_wilayah = '';
                                                                if ($_GET['level'] == 1) {
                                                                    echo $data_wilayah = 'Provinsi';
                                                                } elseif ($_GET['level'] == 2) {
                                                                    $data_wilayah = 'Provinsi ' . $detail_wilayah[0]->nama_prov;
                                                                    echo $data_wilayah;
                                                                } elseif ($_GET['level'] == 3) {
                                                                    $data_wilayah = 'Kabkota ' . $detail_wilayah[0]->nama_kab;

                                                                    echo $data_wilayah;
                                                                } elseif ($_GET['level'] == 4) {
                                                                    $data_wilayah = 'Kecamatan ' . $detail_wilayah[0]->nama_kec;

                                                                    echo $data_wilayah;
                                                                } ?>)

                </div><!-- /.box-header -->
                <div class="box-header mx-4">
                    <?php if ($_GET['level'] == 1) { ?>
                        <button class="btn btn-primary my-2 " data-toggle="modal" data-target="#add-wilayah"><i class="fa fa-plus"></i> Tambah Provinsi</button>
                    <?php } elseif ($_GET['level'] == 2) { ?>
                        <button class="btn btn-primary my-2 " data-toggle="modal" data-target="#add-wilayah"><i class="fa fa-plus"></i> Tambah Kabupaten</button>
                        &nbsp;
                        <a href="javascript:history.go(-1);" type="button" class="btn btn-danger  mx-3"><i class="fa fa-reply"></i> List Provinsi</button></a>
                    <?php
                    } elseif ($_GET['level'] == 3) { ?>
                        <button class="btn btn-primary my-2 " data-toggle="modal" data-target="#add-wilayah"><i class="fa fa-plus"></i> Tambah Kecamatan</button>
                        &nbsp;
                        <a href="javascript:history.go(-1);" type="button" class="btn btn-danger  mx-3"><i class="fa fa-reply"></i> List Kabupaten / Kota</button></a>
                    <?php
                    } elseif ($_GET['level'] == 4) {
                    ?>
                        <button class="btn btn-primary my-2 " data-toggle="modal" data-target="#add-wilayah"><i class="fa fa-plus"></i> Tambah Desa / Kelurahan</button>
                        &nbsp;
                        <a href="javascript:history.go(-1);" type="button" class="btn btn-danger  mx-3"><i class="fa fa-reply"></i> List Kecamatan</button></a>
                    <?php
                    }
                    ?>
                </div>
                <div class='box-body pad'>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>ID
                                        </th>
                                        <th><?php if ($_GET['level'] == 1) {
                                                echo  'Provinsi';
                                            } elseif ($_GET['level'] == 2) {
                                                echo 'Kabupaten / Kota';
                                            } elseif ($_GET['level'] == 3) {
                                                echo 'Kecamatan';
                                            } elseif ($_GET['level'] == 4) {
                                                echo 'Kelurahan';
                                            } ?></th>
                                        <th>
                                            <center>Fungsi
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($wilayah as $r) {
                                        $no++; ?>
                                        <tr> <?php
                                                if ($_GET['level'] == 1) { ?>
                                                <th>
                                                    <center><?php
                                                            if ($_GET['level'] == 1) {
                                                                echo  $r->id_prov;
                                                            } elseif ($_GET['level'] == 2) {
                                                                echo $r->id_kab;
                                                            } elseif ($_GET['level'] == 3) {
                                                                echo $r->id_kec;
                                                            } elseif ($_GET['level'] == 4) {
                                                                echo $r->id_kel;
                                                            } ?>
                                                </th>
                                                <th> <?= $r->nama_prov; ?></a></th>
                                                <th>
                                                    <center>
                                                        <?php
                                                        $link = site_url("MasterData/data_wilayah?level=2&id=" . $r->id_prov); ?> <a href="<?= $link; ?>" type="button" class="btn btn-success">Lihat Detail</a>
                                                        <button class='btn btn-primary btn-md edit-wilayah' id="<?= $r->id_prov; ?>"><i class='fa fa-edit  text-white-50 mr-1'></i> </button>
                                                        <button type="button" class="btn btn-danger btn-md hapus" id="<?= $r->id_prov; ?>" name="hapus"><i class="fa fa-trash-o text-white-50 mr-1"></i> </button>
                                                    <?php } elseif ($_GET['level'] == 2) { ?>
                                                <th>
                                                    <center><?php
                                                            if ($_GET['level'] == 1) {
                                                                echo  $r->id_prov;
                                                            } elseif ($_GET['level'] == 2) {
                                                                echo $r->id_kab;
                                                            } elseif ($_GET['level'] == 3) {
                                                                echo $r->id_kec;
                                                            } elseif ($_GET['level'] == 4) {
                                                                echo $r->id_kel;
                                                            } ?>
                                                </th>
                                                <th>
                                                    <center><?= $r->nama_kab; ?>
                                                </th>

                                                <th>
                                                    <?php
                                                    $link = site_url("MasterData/data_wilayah?level=3&id=" . $r->id_kab); ?> <a href="<?= $link; ?>" type="button" class="btn btn-success">Lihat Detail</a>
                                                    <button class='btn btn-primary btn-md edit-wilayah' id="<?= $r->id_kab; ?>"><i class='fa fa-edit  text-white-50 mr-1'></i> </button>
                                                    <button type="button" class="btn btn-danger btn-md hapus" id="<?= $r->id_kab; ?>" name="hapus"><i class="fa fa-trash-o text-white-50 mr-1"></i> </button>


                                                <?php
                                                } elseif ($_GET['level'] == 3) { ?>
                                                <th>
                                                    <center><?php
                                                            if ($_GET['level'] == 1) {
                                                                echo  $r->id_prov;
                                                            } elseif ($_GET['level'] == 2) {
                                                                echo $r->id_kab;
                                                            } elseif ($_GET['level'] == 3) {
                                                                echo $r->id_kec;
                                                            } elseif ($_GET['level'] == 4) {
                                                                echo $r->id_kel;
                                                            } ?>
                                                </th>
                                                <th>
                                                    <center><?= $r->nama_kec; ?>
                                                </th>

                                                <th>
                                                    <center>
                                                        <?php
                                                        $link = site_url("MasterData/data_wilayah?level=4&id=" . $r->id_kec); ?> <a href="<?= $link; ?>" type="button" class="btn btn-success">Lihat Detail</a>
                                                        <button class='btn btn-primary btn-md edit-wilayah' id="<?= $r->id_kec; ?>"><i class='fa fa-edit  text-white-50 mr-1'></i> </button>
                                                        <button type="button" class="btn btn-danger btn-md hapus" id="<?= $r->id_kec; ?>" name="hapus"><i class="fa fa-trash-o text-white-50 mr-1"></i> </button>


                                                    <?php
                                                } elseif ($_GET['level'] == 4) { ?>
                                                <th>
                                                    <center><?php
                                                            if ($_GET['level'] == 1) {
                                                                echo  $r->id_prov;
                                                            } elseif ($_GET['level'] == 2) {
                                                                echo $r->id_kab;
                                                            } elseif ($_GET['level'] == 3) {
                                                                echo $r->id_kec;
                                                            } elseif ($_GET['level'] == 4) {
                                                                echo $r->id_kel;
                                                            } ?>
                                                </th>
                                                <th>
                                                    <center><?= $r->nama_kel; ?>
                                                </th>

                                                <th>
                                                    <center>
                                                        <button class='btn btn-primary btn-md edit-wilayah' id="<?= $r->id_kel; ?>"><i class='fa fa-edit  text-white-50 mr-1'></i> </button>

                                                        <button type="button" class="btn btn-danger btn-md hapus" id="<?= $r->id_kel; ?>" name="hapus"><i class="fa fa-trash-o text-white-50 mr-1"></i> </button>


                                                </th>
                                            <?php } ?>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- /.box -->
        <!-- Modal tambah data -->
        <div class="modal fade add-wilayah" id="add-wilayah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span id="label_tipe">Tambah</span> <b><?php if ($_GET['level'] == 1) {
                                                                                                                    echo 'Provinsi';
                                                                                                                } elseif ($_GET['level'] == 2) {
                                                                                                                    echo 'Kabupaten / Kota';
                                                                                                                } elseif ($_GET['level'] == 3) {
                                                                                                                    echo 'Kecamatan';
                                                                                                                } elseif ($_GET['level'] == 4) {
                                                                                                                    echo 'Desa / Kelurahan';
                                                                                                                } ?></b>
                            di <?php
                                $data_wilayah = '';
                                if ($_GET['level'] == 1) {
                                    echo $data_wilayah = 'Provinsi';
                                } elseif ($_GET['level'] == 2) {
                                    $data_wilayah = 'Provinsi ' . $detail_wilayah[0]->nama_prov;
                                    echo $data_wilayah;
                                } elseif ($_GET['level'] == 3) {
                                    $data_wilayah = 'Kabkota ' . $detail_wilayah[0]->nama_kab;

                                    echo $data_wilayah;
                                } elseif ($_GET['level'] == 4) {
                                    $data_wilayah = 'Kecamatan ' . $detail_wilayah[0]->nama_kec;

                                    echo $data_wilayah;
                                } ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="tambah-wilayah" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">ID <span class="text-danger">(ID Tidak Bisa diubah setelah diinput)</span></label>
                                <input type="hidden" class="form-control" name="tipe_form" value="add">
                                <input type="hidden" class="form-control" name="level" value="<?= $_GET['level']; ?>">
                                <?php if ($_GET['level'] != 1) { ?>
                                    <input type="hidden" class="form-control" name="param" value="<?= $_GET['id']; ?>">
                                <?php } ?>
                                <input type="text" class="form-control" name="id" placeholder="" required maxlength="10">

                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nama <?php if ($_GET['level'] == 1) {
                                                                                echo 'Provinsi';
                                                                            } elseif ($_GET['level'] == 2) {
                                                                                echo 'Kabupaten / Kota';
                                                                            } elseif ($_GET['level'] == 3) {
                                                                                echo 'Kecamatan';
                                                                            } elseif ($_GET['level'] == 4) {
                                                                                echo 'Desa / Kelurahan';
                                                                            } ?></label>
                                <input type="text" class="form-control" name="nama_wilayah" placeholder="" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>

            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-2.2.3.min.js"></script>

            <script type="text/javascript" src="<?= base_url() ?>assets/js/chart.js"></script>


            <script type="text/javascript">
                $(document).ready(function() {
                    var table = $('#datatable').DataTable({
                        dom: 'Bfrtip', // Menampilkan tombol ekspor di atas tabel
                        buttons: [{
                            extend: 'excelHtml5',
                            title: 'Data Wilayah ' + '<?= $data_wilayah; ?>',
                            text: 'Export ke Excel',
                            exportOptions: {
                                columns: [0, 1, 2, ] // Hanya kolom ke-0 sampai ke-3 yang diekspor
                            }
                        }],
                    });



                    $(document).on('click', '.add_data', function() {
                        $('#tambah-wilayah').trigger("reset");
                        $("input[name='tipe_form']").val('add');
                        $("input[name='id']").prop('readonly', false);
                        $("#label_tipe").text('Tambah');
                    });

                    $(document).on('click', '.hapus', function() {
                        var id = $(this).attr('id');
                        hapus(id);
                    });

                    $(document).on('click', '.edit-wilayah', function() {
                        $('#add-wilayah').modal('show');
                        $("input[name='tipe_form']").val('edit');
                        $("input[name='id']").prop('readonly', true);

                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url('MasterData/get_wilayah'); ?>',
                            data: {
                                "id": $(this).attr('id'),
                                "level": $("input[name='level']").val()

                            },
                            dataType: "json",
                            success: function(data) {
                                $("#label_tipe").text('Ubah');
                                var level = $("input[name='level']").val();
                                if (level == "1") {
                                    $("input[name='id']").val(data[0].id_prov)
                                    $("input[name='nama_wilayah']").val(data[0].nama_prov)
                                } else if (level == "2") {
                                    $("input[name='id']").val(data[0].id_kab)
                                    $("input[name='nama_wilayah']").val(data[0].nama_kab)
                                } else if (level == "3") {
                                    $("input[name='id']").val(data[0].id_kec)
                                    $("input[name='nama_wilayah']").val(data[0].nama_kec)
                                } else if (level == "4") {
                                    $("input[name='id']").val(data[0].id_kel)
                                    $("input[name='nama_wilayah']").val(data[0].nama_kel)
                                }
                            },
                            error: function(request, status, error) {
                                console.log('Gagal ke Server')
                            }
                        });
                    });


                    $('#tambah-wilayah').on('submit', function(event) {
                        event.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url('MasterData/add_wilayah'); ?>',
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
                                $('#tambah-wilayah').trigger("reset");
                                setTimeout(function() {
                                    location.reload();
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
                                    title: 'Gagal menghubungkan Ke Server / ID Sudah Ada'
                                })
                            }

                        });

                    });
                });

                function hapus(ids) {

                    var id = ids;
                    Swal.fire({
                        title: 'Anda yakin hapus wilayah ini..?',
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
                                url: '<?php echo site_url('MasterData/hapus_wilayah'); ?>',
                                data: {
                                    id: id,
                                    "level": $("input[name='level']").val()

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
                                        location.reload();
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