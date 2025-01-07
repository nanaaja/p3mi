<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class='row'>
        <div class='col-md-5'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Grafik Relawan </h3> (<?php
                                                                $data_wilayah = '';
                                                                if ($_GET['level'] == 1) {
                                                                    echo $data_wilayah = 'Semua Provinsi';
                                                                } elseif ($_GET['level'] == 2) {
                                                                    $data_wilayah = 'Provinsi ' . $detail_wilayah[0]->nama_prov;
                                                                    echo $data_wilayah;
                                                                } elseif ($_GET['level'] == 3) {
                                                                    $data_wilayah = $detail_wilayah[0]->nama_kab;

                                                                    echo $data_wilayah;
                                                                } elseif ($_GET['level'] == 4) {
                                                                    $data_wilayah = 'Kecamatan ' . $detail_wilayah[0]->nama_kec;

                                                                    echo $data_wilayah;
                                                                } ?>)

                </div><!-- /.box-header -->
                <div class="box-header mx-4">
                    <?php if ($_GET['level'] == 1) {
                        echo  '';
                    } elseif ($_GET['level'] == 2) { ?>
                        <a href="javascript:history.go(-1);" type="button" class="btn btn-danger pull-right mx-3"><i class="fa fa-reply"></i> List Provinsi</button></a>
                    <?php
                    } elseif ($_GET['level'] == 3) { ?>
                        <a href="javascript:history.go(-1);" type="button" class="btn btn-danger pull-right mx-3"><i class="fa fa-reply"></i> List Kabupaten / Kota</button></a>
                    <?php
                    } elseif ($_GET['level'] == 4) {
                    ?>

                        <a href="javascript:history.go(-1);" type="button" class="btn btn-danger pull-right mx-3"><i class="fa fa-reply"></i> List Kecamatan</button></a>
                    <?php
                    }
                    ?>
                </div>
                <div class='box-body pad'>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="caleg-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No
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
                                            <center>Jumlah
                                        </th>
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
                                                    <center><?= $no; ?>
                                                </th>
                                                <th><?= $r->nama_prov; ?></th>
                                                <th>
                                                    <center><?= $this->m_masterdata->jml_relawan_per($r->id_prov, 1); ?>
                                                </th>
                                                <th>
                                                    <?php
                                                    $link = site_url("MasterData/grafik_rel_per_wil?level=2&id=" . $r->id_prov); ?> <a href="<?= $link; ?>" type="button" class="btn btn-primary">Lihat Detail</button>
                                                    <?php } elseif ($_GET['level'] == 2) { ?>
                                                <th>
                                                    <center><?= $no; ?>
                                                </th>
                                                <th>
                                                    <center><?= $r->nama_kab; ?>
                                                </th>
                                                <th>
                                                    <center><?= $this->m_masterdata->jml_relawan_per($r->id_kab, 2); ?>
                                                </th>
                                                <th>
                                                    <?php
                                                    $link = site_url("MasterData/grafik_rel_per_wil?level=3&id=" . $r->id_kab); ?> <a href="<?= $link; ?>" type="button" class="btn btn-primary">Lihat Detail</button>
                                                    <?php
                                                } elseif ($_GET['level'] == 3) { ?>
                                                <th>
                                                    <center><?= $no; ?>
                                                </th>
                                                <th>
                                                    <center><?= $r->nama_kec; ?>
                                                </th>
                                                <th>
                                                    <center><?= $this->m_masterdata->jml_relawan_per($r->id_kec, 3); ?>
                                                </th>
                                                <th>
                                                    <center>
                                                        <?php
                                                        $link = site_url("MasterData/grafik_rel_per_wil?level=4&id=" . $r->id_kec); ?> <a href="<?= $link; ?>" type="button" class="btn btn-primary">Lihat Detail</button>
                                                        <?php
                                                    } elseif ($_GET['level'] == 4) { ?>
                                                <th>
                                                    <center><?= $no; ?>
                                                </th>
                                                <th>
                                                    <center><?= $r->nama_kel; ?>
                                                </th>
                                                <th>
                                                    <center><?= $this->m_masterdata->jml_relawan_per($r->id_kel, 4); ?>
                                                </th>
                                                <th>
                                                    <center><?php
                                                            $link = site_url("MasterData/relawan"); ?> <a href="<?= $link; ?>" type="button" class="btn btn-primary">Lihat Data</button>
                                                </th>
                                            <?php }
                                            ?>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- /.box -->
        <div class='col-md-7'>
            <div class='box '>
                <div class='box-header'>
                    <h3 class='box-title'>Grafik </h3> <br>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <center>
                        <div class="modal-body">
                            <canvas id="myChart" style="max-width:600px;margin:20px;max-height:92%"></canvas>
                        </div>
                    </center>
                </div>
            </div>
        </div><!-- /.box -->

        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-2.2.3.min.js"></script>

        <script type="text/javascript" src="<?= base_url() ?>assets/js/chart.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {

                var list = <?php echo json_encode($list); ?>;
                var jml = <?php echo json_encode($jml); ?>;
                var xValues = 'Grafik Relawan Per Wilayah';
                var wil = '<?php echo $data_wilayah; ?>';

                var barColors = getRandomColorEach(list.length);


                new Chart("myChart", {
                    type: "pie",
                    data: {
                        labels: list,
                        datasets: [{
                            backgroundColor: barColors,
                            data: jml
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    generateLabels: (chart) => {
                                        const datasets = chart.data.datasets;
                                        return datasets[0].data.map((data, i) => ({
                                            text: `${chart.data.labels[i]} (${data})`,
                                            fillStyle: datasets[0].backgroundColor[i],
                                            index: i
                                        }))
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Grafik Data Relawan  ' + wil
                            }
                        }
                    }
                });


            });


            function getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }



            function getRandomColorEach(count) {
                var data = [];
                for (var i = 0; i < count; i++) {
                    data.push(getRandomColor());
                }
                return data;
            }
        </script>