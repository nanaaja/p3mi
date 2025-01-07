<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

class Suara extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_masterdata');
        $this->load->model('m_user');
        $this->load->library('excel');
        $this->apk = $this->m_masterdata->get_konfig(0);
        $this->dpt = $this->m_masterdata->get_dpt(0);
        $this->paslon = $this->m_masterdata->get_caleg($this->apk[0]->id_paslon);


        if ($this->session->userdata('is_login') !== true) {
            redirect(site_url("Login"));
        }
    }

    public function suara()
    {
        if ($this->session->userdata('jabatan') == 'saksi' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'korcam'  || $this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_input_suara');
            $data['data_calon'] = $this->m_masterdata->get_allCalon();
            $data['data_partai'] = $this->m_masterdata->get_allPartai();
            $data['data_tps'] = $this->m_masterdata->get_allTps();
            $data['data_jenis'] = $this->m_masterdata->get_allJenis();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kabupaten'] = $this->m_masterdata->get_allKabupaten();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            if ($_SESSION['jabatan'] == 'saksi') {
                $data['data_tps_saksi'] = $this->m_masterdata->get_tps_join($_SESSION['id_tps']);
                $data['cek_terisi'] = $this->m_masterdata->total_suara_tps($_SESSION['id_tps']);
            }


            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
        alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }




    public function add_suara()
    {
        $i = $this->input;
        $nm_dokumen = rand();

        if (!empty($_FILES["dokumen"]["name"]) || !empty($_FILES["plano"]["name"])) {
            $config['upload_path'] = './uploads/c1';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['max_size'] = 30000;
            $config['file_name'] = $nm_dokumen;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('dokumen')) {
                echo $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $nm_dokumen = $nm_dokumen . '.' . pathinfo($_FILES["dokumen"]["name"], PATHINFO_EXTENSION);
                foreach ($i->post('id_caleg') as $key => $value) {
                    $data = array(
                        'id_tps' => $i->post('id_tps'),
                        'id_caleg' => $value,
                        'suara' => $i->post('suara')[$key],
                        'suara_tidak_sah' => $i->post('tot_suara_tdk_sah'),
                        'dokumen' => $nm_dokumen,

                    );
                    $cek = $this->db->insert('data_suara', $data);
                }
            }
        } else {
            foreach ($i->post('id_caleg') as $key => $value) {
                $data = array(
                    'id_tps' => $i->post('id_tps'),
                    'id_caleg' => $value,
                    'suara' => $i->post('suara')[$key],
                    'dokumen' => null,
                );
                $cek = $this->db->insert('data_suara', $data);
            }
        }



        echo json_encode('sukses');
    }
    public function update_suara()
    {
        $i = $this->input;


        $data = array(
            'id_caleg' =>  $i->post('id_caleg'),
            'suara' => $i->post('suara'),
            'id_tps' => $i->post('id_tps'),
        );
        $cek = $this->m_masterdata->update_suara($i->post('id_suara'), $data);




        echo json_encode('sukses');
    }


    public function c1()
    {
        $data = array('isi' => 'masterdata/data_c1');
        $data['data_caleg'] = $this->m_masterdata->get_allCaleg();
        $data['data_partai'] = $this->m_masterdata->get_allPartai();
        $data['data_tps'] = $this->m_masterdata->get_allTps();
        $data['data_jenis'] = $this->m_masterdata->get_allJenis();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
        $data['data_kota'] = $this->m_masterdata->get_allKabupaten();

        $this->load->view('layouts/wrapper', $data);
    }


    public function c1_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $books = $this->m_masterdata->get_c1s();



        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_dokumen,
                $r->nama_kategori,
                $r->nama_kec,
                $r->kode_pos,
                $r->nama_tps,
                tgl($r->waktu_input, false),
                $r->dokumen,
                null,
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $books->num_rows(),
            "recordsFiltered" => $books->num_rows(),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }

    public function data_suara()
    {

        if ($this->session->userdata('jabatan') == 'saksi' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_suara_pileg');
			if($_GET['id'] == null || $_GET['id'] == ""){
                $data['id_data_tps'] = "0000";
            }else{
                $data['id_data_tps'] = $_GET['id'];
            }
            $log_type = 'INFO';
            log_message($log_type,'[REQ]'.'[GET ID]'.'[<<<]'.$_GET['id'] );
            
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
        alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function suara_pileg_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        if($this->session->userdata('jabatan') == 'saksi' || $_POST['id_data_tps'] == "0000"){
            $books = $this->m_masterdata->get_suara_pilegs();
        }else{
            $books = $this->m_masterdata->get_suara_pilegss($_POST['id_data_tps']);
        }

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_suara,
                $r->nama,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $r->nama_tps,
                $r->suara,
                $r->waktu_input,
                $r->dokumen,

            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $books->num_rows(),
            "recordsFiltered" => $books->num_rows(),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }


    public function rekap_suara_paslon()
    {
        if ($this->session->userdata('jabatan') !== 'saksi') {
            $data = array('isi' => 'masterdata/rekap_pileg');
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
        alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function rekap_pileg_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $caleg  = $this->m_masterdata->get_calegs();

        $data = array();

        foreach ($caleg->result() as $r) {
            $suara =  $this->m_masterdata->get_suara_pilegs_sum($r->id_caleg);
            $tot = 0;

            foreach ($suara->result() as $s) {
                $tot += $s->suara;
            }

            $data[] = array(
                $r->id_caleg,
                $r->nama,
                $tot
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $caleg->num_rows(),
            "recordsFiltered" => $caleg->num_rows(),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }

    public function data_c1()
    {
        $data = array('isi' => 'masterdata/data_c1_view');
        $this->load->view('layouts/wrapper', $data);
    }

    public function edit_suara($id_suara)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_suara');
        $data['data_calon'] = $this->m_masterdata->get_allCalon();
        $data['data_tps'] = $this->m_masterdata->get_allTps();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_suara'] = $this->m_masterdata->get_suara($id_suara);
        $data['data_suara_join'] = $this->m_masterdata->get_suara_join($id_suara);
        $this->load->view('layouts/wrapper', $data);
    }



    public function add_c1()
    {
        $i = $this->input;
        $nm_image = rand();
        if (!empty($_FILES["image"]["name"])) {
            $config['upload_path'] = './uploads/c1';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['max_size'] = 10000;
            $config['file_name'] = $nm_image;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                echo $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $nm_image = $nm_image . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $data = array(
                    'id_kec' => $i->post('id_kecamatan'),
                    'id_kel' => $i->post('id_kelurahan'),
                    'id_tps' => $i->post('id_tps'),
                    'id_jenis' => $i->post('id_jenis'),
                    'dokumen' => $nm_image,
                );

                $cek = $this->db->insert('data_c1', $data);
            }

            echo json_encode('sukses');
        }
    }
}
