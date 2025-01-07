<?php

class M_masterdata extends CI_Model
{

    public function __construct()
    {
    }

    //dttables
    function get_calegs()
    {
        $this->db->select('*');
        $this->db->from('data_caleg a');
        $this->db->join('data_partai b', 'b.id_partai=a.id_partai', 'left');
        $this->db->join('wilayah_kabupaten g', 'g.id_kab=a.id_kab', 'left');
        $query = $this->db->get();
        return $query;
    }

    //dttables
    function get_c1s()
    {
        $this->db->select('*');
        $this->db->from('data_c1 a');
        $this->db->join('data_tps c', 'c.id_tps=a.id_tps', 'left');
        $this->db->join('data_kategori e', 'e.id_kategori=a.id_jenis', 'left');
        $this->db->join('wilayah_desa f', 'f.id_kel=a.id_kel', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=a.id_kec', 'left');
        $query = $this->db->get();
        return $query;
    }


    //dttables
    function get_suara_pilegs()
    {
        $this->db->from('data_suara a');
        $this->db->join('data_caleg z', 'z.id_caleg=a.id_caleg');
        $this->db->join('data_tps c', 'c.id_tps=a.id_tps');
        $this->db->join('wilayah_desa f', 'f.id_kel=c.id_kel');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=f.id_kec');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        if ($this->session->userdata('jabatan') == 'saksi') {
            $this->db->where('a.id_tps', $this->session->userdata('id_tps'));
        }

        $query = $this->db->get();
        return $query;
    }

    function get_suara_pilegss($idTps)
    {
        $this->db->select('a.*,c.*,z.*,f.*,h.*,i.*,j.*, a.id_tps as tps_id');
        $this->db->from('data_suara a');
        $this->db->join('data_caleg z', 'z.id_caleg=a.id_caleg');
        $this->db->join('data_tps c', 'c.id_tps=a.id_tps');
        $this->db->join('wilayah_desa f', 'f.id_kel=c.id_kel');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=f.id_kec');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $this->db->where('a.id_tps', $idTps);

        $query = $this->db->get();
        return $query;
    }

    //dttables
    function get_suara_pilegs_sum($id_caleg)
    {
        $this->db->from('data_suara a');
        $this->db->join('data_caleg z', 'z.id_caleg=a.id_caleg');
        $this->db->where('a.id_caleg', $id_caleg);

        $query = $this->db->get();
        return $query;
    }

    function get_suara_pendukung_sum()
    {
        $this->db->from('data_pendukung a');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //dttables
    function get_suara_pemilu_sum($id_caleg)
    {
        $this->db->from('data_suara_pemilu a');
        $this->db->join('data_caleg z', 'z.id_caleg=a.id_caleg');
        $this->db->join('data_tps c', 'c.id_tps=a.id_tps');
        $this->db->join('data_dapil d', 'd.id_dapil=a.id_dapil');
        $this->db->join('wilayah_desa f', 'f.id_kel=a.id_kel');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=a.id_kec');
        $this->db->where('a.id_caleg', $id_caleg);

        $query = $this->db->get();
        return $query;
    }

    //dttables
    function get_suara_pemilus()
    {
        $this->db->from('data_suara_pemilu a');
        $this->db->join('data_caleg z', 'z.id_caleg=a.id_caleg');
        $this->db->join('data_tps c', 'c.id_tps=a.id_tps');
        $this->db->join('data_dapil d', 'd.id_dapil=a.id_dapil');
        $this->db->join('wilayah_desa f', 'f.id_kel=a.id_kel');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=a.id_kec');
        $query = $this->db->get();
        return $query;
    }

    function get_caleg($id_caleg)
    {
        $query = "SELECT * FROM data_caleg WHERE id_caleg = '" . $id_caleg . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_caleg($id, $data)
    {
        $this->db->where('id_caleg', $id);
        $this->db->update('data_caleg', $data);
    }

    function get_suara($id_suara)
    {
        $query = "SELECT * FROM data_suara WHERE id_suara = '" . $id_suara . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_suara_join($id_suara)
    {
        $query = "SELECT * FROM data_suara JOIN data_tps wd ON wd.id_tps = data_suara.id_tps WHERE id_suara = '" . $id_suara . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_suara($id, $data)
    {
        $this->db->where('id_suara', $id);
        $this->db->update('data_suara', $data);
    }

    function get_allCalon()
    {
        $query = "SELECT * FROM data_caleg   ";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_allCalonResult()
    {
        $query = "SELECT nama,SUM(suara) AS total,data_caleg.photo FROM `data_suara` JOIN data_caleg ON data_caleg.id_caleg = data_suara.id_caleg GROUP by data_suara.id_caleg   ";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allCalonByKota($id_kec)
    {
        $query = "SELECT nama,SUM(suara) AS total,c.nama_kab FROM `data_suara` JOIN data_caleg ON data_caleg.id_caleg = data_suara.id_caleg 
                     JOIN 
                    data_tps x ON x.id_tps = data_suara.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                        JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
        WHERE b.id_kec = '" . $id_kec. "' GROUP by data_suara.id_caleg   ";
        $sql = $this->db->query($query);
        return $sql->result();
    }


    //dttables
    function get_tpss()
    {
        $this->db->select('*');
        $this->db->from('data_tps a');
        $this->db->join('wilayah_desa z', 'z.id_kel=a.id_kel', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_tps($id_tps)
    {
        $query = "SELECT * FROM data_tps WHERE id_tps = '" . $id_tps . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_tps_join($id_tps)
    {
        $query = "SELECT * FROM data_tps JOIN wilayah_desa a ON a.id_kel = data_tps.id_kel 
        JOIN wilayah_kecamatan b ON b.id_kec = a.id_kec JOIN wilayah_kabupaten c ON c.id_kab = b.id_kab JOIN wilayah_provinsi d ON d.id_prov = c.id_prov
        WHERE data_tps.id_tps = '" . $id_tps . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_tps($id, $data)
    {
        $this->db->where('id_tps', $id);
        $this->db->update('data_tps', $data);
    }

    function get_allTps()
    {
        $query = "SELECT * FROM data_tps";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function getTpsDetail($idTps)
    {
        $query = "SELECT * FROM `data_tps` 
                    INNER JOIN wilayah_desa ON data_tps.id_kel = wilayah_desa.id_kel
                    INNER JOIN wilayah_kecamatan ON wilayah_desa.id_kec = wilayah_kecamatan.id_kec
                    INNER JOIN wilayah_kabupaten ON wilayah_kecamatan.id_kab = wilayah_kabupaten.id_kab
                    INNER JOIN wilayah_provinsi ON wilayah_kabupaten.id_prov = wilayah_provinsi.id_prov WHERE id_tps= '" . $idTps . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function getTpsGlobal()
    {
        $query = "SELECT * FROM `data_tps` 
                    INNER JOIN wilayah_desa ON data_tps.id_kel = wilayah_desa.id_kel
                    INNER JOIN wilayah_kecamatan ON wilayah_desa.id_kec = wilayah_kecamatan.id_kec
                    INNER JOIN wilayah_kabupaten ON wilayah_kecamatan.id_kab = wilayah_kabupaten.id_kab
                    INNER JOIN wilayah_provinsi ON wilayah_kabupaten.id_prov = wilayah_provinsi.id_prov";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    //dttables
    function get_partais()
    {
        $this->db->select('*');
        $this->db->from('data_partai');
        $query = $this->db->get();
        return $query;
    }

    function get_partai($id_partai)
    {
        $query = "SELECT * FROM data_partai WHERE id_partai = '" . $id_partai . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_partai($id, $data)
    {
        $this->db->where('id_partai', $id);
        $this->db->update('data_partai', $data);
    }
    function update_dpt($id, $data)
    {
        $this->db->where('id_dpt', $id);
        $this->db->update('data_dpt', $data);
    }

    function update_konfig($id, $data)
    {
        $this->db->where('id_konfig', $id);
        $this->db->update('data_konfig', $data);
    }


    function get_allPartai()
    {
        $query = "SELECT * FROM data_partai";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_allKelurahan()
    {
        $query = "SELECT * FROM wilayah_desa a JOIN wilayah_kecamatan b ON b.id_kec = a.id_kec JOIN wilayah_kabupaten c ON c.id_kab = b.id_kab JOIN wilayah_provinsi d ON d.id_prov = c.id_prov";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_allKelurahans($id_user)
    {
        $query = "SELECT * FROM data_koordinator a JOIN wilayah_desa e ON a.id_kel = e.id_kel  JOIN wilayah_kecamatan b ON b.id_kec = e.id_kec JOIN wilayah_kabupaten c ON c.id_kab = b.id_kab JOIN wilayah_provinsi d ON d.id_prov = c.id_prov WHERE a.id_user = '".$id_user."'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_kecamatan()
    {
        $query = "SELECT * FROM wilayah_kecamatan a JOIN wilayah_kabupaten b ON b.id_kab = a.id_kab JOIN wilayah_provinsi c ON c.id_prov = b.id_prov";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_allKecamatan()
    {
        $query = "SELECT * FROM wilayah_kecamatan";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKecamatanKabTangerang()
    {
        $query = "SELECT * FROM wilayah_kecamatan WHERE id_kab='3603'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKabupaten()
    {
        $query = "SELECT * FROM wilayah_kabupaten";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_allProvinsi()
    {
        $query = "SELECT * FROM wilayah_provinsi";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKabupatenByProv($id_prov)
    {
        $query = "SELECT * FROM wilayah_kabupaten where id_prov = '" . $id_prov . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKecamatanByKota($id_kab)
    {
        $query = "SELECT * FROM wilayah_kecamatan where id_kab='" . $id_kab . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_kel_by_tps($id_tps)
    {
        $query = "SELECT * FROM data_tps where id_tps='" . $id_tps . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }


    //dttables
    function get_dapils()
    {
        $this->db->select('*');
        $this->db->from('data_dapil');
        $query = $this->db->get();
        return $query;
    }

    function get_dapil($id_dapil)
    {
        $query = "SELECT * FROM data_dapil WHERE id_dapil = '" . $id_dapil . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_dapil($id, $data)
    {
        $this->db->where('id_dapil', $id);
        $this->db->update('data_dapil', $data);
    }


    function get_allDapil()
    {
        $query = "SELECT * FROM data_dapil";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allJenis()
    {
        $query = "SELECT * FROM data_kategori";
        $sql = $this->db->query($query);
        return $sql->result();
    }



    //dttables
    function get_penggunas()
    {
        $this->db->select('*');
        $this->db->from('user');
        $query = $this->db->get();
        return $query;
    }

    function get_pengguna($id_user)
    {
        $query = "SELECT * FROM user WHERE  id_user = '" . $id_user . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_pengguna($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }

    function get_dpt($id_dpt)
    {
        $query = "SELECT * FROM data_dpt WHERE  id_dpt = '" . $id_dpt . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function get_konfig($id_konfig)
    {
        $query = "SELECT * FROM data_konfig WHERE  id_konfig = '" . $id_konfig . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allpengguna()
    {
        $query = "SELECT * FROM user";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function cek_data($table, $where)
    {
        return $this->db->get_where($table, $where);
    }


    public function caleg()
    {

        $query = $this->db->query("SELECT COALESCE(COUNT(*),0) as caleg FROM data_caleg");

        return $query->result();
    }

    public function tps()
    {
        $query = $this->db->query("SELECT COALESCE(COUNT(*),0) as tps FROM data_tps");
        return $query->result();
    }

    public function dapil()
    {

        $query = $this->db->query("SELECT COALESCE(COUNT(*),0) as dapil FROM data_dapil");

        return $query->result();
    }
    public function partai()
    {

        $query = $this->db->query("SELECT COALESCE(COUNT(*),0) as partai FROM data_partai");

        return $query->result();
    }


    function get_allKabByProv($id_prov)
    {
        $query = "SELECT * FROM wilayah_kabupaten where id_prov='" . $id_prov . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKecByKab($id_kab)
    {
        $query = "SELECT * FROM wilayah_kecamatan where id_kab='" . $id_kab . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKelurahanbyKec($id_kec)
    {
        $query = "SELECT * FROM wilayah_desa where id_kec='" . $id_kec . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allTpsByKel($id_kel)
    {
        $query = "SELECT * FROM data_tps where id_kel='" . $id_kel . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_detail_wil_by_id_kel($id_kel)
    {
        $query = "SELECT * FROM 
        wilayah_desa  a
        JOIN 
        wilayah_kecamatan b ON a.id_kec = b.id_kec 
        JOIN 
        wilayah_kabupaten c ON b.id_kab = c.id_kab
        JOIN
        wilayah_provinsi d ON c.id_prov = d.id_prov where id_kel='" . $id_kel . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    public function suara_pileg()
    {
        $query = $this->db->query("SELECT COALESCE(SUM(suara),0) as tot_suara FROM data_suara ");

        return $query->result();
    }

    public function suara_pemilu()
    {
        $query = $this->db->query("SELECT COALESCE(SUM(suara),0) as tot_suara FROM data_suara ");

        return $query->result();
    }

    public function jml_dukungan()
    {
        $query = $this->db->query("SELECT COUNT(*) as tot_dukungan FROM data_pendukung ");
        return $query->result();
    }


    public function demo_koordinator()
    {
        $query = $this->db->query("SELECT jk,COUNT(*) as jml FROM `data_koordinator` GROUP BY jk ");
        return $query->result();
    }

    public function demo_korcam()
    {
        $query = $this->db->query("SELECT jk,COUNT(*) as jml FROM `data_korcam` GROUP BY jk ");
        return $query->result();
    }
    public function demo_saksi()
    {
        $query = $this->db->query("SELECT jk,COUNT(*) as jml FROM `user`  WHERE jabatan = 'saksi' GROUP BY jk ");
        return $query->result();
    }
    public function demo_pendukung()
    {
        $query = $this->db->query("SELECT jk,COUNT(*) as jml FROM `data_pendukung` GROUP BY jk ");
        return $query->result();
    }

    public function demo_relawan()
    {
        $query = $this->db->query("SELECT jk,COUNT(*) as jml FROM `data_relawan` GROUP BY jk ");
        return $query->result();
    }

    public function suara_calon($id_caleg)
    {
        $query = $this->db->query("SELECT COALESCE(SUM(suara),0) as tot_suara FROM data_suara   WHERE id_caleg = '" . $id_caleg . "' ");
        return $query->result();
    }
    public function get_saksi_by_tps($id_tps)
    {
        $query = $this->db->query("SELECT * FROM user   WHERE jabatan = 'saksi' AND id_tps = '" . $id_tps . "' ");
        return $query->result();
    }
	public function get_relawan_by_tps($id_tps)
    {
        $query = $this->db->query("SELECT * FROM user   WHERE jabatan = 'relawan' AND id_tps = '" . $id_tps . "' ");
        return $query->result();
    }
    public function get_saksis()
    {
		$this->db->select('a.*, b.*, z.*, h.*, i.*, j.*, x.nik');
        $this->db->from('user a');
        $this->db->where('jabatan', 'saksi');
        $this->db->join('data_tps b', 'b.id_tps=a.id_tps', 'left');
        $this->db->join('data_saksi x', 'x.id_user=a.id_user', 'left');
        $this->db->join('wilayah_desa z', 'z.id_kel=b.id_kel', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $query = $this->db->get();
        return $query;
    }



    public function jml_relawan_per($id, $level)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  * FROM data_relawan z
                        JOIN 
                    wilayah_desa a ON a.id_kel = z.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE d.id_prov = '" . $id . "' ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  * FROM data_relawan z
                        JOIN 
                    wilayah_desa a ON a.id_kel = z.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
            
              WHERE c.id_kab = '" . $id . "' ");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  * FROM data_relawan z
                        JOIN 
                    wilayah_desa a ON a.id_kel = z.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
              WHERE b.id_kec = '" . $id . "' ");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  * FROM data_relawan z
                        JOIN 
                    wilayah_desa a ON a.id_kel = z.id_kel 
                        
              WHERE a.id_kel = '" . $id . "' ");
        }
        return $query->num_rows();
    }



    public function jml_real_count_per($id, $level)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov  
                    WHERE c.id_prov = '" . $id . "' GROUP BY id_caleg ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
            
              WHERE c.id_kab = '" . $id . "' GROUP BY id_caleg");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
              WHERE b.id_kec = '" . $id . "' GROUP BY id_caleg");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        
              WHERE a.id_kel = '" . $id . "' GROUP BY id_caleg ");
        }elseif ($level == 5) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        LEFT JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        LEFT JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        
              WHERE x.id_tps = '" . $id . "' GROUP BY id_caleg");
        }
        return $query->result();
    }

    public function jml_real_count($id, $level)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov  
                    WHERE c.id_prov = '" . $id . "' AND z.id_caleg = '10'");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
            
              WHERE c.id_kab = '" . $id . "' AND z.id_caleg = '10'");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
              WHERE b.id_kec = '" . $id . "' AND z.id_caleg = '10'");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        
              WHERE a.id_kel = '" . $id . "' AND z.id_caleg = '10'");
        }elseif ($level == 5) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        LEFT JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        LEFT JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        
              WHERE x.id_tps = '" . $id . "' AND z.id_caleg = '10'");
        }
        return $query->result();
    }

    public function jml_suara_pendukung_per_wilayah($id, $level)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN 
          data_tps x ON x.id_tps = z.id_tps
            JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                    JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE d.id_prov = '" . $id . "' ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN    data_tps x ON x.id_tps = z.id_tps
            JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
            
              WHERE c.id_kab = '" . $id . "' ");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN 
          data_tps x ON x.id_tps = z.id_tps
            JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
              WHERE b.id_kec = '" . $id . "' ");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN 
          data_tps x ON x.id_tps = z.id_tps
            JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        
              WHERE a.id_kel = '" . $id . "' ");
        }
        return $query->num_rows();
    }

    public function jml_real_count_per_paslon($id, $level, $id_paslon)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE  z.id_caleg = '" . $id_paslon . "' ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE d.id_prov = '" . $id . "' AND z.id_caleg = '" . $id_paslon . "'");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 

              WHERE c.id_kab = '" . $id . "' AND z.id_caleg = '" . $id_paslon . "' ");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                    JOIN
                    wilayah_kecamatan b ON a.id_kec = b.id_kec   
                        
              WHERE b.id_kec = '" . $id . "' AND z.id_caleg = '" . $id_paslon . "' ");
        }elseif ($level == 5) {
            $query = $this->db->query("SELECT  COALESCE(SUM(suara),0) as s FROM data_suara z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                    JOIN
                    wilayah_kecamatan b ON a.id_kec = b.id_kec   
                        
              WHERE x.id_tps = '" . $id . "' AND z.id_caleg = '" . $id_paslon . "' ");
        }

        return $query->result();
    }

    public function jml_suara_pendukung_by_rel($id, $level, $id_rel)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE  z.id_relawan = '" . $id_rel . "' ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN 
       data_tps x ON x.id_tps = z.id_tps
            JOIN  
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE d.id_prov = '" . $id . "' AND z.id_relawan = '" . $id_rel . "'");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN 
       data_tps x ON x.id_tps = z.id_tps
            JOIN  
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 

              WHERE c.id_kab = '" . $id . "' AND z.id_relawan = '" . $id_rel . "' ");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
            JOIN 
       data_tps x ON x.id_tps = z.id_tps
            JOIN  
                    wilayah_desa a ON a.id_kel = x.id_kel 
                    JOIN
                    wilayah_kecamatan b ON a.id_kec = b.id_kec   
                        
              WHERE b.id_kec = '" . $id . "' AND z.id_relawan = '" . $id_rel . "' ");
        }
        return $query->num_rows();
    }



    public function jml_suara_pendukung_per($id, $level)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab
                    JOIN
                    wilayah_provinsi d ON c.id_prov = d.id_prov
            
              WHERE d.id_prov = '" . $id . "' ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec 
                    JOIN 
                    wilayah_kabupaten c ON b.id_kab = c.id_kab 
            
              WHERE c.id_kab = '" . $id . "' ");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  * FROM data_pendukung z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        JOIN 
                    wilayah_kecamatan b ON a.id_kec = b.id_kec  
              WHERE b.id_kec = '" . $id . "' ");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT * FROM data_pendukung z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        JOIN 
                    wilayah_desa a ON a.id_kel = x.id_kel 
                        
              WHERE a.id_kel = '" . $id . "' ");
        }elseif ($level == 5) {
            $query = $this->db->query("SELECT * FROM data_pendukung z
                        JOIN 
                    data_tps x ON x.id_tps = z.id_tps
                        
              WHERE z.id_tps = '" . $id . "' ");
        }
        return $query->num_rows();
    }


    function get_wilayah($level, $id)
    {
        if ($level == 1) {
            $query = $this->db->query("SELECT  * FROM  
                    wilayah_provinsi  
              WHERE  id_prov = '" . $id . "' ");
        } elseif ($level == 2) {
            $query = $this->db->query("SELECT  * FROM  
                    wilayah_kabupaten   
              WHERE  id_kab = '" . $id . "' ");
        } elseif ($level == 3) {
            $query = $this->db->query("SELECT  * FROM  
            wilayah_kecamatan   
      WHERE  id_kec = '" . $id . "' ");
        } elseif ($level == 4) {
            $query = $this->db->query("SELECT  * FROM  
            wilayah_desa
      WHERE  id_kel = '" . $id . "' ");
        }
        return $query->result();
    }



    //dttables
    function get_pendukungs()
    {
        $this->db->select('a.*,b.*,c.*,a.nik as nik,a.alamat as alamat,a.jk as jk,z.nama_kel,h.nama_kec,i.nama_kab,j.nama_prov');
        $this->db->from('data_pendukung a');
        $this->db->join('data_tps b', 'b.id_tps=a.id_tps', 'left');
        $this->db->join('data_relawan c', 'c.id_relawan=a.id_relawan', 'left');
        $this->db->join('wilayah_desa z', 'z.id_kel=b.id_kel', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov');
        if ($this->session->userdata('jabatan') == 'relawan') {
            $this->db->where('a.id_user', $this->session->userdata('id_user'));
        }
        $query = $this->db->get();
        return $query;
    }
	
	function get_pendukungss($id_tps)
    {
        $this->db->select('a.*,b.*,c.*,a.nik as nik,a.alamat as alamat,a.jk as jk,z.nama_kel,h.nama_kec,i.nama_kab,j.nama_prov');
        $this->db->from('data_pendukung a');
        $this->db->join('data_tps b', 'b.id_tps=a.id_tps', 'left');
        $this->db->join('data_relawan c', 'c.id_relawan=a.id_relawan', 'left');
        $this->db->join('wilayah_desa z', 'z.id_kel=b.id_kel', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov');
        $this->db->where('a.id_tps', $id_tps);
        $query = $this->db->get();
        return $query;
    }

    function get_pendukung($id_pendukung)
    {
        $query = "SELECT * FROM data_pendukung WHERE id_pendukung = '" . $id_pendukung . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_pendukung($id, $data)
    {
        $this->db->where('id_pendukung', $id);
        $this->db->update('data_pendukung', $data);
    }

    function get_allPendukung()
    {
        $query = "SELECT * FROM data_pendukung";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    //dttables
    function get_relawans()
    {
        $this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,i.*, a.jk as jk, a.nik as nik, a.no_telp as nohp');
        $this->db->from('data_relawan a');
        $this->db->join('wilayah_desa b', 'b.id_kel=a.id_kel', 'left');
        $this->db->join('wilayah_kecamatan c', 'c.id_kec=b.id_kec', 'left');
        $this->db->join('wilayah_kabupaten d', 'd.id_kab=c.id_kab', 'left');
        $this->db->join('wilayah_provinsi e', 'd.id_prov=e.id_prov', 'left');
        $this->db->join('data_koordinator f', 'a.id_koordinator=f.id_koordinator', 'left');
        $this->db->join('user g', 'a.id_user=g.id_user', 'left');
        $this->db->join('user h', 'f.id_user=h.id_user', 'left');
        $this->db->join('data_tps i', 'g.id_tps=i.id_tps', 'left');
        if ($this->session->userdata('jabatan') == 'koordinator') {
            $this->db->where('h.id_user', $this->session->userdata('id_user'));
        }
        $query = $this->db->get();
        return $query;
    }
	

	
	function get_relawansssss($id_uer)
    {
        $query = "SELECT * FROM `data_koordinator` 
                    INNER JOIN wilayah_desa ON data_koordinator.id_kel = wilayah_desa.id_kel
                    INNER JOIN wilayah_kecamatan ON wilayah_desa.id_kec = wilayah_kecamatan.id_kec
                    INNER JOIN wilayah_kabupaten ON wilayah_kecamatan.id_kab = wilayah_kabupaten.id_kab
                    INNER JOIN wilayah_provinsi ON wilayah_kabupaten.id_prov = wilayah_provinsi.id_prov 
					WHERE data_koordinator.id_user= '" . $id_uer . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_relawanss($id_relawan)
    {
        $query = "SELECT * FROM data_relawan 
            INNER JOIN wilayah_desa ON data_relawan.id_kel= wilayah_desa.id_kel
            INNER JOIN wilayah_kecamatan ON wilayah_desa.id_kec=wilayah_kecamatan.id_kec
            INNER JOIN wilayah_kabupaten ON wilayah_kecamatan.id_kab=wilayah_kabupaten.id_kab
            INNER JOIN wilayah_provinsi ON wilayah_kabupaten.id_prov=wilayah_provinsi.id_prov
            INNER JOIN user ON data_relawan.id_user=user.id_user
            WHERE data_relawan.id_relawan = '".$id_relawan."'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_relawan($id_relawan)
    {
        $query = "SELECT * FROM data_relawan WHERE id_relawan = '" . $id_relawan . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_relawan($id, $data)
    {
        $this->db->where('id_relawan', $id);
        $this->db->update('data_relawan', $data);
    }

    function update_user($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }

    function get_allRelawan()
    {
        $query = "SELECT * FROM data_relawan";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allRelawanDetail($idUser)
    {
        $query = "SELECT * FROM `user` 
                    INNER JOIN data_relawan ON user.id_user = data_relawan.id_user
                    WHERE user.id_user= '" . $idUser . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    //dttables
    function get_koordinators()
    {
        $this->db->select('*');
        $this->db->from('data_koordinator a');
        $query = $this->db->get();
        return $query;
    }
    function get_koordinatorss()
    {
        $this->db->select('a.*,b.*,c.*,d.*,e.*, a.jk as jk, a.nik as nik, g.id_user as userid, g.username as usernames, g.password as password');
        $this->db->from('data_koordinator a');
        $this->db->join('wilayah_desa b', 'b.id_kel=a.id_kel', 'left');
        $this->db->join('wilayah_kecamatan c', 'c.id_kec=b.id_kec', 'left');
        $this->db->join('wilayah_kabupaten d', 'd.id_kab=c.id_kab', 'left');
        $this->db->join('wilayah_provinsi e', 'd.id_prov=e.id_prov', 'left');
        $this->db->join('user g', 'a.id_user=g.id_user', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_koordinator($id_koordinator)
    {
        $query = "SELECT * FROM data_koordinator INNER JOIN user ON user.id_user = data_koordinator.id_user WHERE id_koordinator = '" . $id_koordinator . "'";
        $sql = $this->db->query($query);
        return $sql->result();
        
    }

    function update_koordinator($id, $data)
    {
        $this->db->where('id_koordinator', $id);
        $this->db->update('data_koordinator', $data);
    }

    function update_korcam($id, $data)
    {
        $this->db->where('id_koordinator', $id);
        $this->db->update('data_korcam', $data);
    }


    function get_allKoordinator()
    {
        $query = "SELECT * FROM data_koordinator";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allKoordinators($id_user)
    {
        $query = "SELECT * FROM data_koordinator WHERE id_user = '".$id_user."'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_korcamss()
    {
        $this->db->select('a.*,c.*,d.*,e.*, a.jk as jk, a.nik as nik, g.id_user as userid, g.username as usernames, g.password as password');
        $this->db->from('data_korcam a');
        $this->db->join('wilayah_kecamatan c', 'c.id_kec=a.id_kec', 'left');
        $this->db->join('wilayah_kabupaten d', 'd.id_kab=c.id_kab', 'left');
        $this->db->join('wilayah_provinsi e', 'd.id_prov=e.id_prov', 'left');
        $this->db->join('user g', 'a.id_user=g.id_user', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_korcam($id_koordinator)
    {
        $query = "SELECT * FROM data_korcam INNER JOIN user ON user.id_user = data_korcam.id_user WHERE id_koordinator = '" . $id_koordinator . "'";
        $sql = $this->db->query($query);
        return $sql->result();
        
    }

    function total_tps_sudah_terisi()
    {
        $query = "SELECT DISTINCT(id_tps) from data_suara";
        $sql = $this->db->query($query);
        return $sql->num_rows();
    }
    function total_tps()
    {
        $query = "SELECT * FROM data_tps";
        $sql = $this->db->query($query);
        return $sql->num_rows();
    }

    function total_suara_tps($id_tps)
    {
        $query = "SELECT * FROM data_suara WHERE id_tps='" . $id_tps . "'";
        $sql = $this->db->query($query);
        return $sql->num_rows();
    }


    function get_wilayah_provinsi($id)
    {
        $query = "SELECT * FROM wilayah_provinsi WHERE id_prov = '" . $id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function update_wilayah_provinsi($id, $data)
    {
        $this->db->where('id_prov', $id);
        $this->db->update('wilayah_provinsi', $data);
    }

    function get_wilayah_kabupaten($id)
    {
        $query = "SELECT * FROM wilayah_kabupaten WHERE id_kab = '" . $id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function update_wilayah_kabupaten($id, $data)
    {
        $this->db->where('id_kab', $id);
        $this->db->update('wilayah_kabupaten', $data);
    }

    function get_wilayah_kecamatan($id)
    {
        $query = "SELECT * FROM wilayah_kecamatan WHERE id_kec = '" . $id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function update_wilayah_kecamatan($id, $data)
    {
        $this->db->where('id_kec', $id);
        $this->db->update('wilayah_kecamatan', $data);
    }

    function get_wilayah_desa($id)
    {
        $query = "SELECT * FROM wilayah_desa WHERE id_kel = '" . $id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    function update_wilayah_desa($id, $data)
    {
        $this->db->where('id_kel', $id);
        $this->db->update('wilayah_desa', $data);
    }
	function getSaksiByTPS($id_saksi)
    {
        $query = "SELECT a.*,b.*,c.*,d.*,x.* FROM user a
                LEFT JOIN data_saksi x ON x.id_user=a.id_user
                LEFT JOIN data_tps b ON b.id_tps=a.id_tps
                LEFT JOIN wilayah_desa c ON c.id_kel=b.id_kel
                LEFT JOIN wilayah_kecamatan d ON d.id_kec=c.id_kec
                WHERE a.jabatan='saksi' AND a.id_user='" . $id_saksi . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }


    //dttables
    //============================================================================================///
    function get_blk()
    {
        $this->db->select('*');
        $this->db->from('data_blk a');
        $this->db->join('wilayah_desa z', 'z.id_kel=a.blk_district', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_blks()
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_blk a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.blk_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.blk_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_blk($id, $data)
    {
        $this->db->where('blk_id', $id);
        $this->db->update('data_blk', $data);
    }

    function get_blkById($blk_id)
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_blk a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.blk_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.blk_id = '" . $blk_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_lsp()
    {
        $this->db->select('*');
        $this->db->from('data_lsp a');
        $this->db->join('wilayah_desa z', 'z.id_kel=a.lsp_district', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_lspp()
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_lsp a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.lsp_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.lsp_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_lsp($id, $data)
    {
        $this->db->where('lsp_id', $id);
        $this->db->update('data_lsp', $data);
    }

    function get_lspById($lsp_id)
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_lsp a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.lsp_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.lsp_id = '" . $lsp_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }


    function get_tuk()
    {
        $this->db->select('*');
        $this->db->from('data_tuk a');
        $this->db->join('data_lsp b', 'b.lsp_id=a.lsp_id', 'left');
        $query = $this->db->get();
        return $query;
    }


    function update_tuk($id, $data)
    {
        $this->db->where('tuk_id', $id);
        $this->db->update('data_tuk', $data);
    }

    function get_tukById($tuk_id)
    {
        $query = "SELECT *
                    FROM data_tuk a 
                    INNER JOIN data_lsp b ON b.lsp_id=a.lsp_id
                    WHERE a.tuk_id = '" . $tuk_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_sarkes()
    {
        $this->db->select('*');
        $this->db->from('data_sarkes a');
        $this->db->join('wilayah_desa z', 'z.id_kel=a.sarkes_district', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_sarkess()
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_sarkes a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.sarkes_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.sarkes_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_sarkes($id, $data)
    {
        $this->db->where('sarkes_id', $id);
        $this->db->update('data_sarkes', $data);
    }

    function get_sarkesById($sarkes_id)
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_sarkes a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.sarkes_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.sarkes_id = '" . $sarkes_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_agency()
    {
        $this->db->select('*');
        $this->db->from('data_agency a');
        $this->db->join('wilayah_desa z', 'z.id_kel=a.agency_district', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_agencys()
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_agency a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.agency_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_agency($id, $data)
    {
        $this->db->where('agency_id', $id);
        $this->db->update('data_agency', $data);
    }

    function get_agencyById($agency_id)
    {
        $query = "SELECT a.*, b.id_kel AS b_id_kel, b.nama_kel AS nama_kel, c.id_kec AS c_id_kec, c.nama_kec AS c_nama_kec, d.id_kab AS d_id_kab, d.nama_kab AS d_nama_kab, e.id_prov AS e_id_prov, e.nama_prov AS e_nama_prov 
                    FROM data_agency a 
                    INNER JOIN wilayah_desa b ON b.id_kel=a.agency_district
                    INNER JOIN wilayah_kecamatan c ON c.id_kec=b.id_kec
                    INNER JOIN wilayah_kabupaten d ON d.id_kab=c.id_kab
                    INNER JOIN wilayah_provinsi e ON e.id_prov=d.id_prov
                    WHERE a.agency_id = '" . $agency_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    //===================================================================================================//
    function get_country()
    {
        $this->db->select('*');
        $this->db->from('data_country');
        $query = $this->db->get();
        return $query;
    }

    function get_countrys()
    {
        $query = "SELECT *
                    FROM data_country WHERE country_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_country($id, $data)
    {
        $this->db->where('country_id', $id);
        $this->db->update('data_country', $data);
    }

    function get_countryById($country_id)
    {
        $query = "SELECT *
                    FROM data_country 
                    WHERE country_id = '" . $country_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    //===================================================================================================//
    function get_district()
    {
        $this->db->select('a.district_id as dis_id, a.district_name as dis_name, a.district_status as dis_status, b.country_id as count_id, b.country_name as count_name');
        $this->db->from('data_district a');
        $this->db->join('data_country b', 'b.country_id=a.country_id', 'left');
        $query = $this->db->get();
        
        return $query;
    }

    function get_districts()
    {
        $query = "SELECT a.district_id as dis_id, a.district_name as dis_name, a.district_status as dis_status, b.country_id as count_id, b.country_name as count_name
                    FROM data_district a 
                    INNER JOIN data_country b ON b.country_id=a.country_id
                    WHERE a.district_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_district($id, $data)
    {
        $this->db->where('district_id', $id);
        $this->db->update('data_district', $data);
    }

    function get_districtById($district_id)
    {
        $query = "SELECT a.district_id as dis_id, a.district_name as dis_name, a.district_status as dis_status, b.country_id as count_id, b.country_name as count_name
                    FROM data_district a 
                    INNER JOIN data_country b ON b.country_id=a.country_id
                    WHERE a.district_id = '" . $district_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    //===================================================================================================//
    function get_grant()
    {
        $this->db->select('*');
        $this->db->from('data_grant');
        $query = $this->db->get();
        return $query;
    }

    function get_grants()
    {
        $query = "SELECT *
                    FROM data_grant WHERE grant_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_grant($id, $data)
    {
        $this->db->where('grant_id', $id);
        $this->db->update('data_grant', $data);
    }

    function get_grantById($grant_id)
    {
        $query = "SELECT *
                    FROM data_grant 
                    WHERE grant_id = '" . $grant_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    //===================================================================================================//
    function get_candidates()
    {
        $this->db->select('*');
        $this->db->from('data_pekerja a');
        $this->db->join('wilayah_desa z', 'z.id_kel=a.tk_district', 'left');
        $this->db->join('wilayah_kecamatan h', 'h.id_kec=z.id_kec', 'left');
        $this->db->join('wilayah_kabupaten i', 'h.id_kab=i.id_kab', 'left');
        $this->db->join('wilayah_provinsi j', 'i.id_prov=j.id_prov', 'left');
        $this->db->join('data_agency k', 'a.agency_id =k.agency_id', 'left');
        $this->db->join('data_grant l', 'a.tk_grant=l.grant_id', 'left');
        $this->db->join('data_country m', 'a.tk_country=m.country_id', 'left');
        $this->db->join('data_district n', 'a.tk_district_country=n.district_id', 'left');
        $query = $this->db->get();
        return $query;
    }

    function get_candidatess()
    {
        $query = "SELECT *
                    FROM data_pekerja WHERE tk_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allDistrictByCountryId($country_id)
    {
        $query = "SELECT * FROM data_district where country_id='" . $country_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    //===================================================================================================//
    function get_candidates_blk()
    {
        $this->db->select('*');
        $this->db->from('data_candidates_blk a');
        $this->db->join('data_pekerja b', 'b.tk_id=a.tk_id', 'left');
        $this->db->join('data_blk c', 'c.blk_id =a.blk_id ', 'left');
        $query = $this->db->get();
        
        return $query;
    }

    function get_candidates_blks()
    {
        $query = "SELECT *
                    FROM data_candidates_blk a 
                    INNER JOIN data_pekerja b ON b.tk_id=a.tk_id
                    INNER JOIN data_blk c ON c.blk_id=a.blk_id
                    WHERE a.cb_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_candidates_blk($id, $data)
    {
        $this->db->where('cb_id', $id);
        $this->db->update('data_candidates_blk', $data);
    }

    function get_candidatesBlkById($cb_id)
    {
        $query = "SELECT *
                    FROM data_candidates_blk a 
                    INNER JOIN data_pekerja b ON b.tk_id=a.tk_id
                    INNER JOIN data_blk c ON c.blk_id=a.blk_id
                    WHERE a.cb_id = '" . $cb_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
    //===================================================================================================//
    function get_candidates_lsp()
    {
        $this->db->select('*');
        $this->db->from('data_candidates_lsp a');
        $this->db->join('data_pekerja b', 'b.tk_id=a.tk_id', 'left');
        $this->db->join('data_lsp c', 'c.lsp_id =a.lsp_id ', 'left');
        $this->db->join('data_tuk d', 'd.tuk_id =a.tuk_id ', 'left');
        $query = $this->db->get();
        
        return $query;
    }

    function get_candidates_lsps()
    {
        $query = "SELECT *
                    FROM data_candidates_lsp a 
                    INNER JOIN data_pekerja b ON b.tk_id=a.tk_id
                    INNER JOIN data_lsp c ON c.lsp_id=a.lsp_id
                    INNER JOIN data_tuk d ON d.tuk_id=a.tuk_id
                    WHERE a.cl_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_candidates_lsp($id, $data)
    {
        $this->db->where('cb_id', $id);
        $this->db->update('data_candidates_blk', $data);
    }

    function get_candidatesLspById($cb_id)
    {
        $query = "SELECT *
                    FROM data_candidates_blk a 
                    INNER JOIN data_pekerja b ON b.tk_id=a.tk_id
                    INNER JOIN data_blk c ON c.blk_id=a.blk_id
                    WHERE a.cb_id = '" . $cb_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function get_allTUKByLspId($lsp_id)
    {
        $query = "SELECT * FROM data_tuk where lsp_id='" . $lsp_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    //===================================================================================================//
    function get_candidates_sarkes()
    {
        $this->db->select('*');
        $this->db->from('data_candidates_sarkes a');
        $this->db->join('data_pekerja b', 'b.tk_id=a.tk_id', 'left');
        $query = $this->db->get();
        
        return $query;
    }

    function get_candidates_sarkess()
    {
        $query = "SELECT *
                    FROM data_candidates_sarkes a 
                    INNER JOIN data_pekerja b ON b.tk_id=a.tk_id
                    WHERE a.cs_status = '1'";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    function update_candidates_sarkes($id, $data)
    {
        $this->db->where('cs_id', $id);
        $this->db->update('data_candidates_sarkes', $data);
    }

    function get_candidatesSarkesById($cs_id)
    {
        $query = "SELECT *
                    FROM data_candidates_sarkes a 
                    INNER JOIN data_pekerja b ON b.tk_id=a.tk_id
                    WHERE a.cs_id = '" . $cs_id . "'";
        $sql = $this->db->query($query);
        return $sql->result();
    }
}
