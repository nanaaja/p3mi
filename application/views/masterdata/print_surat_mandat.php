<!DOCTYPE html>
<html lang="en">
<head>
    <title>/</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/printer.css"> -->

</head>

<body>
    <div class="container">
        <img width="750" height="200" class="center" src="<?php echo base_url('uploads/surat/kop.png'); ?>" />
        <table style="width:100%" border="0" class="center">
            <tbody>
                <tr>
                    <td style="width:100%; text-align: center"><strong><u>SURAT MANDAT SAKSI</u></strong></td>
                </tr>
                <tr>
                    <td style="width:100%; text-align: center">Nomor : <?php echo $id_surat;?>.<?php echo rand(0,99);?>/TKMAVAN1/XI/2024</td>
                </tr>
                
            </tbody>
        </table>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bersama ini , Tim Kampanye Calon Bupati dan Wakil Bupati Tangerang Nomor Urut 1 (satu)
            Bapak <strong>H. MAD ROMLI.,SH.,MM & Bapak H. IRVANSYAH ASMAT.,S.IP.,M.Si ,</strong></p>
        <p>Memberikan Surat Mandat Untuk Menjadi <strong>SAKSI</strong> pada Pemilihan Kepala Daerah Kabupaten Tangerang Tahun 2024 di Tempat Pemungutan Suara (TPS) Kepada :</p>
        <table style="width:100%" border="0">
            <tbody>
                <tr>
                    <td style="width:30%;text-align: left">Nama</td>
                    <td>: <?php echo $data_saksi[0]->nama;?></td>
                </tr>
                <tr>
                    <td style="width:30%;text-align: left">NIK</td>
                    <td>: <?php echo $data_saksi[0]->nik;?></td>
                </tr>
                <tr>
                    <td style="width:30%;text-align: left">Jenis Kelamin</td>
                    <td>: <?php echo $data_saksi[0]->jk;?></td>
                </tr>
                <tr>
                    <td style="width:30%;text-align: left">Nomor Telpon</td>
                    <td>: 0<?php echo $data_saksi[0]->no_hp;?></td>
                </tr>
            </tbody>
        </table>
        <p>Bertugas Pada</p>
        <table style="width:100%" border="0">
            <tbody>
                <tr>
                    <td style="width:30%">Nomor TPS</td>
                    <td>: <?php echo $data_saksi[0]->nama_tps;?></td>
                </tr>
                <tr>
                    <td style="width:30%">Kelurahan / Desa</td>
                    <td>: <?php echo $data_saksi[0]->nama_kel;?></td>
                </tr>
                <tr>
                    <td style="width:30%">Kecamatan</td>
                    <td>: <?php echo $data_saksi[0]->nama_kec;?></td>
                </tr>
                <tr>
                    <td style="width:30%">Kabupaten</td>
                    <td>: Tangerang</td>
                </tr>
                <tr>
                    <td style="width:30%">Provinsi</td>
                    <td>: Banten</td>
                </tr>
            </tbody>
        </table>
        <p></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Mandat Saksi ini dibuat dengan sebenar-benarnya untuk digunakan sebagaimana mestinya dan menjalankan tugas sesuai dengan ketentuan yang berlaku. </p>
        <table style="width:95%" border="0" class="center">
            <tbody>
                <tr>
                    <td style="width:70%; text-align: right"><u>Tangerang , <?php echo date('d');?> November 2024</u></td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%" border="0" class="center">
            <tbody>
                <!-- <tr>
                    <td style="width:50%; text-align: center">Tim Kampanye</td>
                    <td style="width:50%; text-align: center"></td>
                </tr> -->
                <tr>
                    <td style="width:50%; text-align: center">Calon Bupati</td>
                    <td style="width:50%; text-align: center">Calon Wakil Bupati</td>
                </tr>
                <!-- <tr>
                    <td style="width:50%; text-align: center">Ketua,</td>
                    <td style="width:50%; text-align: center">Saksi TPS</td>
                </tr> -->
                <tr>
                    <td style="width:50%; text-align: center">
                    <img width="200" height="100" src="<?php echo base_url('uploads/surat/mrbpts.png'); ?>" />
                    </td>
                    <td style="width:50%; text-align: center">
                    <img width="200" height="100" src="<?php echo base_url('uploads/surat/irvanss.png'); ?>" />
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; text-align: center"><strong><u>H. Mad Romli.,SH.,MM</u></strong></td>
                    <td style="width:50%; text-align: center"><strong><u>H. Irvansyah Asmat.,S.IP.,M.Si</u></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>