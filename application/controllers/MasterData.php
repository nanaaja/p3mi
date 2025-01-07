<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

class MasterData extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_masterdata');
        $this->load->model('m_user');
        $this->load->library('excel');
		$this->load->library('pdfgenerator');
		$this->load->library('MYPDF');
        $this->apk = $this->m_masterdata->get_konfig(0);
        $this->dpt = $this->m_masterdata->get_dpt(0);
        $this->paslon = $this->m_masterdata->get_caleg($this->apk[0]->id_paslon);

        if ($this->session->userdata('is_login') !== true) {
            redirect(site_url("Login"));
        }
    }

    public function paslon()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_caleg');
            $data['data_partai'] = $this->m_masterdata->get_allPartai();
            $data['data_tps'] = $this->m_masterdata->get_allTps();
            $data['data_jenis'] = $this->m_masterdata->get_allJenis();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kota'] = $this->m_masterdata->get_allKabupaten();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function dashboard()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/dashboard');

            // $data['tps'] = $this->m_masterdata->tps();
            // $data['partai'] = $this->m_masterdata->partai();
            // $data['demo_koordinator'] = $this->m_masterdata->demo_koordinator();
            // $data['demo_korcam'] = $this->m_masterdata->demo_korcam();
            // $data['demo_saksi'] = $this->m_masterdata->demo_saksi();
            // $data['demo_pendukung'] = $this->m_masterdata->demo_pendukung();
            // $data['demo_relawan'] = $this->m_masterdata->demo_relawan();
            // $data['jml_dukungan'] = (int)$this->m_masterdata->jml_dukungan()[0]->tot_dukungan;
            // $data['jml_dpt'] = (int)$this->m_masterdata->get_dpt(0)[0]->jml_dpt_lk + (int)$this->m_masterdata->get_dpt(0)[0]->jml_dpt_p;
            // $data['jml_tps'] =   $this->m_masterdata->total_tps();
            // $data['jml_tps_terisi'] =   $this->m_masterdata->total_tps_sudah_terisi();
            // $data['suara_real'] = (int)$this->m_masterdata->suara_pemilu()[0]->tot_suara;

            // $list_nama_kota = [];
            // $array_list = [];
            // $list_kota = $this->m_masterdata->get_allKecamatanKabTangerang();
            // foreach ($list_kota as $r) {
            //     $list = $this->m_masterdata->get_allCalonByKota($r->id_kec);
            //     array_push($list_nama_kota, $r->nama_kec);
            //     array_push($array_list, $list);
            // }

            // $data['list_nama_kota'] = $list_nama_kota;
            // $data['list_per_kota'] = $array_list;


            // $suara = [];

            // $calon = [];
            // $list_calon =  $this->m_masterdata->get_allCalon();
            // foreach ($list_calon as $val) {
            //     array_push($calon, $val->nama);
            //     $suara_data =  $this->m_masterdata->suara_calon($val->id_caleg);
            //     array_push($suara, (int)$suara_data[0]->tot_suara);
            // }

            // $data['list_paslon'] = $calon;
            // $data['suara'] = $suara;
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }
    public function grafik_rel_per_wil()
    {
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/grafik_rel_per_wil');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();


            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_prov);
                    $jml_data =  $this->m_masterdata->jml_relawan_per($val->id_prov, 1);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kab);
                    $jml_data =  $this->m_masterdata->jml_relawan_per($val->id_kab, 2);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kec);
                    $jml_data =  $this->m_masterdata->jml_relawan_per($val->id_kec, 3);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kel);
                    $jml_data =  $this->m_masterdata->jml_relawan_per($val->id_kel, 4);
                    array_push($jml, (int)$jml_data);
                }

                // var_dump($jml_data);die;
            }

            $data['list'] = $list;
            $data['jml'] = $jml;
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function grafik_suara_real_per_wil()
    {
        if ($this->session->userdata('jabatan') == 'saksi' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/grafik_suara_real_per_wil');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['paslon'] =  $this->m_masterdata->get_allCalon();

            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();
                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon(null, 1, $val->id_caleg);

                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);

                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 2, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);
                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 3, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);

                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 4, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 5) {
                $data['wilayah'] = $this->m_masterdata->get_allTpsByKel($_GET['id']);

                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(4, $_GET['id']);

                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 5, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            }

            $data['list'] = $list;
            $data['jml'] = $jml;

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function grafik_suara_real_vs_pendukung()
    {
        if ($this->session->userdata('jabatan') == 'saksi' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/grafik_suara_real_vs_pendukung');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['paslon'] =  $this->m_masterdata->get_allCalon();

            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();
                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon(null, 1, $val->id_caleg);

                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);

                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 2, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);
                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 3, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);

                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 4, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            } elseif ($_GET['level'] == 5) {
                $data['wilayah'] = $this->m_masterdata->get_allTpsByKel($_GET['id']);

                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(4, $_GET['id']);

                foreach ($data['paslon']  as $val) {
                    array_push($list, $val->nama);
                    $jml_data =  $this->m_masterdata->jml_real_count_per_paslon($_GET['id'], 5, $val->id_caleg);
                    array_push($jml, (int)$jml_data[0]->s);
                }
            }

            $data['list'] = $list;
            $data['jml'] = $jml;

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function grafik_pendukung_by_relawan()
    {
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/grafik_pendukung_by_relawan');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['relawan'] =  $this->m_masterdata->get_allRelawan();

            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();
                foreach ($data['relawan']  as $val) {
                    array_push($list, $val->nama_relawan);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_by_rel(null, 1, $val->id_relawan);

                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);

                foreach ($data['relawan']  as $val) {
                    array_push($list, $val->nama_relawan);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_by_rel($_GET['id'], 2, $val->id_relawan);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);
                foreach ($data['relawan']  as $val) {
                    array_push($list, $val->nama_relawan);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_by_rel($_GET['id'], 3, $val->id_relawan);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);

                foreach ($data['relawan']  as $val) {
                    array_push($list, $val->nama_relawan);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_by_rel($_GET['id'], 4, $val->id_relawan);
                    array_push($jml, (int)$jml_data);
                }
            }

            $data['list'] = $list;
            $data['jml'] = $jml;

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function grafik_suara_pendukung_per_wil()
    {

        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'relawan'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/grafik_suara_pendukung_per_wil');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();


            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_prov);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_prov, 1);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);


                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kab);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_kab, 2);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);


                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kec);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_kec, 3);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);

                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kel);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_kel, 4);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 5) {
                $data['wilayah'] = $this->m_masterdata->get_allTpsByKel($_GET['id']);

                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(4, $_GET['id']);

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_tps);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_tps, 5);
                    array_push($jml, (int)$jml_data);
                }
            }

            $data['list'] = $list;
            $data['jml'] = $jml;
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function grafik_suara_pendukung_per_wil_vs_dpt()
    {
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'koordinator'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/grafik_suara_pendukung_per_wil_vs_dpt');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['jml_dpt'] = (int)$this->m_masterdata->get_dpt(0)[0]->jml_dpt_lk + (int)$this->m_masterdata->get_dpt(0)[0]->jml_dpt_p;
            $data['jml_dukungan'] = (int)$this->m_masterdata->jml_dukungan()[0]->tot_dukungan;

            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_prov);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_prov, 1);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);


                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kab);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_kab, 2);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);


                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kec);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_kec, 3);
                    array_push($jml, (int)$jml_data);
                }
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);

                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);

                foreach ($data['wilayah']  as $val) {
                    array_push($list, $val->nama_kel);
                    $jml_data =  $this->m_masterdata->jml_suara_pendukung_per($val->id_kel, 4);
                    array_push($jml, (int)$jml_data);
                }
            }

            $data['list'] = $list;
            $data['jml'] = $jml;
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }


    public function caleg_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $books = $this->m_masterdata->get_calegs();

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_caleg,
                $r->nama,
                $r->no_urut,
                // $r->nama_partai,
                $r->nama_kab,
                $r->photo,
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



    public function add_caleg()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        $nm_image = rand();
        if ($tipe_form == "add") {
            if (!empty($_FILES["image"]["name"])) {
                $config['upload_path'] = './uploads/foto';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 2000;
                $config['file_name'] = $nm_image;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $nm_image = $nm_image . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                    $data = array(
                        'nama' => $i->post('nama'),
                        'no_urut' => $i->post('no_urut'),
                        // 'id_partai' => $i->post('id_partai'),
                        'id_kab' => $i->post('id_kab'),
                        'photo' => $nm_image,
                    );

                    $cek = $this->db->insert('data_caleg', $data);
                }
            } else {
                $data = array(
                    'nama' => $i->post('nama'),
                    'no_urut' => $i->post('no_urut'),
                    // 'id_partai' => $i->post('id_partai'),
                    'id_kab' => $i->post('id_kab'),
                );

                $cek = $this->db->insert('data_caleg', $data);
            }
        } else {
            $id_caleg = $i->post('id_caleg');

            if (!empty($_FILES["image"]["name"])) {
                $config['upload_path'] = './uploads/foto';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 2000;
                $config['file_name'] = $nm_image;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $nm_image = $nm_image . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                    $data = array(
                        'nama' => $i->post('nama'),
                        'no_urut' => $i->post('no_urut'),
                        'id_partai' => $i->post('id_partai'),
                        'id_kab' => $i->post('id_kab'),
                        'photo' => $nm_image,
                    );
                }
            } else {
                $data = array(
                    'nama' => $i->post('nama'),
                    'no_urut' => $i->post('no_urut'),
                    'id_partai' => $i->post('id_partai'),
                    'id_kab' => $i->post('id_kab'),
                );
            }

            $cek = $this->m_masterdata->update_caleg($id_caleg, $data);
        }

        echo json_encode('sukses');
    }

    public function edit_paslon($id_peserta)
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $i = $this->input;
            $data = array('isi' => 'masterdata/edit_caleg');
            $data['data_caleg'] = $this->m_masterdata->get_caleg($id_peserta);
            $data['data_partai'] = $this->m_masterdata->get_allPartai();
            $data['data_tps'] = $this->m_masterdata->get_allTps();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kota'] = $this->m_masterdata->get_allKabupaten();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function hapus_caleg()
    {
        $i = $this->input;
        $id_caleg = $i->post('id_caleg');
        $hapus_data = $this->db->delete('data_caleg', array('id_caleg' => $id_caleg));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    public function dapil()
    {
        $data = array('isi' => 'masterdata/data_dapil');
        $this->load->view('layouts/wrapper', $data);
    }


    public function dapil_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_dapils();

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_dapil,
                $r->nama_dapil,
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

    public function partai()
    {
        $data = array('isi' => 'masterdata/data_partai');
        $this->load->view('layouts/wrapper', $data);
    }

    public function partai_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_partais();

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_partai,
                $r->nama_partai,
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

    public function add_partai()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'nama_partai' => $i->post('nama_partai'),
            );
            $cek = $this->db->insert('data_partai', $data);
        } else {
            $data = array(
                'nama_partai' => $i->post('nama_partai'),
            );
            $cek = $this->m_masterdata->update_partai($i->post('id_partai'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_partai($id_partai)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_partai');
        $data['data_partai'] = $this->m_masterdata->get_partai($id_partai);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_partai()
    {
        $i = $this->input;
        $id_partai = $i->post('id_partai');
        $hapus_data = $this->db->delete('data_partai', array('id_partai' => $id_partai));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }


    public function tps()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_tps');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function saksi()
    {
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'koordinator'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/data_saksi');
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }


    public function tps_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_tpss();


        $data = array();

        foreach ($books->result() as $r) {

            $ls = $this->m_masterdata->get_saksi_by_tps($r->id_tps);
            $saksis = '';
            foreach ($ls as $l) {
                $saksis .= $l->nama . ', <br>';
            }
			
			//$relawan = $this->m_masterdata->get_relawan_by_tps($r->id_tps);
            //$relawans = '';
            //foreach ($relawan as $rl) {
            //    $relawans .= $rl->nama . ', <br>';
            //}
            $data[] = array(
                $r->id_tps,
                $r->no_tps,
                $r->nama_tps,
                $r->alamat,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $r->dpt,
                $saksis,
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
    public function saksi_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_saksis();


        $data = array();

        foreach ($books->result() as $r) {

            $ls = $this->m_masterdata->get_saksi_by_tps($r->id_tps);
            $saksis = '';
            foreach ($ls as $l) {
                $saksis .= $l->nama . ', <br>';
            }
            $data[] = array(
                $r->id_user,
                $r->nama,
                $r->nik,
                $r->jk,
                $r->no_hp,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $r->no_tps,
                $r->nama_tps,
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

    public function add_tps()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'nama_tps' => $i->post('nama_tps'),
                'no_tps' => $i->post('no_tps'),
                'alamat' => $i->post('alamat'),
                'id_kel' => $i->post('id_kelurahan'),
                'dpt' => $i->post('dpt'),
            );
            $cek = $this->db->insert('data_tps', $data);
        } else {
            $data = array(
                'nama_tps' => $i->post('nama_tps'),
                'no_tps' => $i->post('no_tps'),
                'alamat' => $i->post('alamat'),
                'id_kel' => $i->post('id_kelurahan'),
                'dpt' => $i->post('dpt'),

            );
            $cek = $this->m_masterdata->update_tps($i->post('id_tps'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_tps($id_tps)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_tps');
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_tps'] = $this->m_masterdata->get_tps($id_tps);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_tps()
    {
        $i = $this->input;
        $id_tps = $i->post('id_tps');
        $hapus_data = $this->db->delete('data_tps', array('id_tps' => $id_tps));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }



    public function pendukung()
    { 
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'korcam'|| $this->session->userdata('jabatan') == 'viewer'|| $this->session->userdata('jabatan') == 'koordinator' || $this->session->userdata('jabatan') == 'relawan'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/data_pendukung');
            if ($this->session->userdata('jabatan') == 'relawan'){
                $data['data_tps'] = $this->m_masterdata->getTpsDetail($this->session->userdata('id_tps'));
                $data['data_relawan'] = $this->m_masterdata->get_allRelawanDetail($this->session->userdata('id_user'));
				if($_GET['id'] == null || $_GET['id'] == ""){
                    $data['id_data_tps'] = "0000";
                }else{
                    $data['id_data_tps'] = $_GET['id'];
                }
            }else{
                $data['data_tps'] = $this->m_masterdata->getTpsGlobal();
                $data['data_relawan'] = $this->m_masterdata->get_allRelawan();
				if($_GET['id'] == null || $_GET['id'] == ""){
                    $data['id_data_tps'] = "0000";
                }else{
                    $data['id_data_tps'] = $_GET['id'];
                }
            }
            
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function pendukung_page()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        if($this->session->userdata('jabatan') == 'relawan' || $_POST['id_data_tps'] == "0000"){
            $books = $this->m_masterdata->get_pendukungs();
        }else{
            $books = $this->m_masterdata->get_pendukungss($_POST['id_data_tps']);
        }

        $data = array();

        foreach ($books->result() as $r) {
            if($r->status == "0"){
                $status = "Pending";
            }else{
                $status = "Berhasil";
            }
            $data[] = array(
                $r->id_pendukung,
                $r->nama,
                $r->nik,
                $r->jk,
                $r->alamat,
                $r->umur,
                $r->no_hp,
                $r->nama_relawan,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $r->nama_tps,
                // $r->norek,
                // $r->nama_bank,
                // $r->jenis_bayar,
                $status,
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

        //versi ssr
        // $this->load->model('m_pendukung_ss');

        // // Mendapatkan parameter dari DataTables
        // $postData = $this->input->post();

        // // Meminta data ke model
        // $data = $this->m_pendukung_ss->get_datatables_data($postData);

        // echo json_encode($data);
    }

    public function add_pendukung()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');
        $nm_dokumen = rand();
        $nm_dokumen_ktp = rand();
        

        if ($tipe_form == "add") {
			$check_jumlah_pendukung = $this->db->query("SELECT COUNT(id_pendukung) as totals FROM data_pendukung WHERE id_relawan='".$i->post('id_relawan')."'")->row();
            
            if($check_jumlah_pendukung->totals >= 50){
                $log_type = 'ERROR';
                log_message($log_type,'[REQ]'.'[check_jumlah_pendukung]'.'[<<<]'.$check_jumlah_pendukung->totals.'|'.$i->post('id_relawan'));
                echo json_encode('GAGAL');
            }else{
				if (!empty($_FILES["dokumen"]["name"])) {
					$config['upload_path'] = './uploads/bukti';
					$config['allowed_types'] = 'jpg|png|jpeg|pdf';
					$config['max_size'] = 30000;
					$config['file_name'] = $nm_dokumen;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('dokumen')) {
						echo $this->upload->display_errors();
					} else {
						$data = $this->upload->data();
						$nm_dokumen = $nm_dokumen . '.' . pathinfo($_FILES["dokumen"]["name"], PATHINFO_EXTENSION);
						$data = array(
							'nama' => $i->post('nama_pendukung'),
							'nik' => $i->post('nik'),
							'alamat' => $i->post('alamat'),
							'umur' => $i->post('umur'),
							'jk' => $i->post('jk'),
							'id_tps' => $i->post('id_tps'),
							'id_relawan' => $i->post('id_relawan'),
							'no_hp' => $i->post('no_hp'),
							'id_user' => $this->session->userdata('id_user'),
							'norek' => "0",
							'nama_bank' => "-",
							'jenis_bayar' => "-",
							'status' => "0",
							'dokumen_ktp' => null,
							'dokumen' => $nm_dokumen,
						);
						$cek = $this->db->insert('data_pendukung', $data);
					}
				}elseif (!empty($_FILES["dokumen_ktp"]["name"])) {
					$config['upload_path'] = './uploads/ktp';
					$config['allowed_types'] = 'jpg|png|jpeg|pdf';
					$config['max_size'] = 30000;
					$config['file_name'] = $nm_dokumen_ktp;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('dokumen_ktp')) {
						echo $this->upload->display_errors();
					} else {
						$data = $this->upload->data();
						$nm_dokumen_ktp = $nm_dokumen_ktp . '.' . pathinfo($_FILES["dokumen_ktp"]["name"], PATHINFO_EXTENSION);
						$data = array(
							'nama' => $i->post('nama_pendukung'),
							'nik' => $i->post('nik'),
							'alamat' => $i->post('alamat'),
							'umur' => $i->post('umur'),
							'jk' => $i->post('jk'),
							'id_tps' => $i->post('id_tps'),
							'id_relawan' => $i->post('id_relawan'),
							'no_hp' => $i->post('no_hp'),
							'id_user' => $this->session->userdata('id_user'),
							'norek' => "0",
							'nama_bank' => "-",
							'jenis_bayar' => "-",
							'status' => "0",
							'dokumen_ktp' => $nm_dokumen_ktp,
							'dokumen' => null,
						);
						$cek = $this->db->insert('data_pendukung', $data);
					}
				}else{
					$data = array(
						'nama' => $i->post('nama_pendukung'),
						'nik' => $i->post('nik'),
						'alamat' => $i->post('alamat'),
						'umur' => $i->post('umur'),
						'jk' => $i->post('jk'),
						'id_tps' => $i->post('id_tps'),
						'id_relawan' => $i->post('id_relawan'),
						'no_hp' => $i->post('no_hp'),
						'id_user' => $this->session->userdata('id_user'),
						'norek' => "0",
						'nama_bank' => "-",
						'jenis_bayar' => "-",
						'status' => "0",
						'dokumen_ktp' => null,
						'dokumen' => null,
					);
					$cek = $this->db->insert('data_pendukung', $data);
				}
			}
        } else {
            $data = array(
                'nama' => $i->post('nama_pendukung'),
                'nik' => $i->post('nik'),
                'alamat' => $i->post('alamat'),
                'umur' => $i->post('umur'),
                'jk' => $i->post('jk'),
                'id_tps' => $i->post('id_tps'),
                'no_hp' => $i->post('no_hp'),
                'id_relawan' => $i->post('id_relawan'),
                'norek' => "0",
                'nama_bank' => "-",
                'jenis_bayar' => "-",
                'status' => "0",
            );
            $cek = $this->m_masterdata->update_pendukung($i->post('id_pendukung'), $data);
        }

        echo json_encode('sukses');
    }
	
    public function get_pendukung()
    {
        $i = $this->input;
        $data = $this->m_masterdata->get_pendukung($i->post('id_pendukung'));
        echo json_encode($data);
    }

    public function hapus_pendukung()
    {
        $i = $this->input;
        $id_pendukung = $i->post('id_pendukung');
        $hapus_data = $this->db->delete('data_pendukung', array('id_pendukung' => $id_pendukung));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    public function relawan()
    {
        if ($this->session->userdata('jabatan') == 'superadmin'|| $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'koordinator'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/data_relawan');
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            if ($this->session->userdata('jabatan') == 'koordinator'){
                $data['data_koordinator'] = $this->m_masterdata->get_allKoordinators($this->session->userdata('id_user'));
                $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahans($this->session->userdata('id_user'));
            }else{
                $data['data_koordinator'] = $this->m_masterdata->get_allKoordinator();
                $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            }

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function relawan_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_relawans();

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_relawan,
                $r->nama_relawan,
                $r->nik,
                $r->jk,
                $r->usia,
                $r->nohp,
                $r->nama_koordinator,
				$r->nama_kec,
				$r->nama_kel,
                //$r->nama_kel . ' / ' . $r->nama_kec . ' / ' . $r->nama_kab . ' / ' . $r->nama_prov,
				$r->nama_tps,
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

    public function add_relawan()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');
        if ($tipe_form == "add") {
            $query = $this->db->query("SELECT * FROM user ORDER BY id_user DESC LIMIT 1");
            $result = $query->row();
            $id_user = $result->id_user;

            //CEK USERNAME
            $query_user = $this->db->query("SELECT * FROM user WHERE username = '".$i->post('usernames')."'");
            $result_user = $query_user->row();

            //CEK NIK
            $query_nik = $this->db->query("SELECT * FROM data_relawan WHERE nik = '".$i->post('nik')."'");
            $result_nik = $query_nik->row();
            if($result_user != "" || $result_user != null){
                echo json_encode('GAGAL');
            }else if($result_nik != "" || $result_nik != null){
                echo json_encode('GAGAL'); 
            }else{
                $data_user = array(
                    'id_user' => $id_user+1,
                    'username' => $i->post('usernames'),
                    'nama' => $i->post('nama_relawan'),
                    'id_tps' => $i->post('id_tps'),
                    'jk' => $i->post('jk'),
                    'no_hp' => $i->post('no_telp'),
                    'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
                    'jabatan' => "relawan",
    
                );
                $cek_data_user = $this->db->insert('user', $data_user);
    
                $data = array(
                    'nama_relawan' => $i->post('nama_relawan'),
                    'nik' => $i->post('nik'),
                    'jk' => $i->post('jk'),
                    'usia' => $i->post('usia'),
                    'no_telp' => $i->post('no_telp'),
                    'id_kel' => $i->post('id_kelurahan'),
                    'id_koordinator' => $i->post('id_koordinator'),
                    'id_user' => $id_user + 1,
    
                );
                $cek = $this->db->insert('data_relawan', $data);
            }

            
        } else {
            $update_data_user = array(
                'username' => $i->post('usernames'),
                'nama' => $i->post('nama_relawan'),
                'id_tps' => $i->post('id_tps'),
                'jk' => $i->post('jk'),
                'no_hp' => $i->post('no_telp'),
                'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
                'jabatan' => "relawan",

            );
            $data_user = $this->m_masterdata->update_user($i->post('id_user'), $update_data_user);

            $data = array(
                'nama_relawan' => $i->post('nama_relawan'),
                'nik' => $i->post('nik'),
                'jk' => $i->post('jk'),
                'usia' => $i->post('usia'),
                'no_telp' => $i->post('no_telp'),
                'id_kel' => $i->post('id_kelurahan'),
                'id_koordinator' => $i->post('id_koordinator'),
            );
            $cek = $this->m_masterdata->update_relawan($i->post('id_relawan'), $data);
        }

        echo json_encode('sukses');
    }

    public function get_relawan()
    {
        $i = $this->input;
        $data = $this->m_masterdata->get_relawanss($i->post('id_relawan'));
        echo json_encode($data);
    }

    public function hapus_relawan()
    {
        $i = $this->input;
        $id_relawan = $i->post('id_relawan');
        $query = $this->db->query("SELECT * FROM data_relawan WHERE id_relawan = '".$i->post('id_relawan')."'");
        $result = $query->row();
        $id_user = $result->id_user;

        $hapus_data = $this->db->delete('data_relawan', array('id_relawan' => $id_relawan));
        $hapus_user = $this->db->delete('user', array('id_user' => $id_user));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    public function koordinator()
    {
        if ($this->session->userdata('jabatan') == 'superadmin'|| $this->session->userdata('jabatan') == 'viewer' || $this->session->userdata('jabatan') == 'korcam'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/data_koordinator');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function koordinator_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_koordinatorss();

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_koordinator,
                $r->nama_koordinator,
                $r->nik,
                $r->jk,
                $r->alamat,
                $r->no_telp,
				$r->nama_kec,
                $r->nama_kel,
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

    public function add_koordinator()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');
        $log_type = 'ERROR';
        log_message($log_type,'[REQ]'.'[AWAL]'.'[<<<]'."WKWKWKWKWKWKW");
        if ($tipe_form == "add") {
            $query = $this->db->query("SELECT * FROM user ORDER BY id_user DESC LIMIT 1");
            $result = $query->row();
            $id_user = $result->id_user;

            //CEK USERNAME
            $query_user = $this->db->query("SELECT * FROM user WHERE username = '".$i->post('usernames')."'");
            $result_user = $query_user->row();

            //CEK NIK
            $query_nik = $this->db->query("SELECT * FROM data_koordinator WHERE nik = '".$i->post('nik')."'");
            $result_nik = $query_nik->row();
            if($result_user != "" || $result_user != null){
                echo json_encode('GAGAL');
            }else if($result_nik != "" || $result_nik != null){
                echo json_encode('GAGAL'); 
            }else{
				$data_user = array(
					'id_user' => $id_user+1,
					'username' => $i->post('username'),
					'nama' => $i->post('nama_koordinator'),
					'id_tps' => 40,
					'jk' => $i->post('jk'),
					'no_hp' => $i->post('no_telp'),
					'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
					'jabatan' => "koordinator",

				);
				$cek_data_user = $this->db->insert('user', $data_user);

				$data = array(
					'nama_koordinator' => $i->post('nama_koordinator'),
					'nik' => $i->post('nik'),
					'jk' => $i->post('jk'),
					'alamat' => $i->post('alamat'),
					'no_telp' => $i->post('no_telp'),
					'id_kel' => $i->post('id_kelurahan'),
					'id_user' => $id_user+1,

				);
				$cek = $this->db->insert('data_koordinator', $data);
			}
        } else {
            if (!empty($i->post('password'))) {
                $update_data_user = array(
                    'username' => $i->post('username'),
                    'nama' => $i->post('nama_koordinator'),
                    'id_tps' => 40,
                    'jk' => $i->post('jk'),
                    'no_hp' => $i->post('no_telp'),
                    'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
                    'jabatan' => "koordinator",

                );
                $data_user = $this->m_masterdata->update_user($i->post('id_user'), $update_data_user);
            }else{
                $update_data_user = array(
                    'username' => $i->post('username'),
                    'nama' => $i->post('nama_koordinator'),
                    'id_tps' => 40,
                    'jk' => $i->post('jk'),
                    'no_hp' => $i->post('no_telp'),
                    'jabatan' => "koordinator",

                );
                $data_user = $this->m_masterdata->update_user($i->post('id_user'), $update_data_user);
            }

            $data = array(
                'nama_koordinator' => $i->post('nama_koordinator'),
                'nik' => $i->post('nik'),
                'jk' => $i->post('jk'),
                'alamat' => $i->post('alamat'),
                'no_telp' => $i->post('no_telp'),
                'id_kel' => $i->post('id_kelurahan'),

            );
            $cek = $this->m_masterdata->update_koordinator($i->post('id_koordinator'), $data);
        }

        echo json_encode('sukses');
    }
    public function get_koordinator()
    {
        $i = $this->input;
        $data = $this->m_masterdata->get_koordinator($i->post('id_koordinator'));
        echo json_encode($data);
    }

    public function hapus_koordinator()
    {
        $i = $this->input;
        $id_koordinator = $i->post('id_koordinator');
        $hapus_data = $this->db->delete('data_koordinator', array('id_koordinator' => $id_koordinator));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    public function korcam()
    {
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'korcam' || $this->session->userdata('jabatan') == 'viewer'|| $this->session->userdata('jabatan') == 'admin_it') {
            $data = array('isi' => 'masterdata/data_korcam');
            $data['data_kecamatan'] = $this->m_masterdata->get_kecamatan();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function korcam_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_korcamss();

        $data = array();

        foreach ($books->result() as $r) {
            $data[] = array(
                $r->id_koordinator,
                $r->nama_koordinator,
                $r->nik,
                $r->jk,
                $r->alamat,
                $r->no_telp,
                $r->nama_kec,
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

    public function add_korcam()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');
        $log_type = 'ERROR';
        log_message($log_type,'[REQ]'.'[AWAL]'.'[<<<]'."WKWKWKWKWKWKW");
        if ($tipe_form == "add") {
            $query = $this->db->query("SELECT * FROM user ORDER BY id_user DESC LIMIT 1");
            $result = $query->row();
            $id_user = $result->id_user;

            //CEK USERNAME
            $query_user = $this->db->query("SELECT * FROM user WHERE username = '".$i->post('usernames')."'");
            $result_user = $query_user->row();

            //CEK NIK
            $query_nik = $this->db->query("SELECT * FROM data_korcam WHERE nik = '".$i->post('nik')."'");
            $result_nik = $query_nik->row();
            if($result_user != "" || $result_user != null){
                echo json_encode('GAGAL');
            }else if($result_nik != "" || $result_nik != null){
                echo json_encode('GAGAL'); 
            }else{
				$data_user = array(
					'id_user' => $id_user+1,
					'username' => $i->post('username'),
					'nama' => $i->post('nama_koordinator'),
					'id_tps' => 40,
					'jk' => $i->post('jk'),
					'no_hp' => $i->post('no_telp'),
					'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
					'jabatan' => "korcam",

				);
				$cek_data_user = $this->db->insert('user', $data_user);

				$data = array(
					'nama_koordinator' => $i->post('nama_koordinator'),
					'nik' => $i->post('nik'),
					'jk' => $i->post('jk'),
					'alamat' => $i->post('alamat'),
					'no_telp' => $i->post('no_telp'),
					'id_kec' => $i->post('id_kecamatan'),
					'id_user' => $id_user+1,

				);
				$cek = $this->db->insert('data_korcam', $data);
			}
        } else {
            if (!empty($i->post('password'))) {
                $update_data_user = array(
                    'username' => $i->post('username'),
                    'nama' => $i->post('nama_koordinator'),
                    'id_tps' => 40,
                    'jk' => $i->post('jk'),
                    'no_hp' => $i->post('no_telp'),
                    'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
                    'jabatan' => "korcam",

                );
                $data_user = $this->m_masterdata->update_user($i->post('id_user'), $update_data_user);
            }else{
                $update_data_user = array(
                    'username' => $i->post('username'),
                    'nama' => $i->post('nama_koordinator'),
                    'id_tps' => 40,
                    'jk' => $i->post('jk'),
                    'no_hp' => $i->post('no_telp'),
                    'jabatan' => "koordinator",

                );
                $data_user = $this->m_masterdata->update_user($i->post('id_user'), $update_data_user);
            }

            $data = array(
                'nama_koordinator' => $i->post('nama_koordinator'),
                'nik' => $i->post('nik'),
                'jk' => $i->post('jk'),
                'alamat' => $i->post('alamat'),
                'no_telp' => $i->post('no_telp'),
                'id_kec' => $i->post('id_kecamatan'),

            );
            $cek = $this->m_masterdata->update_korcam($i->post('id_koordinator'), $data);
        }

        echo json_encode('sukses');
    }
    public function get_korcam()
    {
        $i = $this->input;
        $data = $this->m_masterdata->get_korcam($i->post('id_koordinator'));
        echo json_encode($data);
    }

    public function hapus_korcam()
    {
        $i = $this->input;
        $id_koordinator = $i->post('id_koordinator');
        $hapus_data = $this->db->delete('data_korcam', array('id_koordinator' => $id_koordinator));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }


    public function dpt()
    {
        if ($this->session->userdata('jabatan') == 'superadmin' || $this->session->userdata('jabatan') == 'korcam') {
            $data = array('isi' => 'masterdata/data_dpt');
            $data['dpt'] = $this->m_masterdata->get_dpt(0);
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function add_dpt()
    {
        $i = $this->input;

        $data = array(
            'tipe' => $i->post('tipe_penggunaan'),
            'nama_kabkota' => $i->post('nama_kabkota'),
            'jml_kec' => $i->post('jml_kec'),
            'jml_kel' => $i->post('jml_kel'),
            'jml_tps' => $i->post('jml_tps'),
            'jml_dpt_lk' => $i->post('jml_dpt_lk'),
            'jml_dpt_p' => $i->post('jml_dpt_p'),
        );
        $this->m_masterdata->update_dpt($i->post('id_dpt'), $data);
        echo json_encode('sukses');
    }
    public function konfig()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_konfig');
            $data['konfig'] = $this->m_masterdata->get_konfig(0);
            $data['data_calon'] = $this->m_masterdata->get_allCalon();

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function add_konfig()
    {
        $i = $this->input;

        $data = array(
            'nama_apk' => $i->post('nama_apk'),
        );
        $this->m_masterdata->update_konfig($i->post('id_konfig'), $data);
        echo json_encode('sukses');
    }
    public function change_skin()
    {
        $i = $this->input;
        $data = array(
            'warna_tema' => $i->post('warna_tema'),
        );
        $this->m_masterdata->update_konfig(0, $data);
        echo json_encode('sukses');
    }

    public function pengguna()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_pengguna');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }
    public function pengguna_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_penggunas();

        $data = array();
        $no=1;
        foreach ($books->result() as $r) {
            if($r->status == 1){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }
            $data[] = array(
                $r->id_user,
                $no,
                $r->username,
                $r->password,
                $r->nama,
                $r->jabatan,
                $r->create_date,
                $r->last_login,
                $status,
                null,
            );
            $no++;
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


    public function add_pengguna()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            //CEK USERNAME
            $query_user = $this->db->query("SELECT * FROM user WHERE username = '".$i->post('username')."'");
            $result_user = $query_user->row();

            if($result_user != "" || $result_user != null){
                echo json_encode('GAGAL');
            }else{
                $data = array(
                    'username' => $i->post('username'),
                    'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
                    'jabatan' => $i->post('grant'),
                    'nama' => $i->post('name'),
                    'create_date' => date('Y-m-d H:i:s'),
                    'last_login' => date('Y-m-d H:i:s'),
                    'status' => $i->post('status'),
                );
                $cek = $this->db->insert('user', $data);
            }  
        } else {
            if (!empty($i->post('password'))) {
                $data = array(
                    'username' => $i->post('username'),
                    'password' => password_hash($i->post('password'), PASSWORD_DEFAULT),
                    'jabatan' => $i->post('grant'),
                    'nama' => $i->post('name'),
                    'create_date' => date('Y-m-d H:i:s'),
                    'last_login' => date('Y-m-d H:i:s'),
                    'status' => $i->post('status'),
                );
            } else {
                $data = array(
                    'username' => $i->post('username'),
                    'jabatan' => $i->post('grant'),
                    'nama' => $i->post('name'),
                    'create_date' => date('Y-m-d H:i:s'),
                    'last_login' => date('Y-m-d H:i:s'),
                    'status' => $i->post('status'),

                );
            }

            $cek = $this->m_masterdata->update_pengguna($i->post('id_user'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_pengguna($id_pengguna)
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $i = $this->input;
            $data = array('isi' => 'masterdata/edit_pengguna');
            $data['data_pengguna'] = $this->m_masterdata->get_pengguna($id_pengguna);

            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function hapus_pengguna()
    {
        $i = $this->input;
        $id_user = $i->post('id_user');
        $hapus_data = $this->db->delete('user', array('id_user' => $id_user));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }



    public function get_kab_by_prov()
    {
        $i = $this->input;
        $id_prov = $i->post('id_prov');
        $data = $this->m_masterdata->get_allKabByProv($id_prov);
        $html = '';

        $html .= "<option value=''>Pilih Kabupaten / Kota</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->id_kab . ">" . $r->nama_kab . "</option>";
        }
        echo $html;
    }

    public function get_kec_by_kab()
    {
        $i = $this->input;
        $id_kab = $i->post('id_kabupaten');
        $data = $this->m_masterdata->get_allKecByKab($id_kab);
        $html = '';

        $html .= "<option value=''>Pilih Kecamatan</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->id_kec . ">" . $r->nama_kec . "</option>";
        }
        echo $html;
    }

    public function get_kel_by_kec()
    {
        $i = $this->input;
        $id_kecamatan = $i->post('id_kecamatan');
        $data = $this->m_masterdata->get_allKelurahanbyKec($id_kecamatan);
        $html = '';

        $html .= "<option value=''>Pilih Kelurahan</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->id_kel . ">" . $r->nama_kel . "</option>";
        }
        echo $html;
    }
    public function get_kel_by_tps()
    {
        $i = $this->input;
        $id_tps = $i->post('id_tps');
        $data = $this->m_masterdata->get_kel_by_tps($id_tps);
        echo $data[0]->id_kel;
    }

    public function get_tps_by_kel()
    {
        $i = $this->input;
        $id_kelurahan = $i->post('id_kelurahan');
        $data = $this->m_masterdata->get_allTpsByKel($id_kelurahan);
        $html = '';
        $html .= "<option value=''>Pilih Tps</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->id_tps . ">" . $r->nama_tps . "</option>";
        }
        echo $html;
    }
    public function get_detail_wil_by_id_kel()
    {
        $i = $this->input;
        $id_kelurahan = $i->post('id_kel');
        $data = $this->m_masterdata->get_detail_wil_by_id_kel($id_kelurahan);
        echo json_encode($data);
    }

    public function get_kab()
    {
        $i = $this->input;
        $data = $this->m_masterdata->get_allKabupaten();
        $html = '';

        $html .= "<option value=''>Pilih Kabupaten / Kota</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->id_kab . ">" . $r->nama_kab . "</option>";
        }
        echo $html;
    }

    public function get_prov()
    {
        $i = $this->input;
        $data = $this->m_masterdata->get_allProvinsi();
        $html = '';

        $html .= "<option value=''>Pilih Provinsi";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->id_prov . ">" . $r->nama_prov . "</option>";
        }
        echo $html;
    }



    public function data_wilayah()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_wilayah');
            $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();


            $list = [];
            $jml = [];

            if ($_GET['level'] == 1) {
                $data['wilayah'] = $this->m_masterdata->get_allProvinsi();
            } elseif ($_GET['level'] == 2) {
                $data['wilayah'] = $this->m_masterdata->get_allKabupatenByProv($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(1, $_GET['id']);
            } elseif ($_GET['level'] == 3) {
                $data['wilayah'] = $this->m_masterdata->get_allKecamatanByKota($_GET['id']);
                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(2, $_GET['id']);
            } elseif ($_GET['level'] == 4) {
                $data['wilayah'] = $this->m_masterdata->get_allKelurahanbyKec($_GET['id']);

                $data['detail_wilayah'] = $this->m_masterdata->get_wilayah(3, $_GET['id']);
            }

            $data['list'] = $list;
            $data['jml'] = $jml;
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
            alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }


    public function add_wilayah()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            if ($this->input->post('level') == 1) {
                $data = array(
                    'id_prov' => $i->post('id'),
                    'nama_prov' => $i->post('nama_wilayah'),
                );
                $cek = $this->db->insert('wilayah_provinsi', $data);
            } elseif ($this->input->post('level') == 2) {
                $data = array(
                    'id_kab' => $i->post('id'),
                    'nama_kab' => $i->post('nama_wilayah'),
                    'id_prov' => $i->post('param'),
                );
                $cek = $this->db->insert('wilayah_kabupaten', $data);
            } elseif ($this->input->post('level') == 3) {
                $data = array(
                    'id_kec' => $i->post('id'),
                    'nama_kec' => $i->post('nama_wilayah'),
                    'id_kab' => $i->post('param'),
                );
                $cek = $this->db->insert('wilayah_kecamatan', $data);
            } elseif ($this->input->post('level') == 4) {
                $data = array(
                    'id_kel' => $i->post('id'),
                    'nama_kel' => $i->post('nama_wilayah'),
                    'id_kec' => $i->post('param'),
                );
                $cek = $this->db->insert('wilayah_desa', $data);
            }
        } else {
            if ($this->input->post('level') == 1) {
                $data = array(
                    'id_prov' => $i->post('id'),
                    'nama_prov' => $i->post('nama_wilayah'),
                );
                $cek = $this->m_masterdata->update_wilayah_provinsi($i->post('id'), $data);
            } elseif ($this->input->post('level') == 2) {
                $data = array(
                    'id_kab' => $i->post('id'),
                    'nama_kab' => $i->post('nama_wilayah'),
                    'id_prov' => $i->post('param'),
                );
                $cek = $this->m_masterdata->update_wilayah_kabupaten($i->post('id'), $data);
            } elseif ($this->input->post('level') == 3) {
                $data = array(
                    'id_kec' => $i->post('id'),
                    'nama_kec' => $i->post('nama_wilayah'),
                    'id_kab' => $i->post('param'),
                );
                $cek = $this->m_masterdata->update_wilayah_kecamatan($i->post('id'), $data);
            } elseif ($this->input->post('level') == 4) {
                $data = array(
                    'id_kec' => $i->post('id'),
                    'nama_kel' => $i->post('nama_wilayah'),
                    'id_kec' => $i->post('param'),
                );
                $cek = $this->m_masterdata->update_wilayah_desa($i->post('id'), $data);
            }
        }

        echo json_encode('sukses');
    }
    public function get_wilayah()
    {
        $i = $this->input;
        if ($this->input->post('level') == 1) {
            $data = $this->m_masterdata->get_wilayah_provinsi($i->post('id'));
        } elseif ($this->input->post('level') == 2) {
            $data = $this->m_masterdata->get_wilayah_kabupaten($i->post('id'));
        } elseif ($this->input->post('level') == 3) {
            $data = $this->m_masterdata->get_wilayah_kecamatan($i->post('id'));
        } elseif ($this->input->post('level') == 4) {
            $data = $this->m_masterdata->get_wilayah_desa($i->post('id'));
        }
        echo json_encode($data);
    }

    public function hapus_wilayah()
    {
        $i = $this->input;
        $id = $i->post('id');
        if ($this->input->post('level') == 1) {
            $hapus_data = $this->db->delete('wilayah_provinsi', array('id_prov' => $id));
        } elseif ($this->input->post('level') == 2) {
            $hapus_data = $this->db->delete('wilayah_kabupaten', array('id_kab' => $id));
        } elseif ($this->input->post('level') == 3) {
            $hapus_data = $this->db->delete('wilayah_kecamatan', array('id_kec' => $id));
        } elseif ($this->input->post('level') == 4) {
            $hapus_data = $this->db->delete('wilayah_desa', array('id_kel' => $id));
        }
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }
	
	function generate_pdf()
    {
        $i = $this->input;
        $id_saksi = $_POST['id_saksi'];

        $data['data_saksi'] = $this->m_masterdata->getSaksiByTPS($id_saksi);
                
        //$this->load->library('pdfgenerator');
        //$data['title'] = "Data Random";
        $file_pdf = $data['data_saksi'][0]->nama."_".$data['data_saksi'][0]->nama_tps."_".$data['data_saksi'][0]->nama_kel.".pdf";
		
		$log_type = 'INFO';
        log_message($log_type,'[REQ]'.'[data_generated]'.'[<<<]'.$id_saksi."|".$file_pdf );
        if($data['data_saksi'][0]->nama_kec == "Balaraja"){
            $data['id_surat'] = "1";
        }else if($data['data_saksi'][0]->nama_kec == "Cikupa"){
            $data['id_surat'] = "2";
        }else if($data['data_saksi'][0]->nama_kec == "Cisauk"){
            $data['id_surat'] = "3";
        }else if($data['data_saksi'][0]->nama_kec == "Cisoka"){
            $data['id_surat'] = "4";
        }else if($data['data_saksi'][0]->nama_kec == "Curug"){
            $data['id_surat'] = "5";
        }else if($data['data_saksi'][0]->nama_kec == "Gunung Kaler"){
            $data['id_surat'] = "6";
        }else if($data['data_saksi'][0]->nama_kec == "Jambe"){
            $data['id_surat'] = "7";
        }else if($data['data_saksi'][0]->nama_kec == "Jayanti"){
            $data['id_surat'] = "8";
        }else if($data['data_saksi'][0]->nama_kec == "Kelapa Dua"){
            $data['id_surat'] = "9";
        }else if($data['data_saksi'][0]->nama_kec == "Kemiri"){
            $data['id_surat'] = "10";
        }else if($data['data_saksi'][0]->nama_kec == "Kresek"){
            $data['id_surat'] = "11";
        }else if($data['data_saksi'][0]->nama_kec == "Kronjo"){
            $data['id_surat'] = "12";
        }else if($data['data_saksi'][0]->nama_kec == "Kosambi"){
            $data['id_surat'] = "13";
        }else if($data['data_saksi'][0]->nama_kec == "Legok"){
            $data['id_surat'] = "14";
        }else if($data['data_saksi'][0]->nama_kec == "Mauk"){
            $data['id_surat'] = "15";
        }else if($data['data_saksi'][0]->nama_kec == "Mekarbaru"){
            $data['id_surat'] = "16";
        }else if($data['data_saksi'][0]->nama_kec == "Pagedangan"){
            $data['id_surat'] = "17";
        }else if($data['data_saksi'][0]->nama_kec == "Pakuhaji"){
            $data['id_surat'] = "18";
        }else if($data['data_saksi'][0]->nama_kec == "Panongan"){
            $data['id_surat'] = "19";
        }else if($data['data_saksi'][0]->nama_kec == "Pasarkemis"){
            $data['id_surat'] = "20";
        }else if($data['data_saksi'][0]->nama_kec == "Rajeg"){
            $data['id_surat'] = "21";
        }else if($data['data_saksi'][0]->nama_kec == "Sepatan"){
            $data['id_surat'] = "22";
        }else if($data['data_saksi'][0]->nama_kec == "Sepatan Timur"){
            $data['id_surat'] = "23";
        }else if($data['data_saksi'][0]->nama_kec == "Sindang Jaya"){
            $data['id_surat'] = "24";
        }else if($data['data_saksi'][0]->nama_kec == "Solear"){
            $data['id_surat'] = "25";
        }else if($data['data_saksi'][0]->nama_kec == "Sukadiri"){
            $data['id_surat'] = "26";
        }else if($data['data_saksi'][0]->nama_kec == "Sukamulya"){
            $data['id_surat'] = "27";
        }else if($data['data_saksi'][0]->nama_kec == "Teluk Naga"){
            $data['id_surat'] = "28";
        }else if($data['data_saksi'][0]->nama_kec == "Tigaraksa"){
            $data['id_surat'] = "29";
        }else{
            $data['id_surat']= "30";
        }
        // $log_type = 'INFO';
        // log_message($log_type,'[REQ]'.'[generate_pdf]'.'[<<<]'.$id_surat);
        // $paper = 'A4';
        // $orientation = "potrait";
        // $html = $this->load->view('masterdata/print_surat_mandat', $data, true);
        // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('PdfWithCodeigniter');
		$pdf->SetTitle('PdfWithCodeigniter');
		$pdf->SetSubject('PdfWithCodeigniter');
		$pdf->SetKeywords('TCPDF, PDF, example, test, codeigniter');

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set font
		$pdf->SetFont('times', '', 11);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
		// add a page
		$pdf->AddPage();

		// set some text to print
        // 		$txt = <<<EOD
        // 		TCPDF Codeigniter Example

        // 		Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
        // EOD;
        
        $html = $this->load->view('masterdata/print_surat_mandat', $data, true);
		// print a block of text using Write()
		$pdf->writeHTML($html, false, false, false, false, '');

		// ---------------------------------------------------------
		 ob_end_clean();
		//Close and output PDF document
		$pdf->Output('testing.pdf', 'I');
		
		$log_type = 'INFO';
        log_message($log_type,'[REQ]'.'[generate_pdf]'.'[<<<]'.$pdf);
    }
	
	public function print_saksi($id_saksi)
    {
		$log_type = 'INFO';
        log_message($log_type,'[REQ]'.'[generate_pdf]'.'[<<<]'.$id_saksi);
        $i = $this->input;
        $data['data_saksi'] = $this->m_masterdata->getSaksiByTPS($id_saksi);
        $nama_kec = $data['data_saksi'][0]->nama_kec;

        $file_pdf = $data['data_saksi'][0]->nama."_".$data['data_saksi'][0]->nama_tps."_".$data['data_saksi'][0]->nama_kel.".pdf";
        if(trim($nama_kec)== "Balaraja"){
            $data['id_surat'] = "1";
        }else if(trim($nama_kec) == "Cikupa"){
            $data['id_surat'] = "2";
        }else if(trim($nama_kec) == "Cisauk"){
            $data['id_surat'] = "3";
        }else if(trim($nama_kec) == "Cisoka"){
            $data['id_surat'] = "4";
        }else if(trim($nama_kec) == "Curug"){
            $data['id_surat'] = "5";
        }else if(trim($nama_kec) == "Gunung Kaler"){
            $data['id_surat'] = "6";
        }else if(trim($nama_kec) == "Jambe"){
            $data['id_surat'] = "7";
        }else if(trim($nama_kec) == "Jayanti"){
            $data['id_surat'] = "8";
        }else if(trim($nama_kec) == "Kelapa Dua"){
            $data['id_surat'] = "9";
        }else if(trim($nama_kec)== "Kemiri"){
            $data['id_surat'] = "10";
        }else if(trim($nama_kec)== "Kresek"){
            $data['id_surat'] = "11";
        }else if(trim($nama_kec) == "Kronjo"){
            $data['id_surat'] = "12";
        }else if(trim($nama_kec) == "Kosambi"){
            $data['id_surat'] = "13";
        }else if(trim($nama_kec) == "Legok"){
            $data['id_surat'] = "14";
        }else if(trim($nama_kec) == "Mauk"){
            $data['id_surat'] = "15";
        }else if(trim($nama_kec) == "Mekarbaru"){
            $data['id_surat'] = "16";
        }else if(trim($nama_kec) == "Pagedangan"){
            $data['id_surat'] = "17";
        }else if(trim($nama_kec) == "Pakuhaji"){
            $data['id_surat'] = "18";
        }else if(trim($nama_kec) == "Panongan"){
            $data['id_surat'] = "19";
        }else if(trim($nama_kec) == "Pasarkemis"){
            $data['id_surat'] = "20";
        }else if(trim($nama_kec) == "Rajeg"){
            $data['id_surat'] = "21";
        }else if(trim($nama_kec) == "Sepatan"){
            $data['id_surat'] = "22";
        }else if(trim($nama_kec)== "Sepatan Timur"){
            $data['id_surat'] = "23";
        }else if(trim($nama_kec) == "Sindang Jaya"){
            $data['id_surat'] = "24";
        }else if(trim($nama_kec) == "Solear"){
            $data['id_surat'] = "25";
        }else if(trim($nama_kec) == "Sukadiri"){
            $data['id_surat'] = "26";
        }else if(trim($nama_kec) == "Sukamulya"){
            $data['id_surat'] = "27";
        }else if(trim($nama_kec) == "Teluk Naga"){
            $data['id_surat'] = "28";
        }else if(trim($nama_kec) == "Tigaraksa"){
            $data['id_surat'] = "29";
        }else{
            $data['id_surat']= "30";
        }
        $this->load->view('masterdata/print_surat_mandat', $data);
    }

    //=============================================================================================//
    public function blk()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_blk');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function blk_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_blk();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->blk_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->blk_id ,
                $no,
                $r->blk_name,
                $r->blk_license,
                $r->blk_address,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $status,
                null,
            );
            $no++;
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

    public function add_blk()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $log_type = 'ERROR';
            log_message($log_type,'[REQ]'.'[ADD BLK ]'.'[<<<]'.$i->post('blk_name')||$i->post('blk_license'));
            $data = array(
                'blk_name' => $i->post('blk_name'),
                'blk_license' => $i->post('blk_license'),
                'blk_address' => $i->post('blk_address'),
                'blk_district' => $i->post('blk_district'),
                'blk_status' => $i->post('blk_status'),
            );
            $cek = $this->db->insert('data_blk', $data);
        } else {
            $data = array(
                'blk_name' => $i->post('blk_name'),
                'blk_license' => $i->post('blk_license'),
                'blk_address' => $i->post('blk_address'),
                'blk_district' => $i->post('blk_district'),
                'blk_status' => $i->post('blk_status'),

            );
            $cek = $this->m_masterdata->update_blk($i->post('blk_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_blk($blk_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_blk');
        $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
        $data['data_kabupaten'] = $this->m_masterdata->get_allKabupaten();
        $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_blk'] = $this->m_masterdata->get_blkById($blk_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_blk()
    {
        $i = $this->input;
        $blk_id = $i->post('blk_id');
        $hapus_data = $this->db->delete('data_blk', array('blk_id' => $blk_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function lsp()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_lsp');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function lsp_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_lsp();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->lsp_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->lsp_id ,
                $no,
                $r->lsp_name,
                $r->lsp_license,
                $r->lsp_address,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $status,
                null,
            );
            $no++;
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

    public function add_lsp()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $log_type = 'ERROR';
            log_message($log_type,'[REQ]'.'[ADD BLK ]'.'[<<<]'.$i->post('blk_name')||$i->post('blk_license'));
            $data = array(
                'lsp_name' => $i->post('lsp_name'),
                'lsp_license' => $i->post('lsp_license'),
                'lsp_address' => $i->post('lsp_address'),
                'lsp_district' => $i->post('lsp_district'),
                'lsp_status' => $i->post('lsp_status'),
            );
            $cek = $this->db->insert('data_lsp', $data);
        } else {
            $data = array(
                'lsp_name' => $i->post('lsp_name'),
                'lsp_license' => $i->post('lsp_license'),
                'lsp_address' => $i->post('lsp_address'),
                'lsp_district' => $i->post('lsp_district'),
                'lsp_status' => $i->post('lsp_status'),

            );
            $cek = $this->m_masterdata->update_lsp($i->post('lsp_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_lsp($lsp_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_lsp');
        $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
        $data['data_kabupaten'] = $this->m_masterdata->get_allKabupaten();
        $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_lsp'] = $this->m_masterdata->get_lspById($lsp_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_lsp()
    {
        $i = $this->input;
        $lsp_id = $i->post('lsp_id');
        $hapus_data = $this->db->delete('data_lsp', array('lsp_id' => $lsp_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function tuk()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_tuk');
            $data['data_lsp'] = $this->m_masterdata->get_lspp();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function tuk_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_tuk();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->tuk_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->tuk_id ,
                $no,
                $r->lsp_name,
                $r->tuk_name,
                $status,
                null,
            );
            $no++;
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

    public function add_tuk()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'lsp_id' => $i->post('lsp_id'),
                'tuk_name' => $i->post('tuk_name'),
                'tuk_status' => $i->post('tuk_status'),
            );
            $cek = $this->db->insert('data_tuk', $data);
        } else {
            $data = array(
                'lsp_id' => $i->post('lsp_id'),
                'tuk_name' => $i->post('tuk_name'),
                'tuk_status' => $i->post('tuk_status'),

            );
            $cek = $this->m_masterdata->update_tuk($i->post('tuk_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_tuk($tuk_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_lsp');
        $data['data_lsp'] = $this->m_masterdata->get_lspp();
        $data['data_tuk'] = $this->m_masterdata->get_tukById($tuk_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_tuk()
    {
        $i = $this->input;
        $tuk_id = $i->post('tuk_id');
        $hapus_data = $this->db->delete('data_tuk', array('tuk_id' => $tuk_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function sarkes()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_sarkes');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function sarkes_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_sarkes();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->sarkes_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->sarkes_id ,
                $no,
                $r->sarkes_name,
                $r->sarkes_license,
                $r->sarkes_address,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $status,
                null,
            );
            $no++;
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

    public function add_sarkes()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'sarkes_name' => $i->post('sarkes_name'),
                'sarkes_license' => $i->post('sarkes_license'),
                'sarkes_address' => $i->post('sarkes_address'),
                'sarkes_district' => $i->post('sarkes_district'),
                'sarkes_status' => $i->post('sarkes_status'),
            );
            $cek = $this->db->insert('data_sarkes', $data);
        } else {
            $data = array(
                'sarkes_name' => $i->post('sarkes_name'),
                'sarkes_license' => $i->post('sarkes_license'),
                'sarkes_address' => $i->post('sarkes_address'),
                'sarkes_district' => $i->post('sarkes_district'),
                'sarkes_status' => $i->post('sarkes_status'),

            );
            $cek = $this->m_masterdata->update_sarkes($i->post('sarkes_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_sarkes($sarkes_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_sarkes');
        $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
        $data['data_kabupaten'] = $this->m_masterdata->get_allKabupaten();
        $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_sarkes'] = $this->m_masterdata->get_sarkesById($sarkes_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_sarkes()
    {
        $i = $this->input;
        $sarkes_id = $i->post('sarkes_id');
        $hapus_data = $this->db->delete('data_sarkes', array('sarkes_id' => $sarkes_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function agency()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_agency');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function agency_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_agency();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->agency_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->agency_id ,
                $no,
                $r->agency_name,
                $r->agency_license,
                $r->agency_address,
                $r->nama_prov,
                $r->nama_kab,
                $r->nama_kec,
                $r->nama_kel,
                $status,
                null,
            );
            $no++;
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

    public function add_agency()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'agency_name' => $i->post('agency_name'),
                'agency_license' => $i->post('agency_license'),
                'agency_address' => $i->post('agency_address'),
                'agency_district' => $i->post('agency_district'),
                'agency_status' => $i->post('agency_status'),
            );
            $cek = $this->db->insert('data_agency', $data);
        } else {
            $data = array(
                'agency_name' => $i->post('agency_name'),
                'agency_license' => $i->post('agency_license'),
                'agency_address' => $i->post('agency_address'),
                'agency_district' => $i->post('agency_district'),
                'agency_status' => $i->post('agency_status'),

            );
            $cek = $this->m_masterdata->update_agency($i->post('agency_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_agency($agency_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_agency');
        $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
        $data['data_kabupaten'] = $this->m_masterdata->get_allKabupaten();
        $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_agency'] = $this->m_masterdata->get_agencyById($agency_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_agency()
    {
        $i = $this->input;
        $agency_id = $i->post('agency_id');
        $hapus_data = $this->db->delete('data_agency', array('agency_id' => $agency_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function country()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_country');
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function country_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_country();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->country_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->country_id ,
                $no,
                $r->country_name,
                $status,
                null,
            );
            $no++;
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

    public function add_country()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'country_name' => $i->post('country_name'),
                'country_status' => $i->post('country_status'),
            );
            $cek = $this->db->insert('data_country', $data);
        } else {
            $data = array(
                'country_name' => $i->post('country_name'),
                'country_status' => $i->post('country_status'),

            );
            $cek = $this->m_masterdata->update_country($i->post('country_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_country($country_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_country');
        $data['data_country'] = $this->m_masterdata->get_countryById($country_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_country()
    {
        $i = $this->input;
        $country_id = $i->post('country_id');
        $hapus_data = $this->db->delete('data_country', array('country_id' => $country_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function district()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_district');
            $data['data_country'] = $this->m_masterdata->get_countrys();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function district_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_district();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->district_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->dis_id,
                $no,
                $r->count_name,
                $r->dis_name,
                $status,
                null,
            );
            $no++;
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

    public function add_district()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'district_name' => $i->post('district_name'),
                'country_id' => $i->post('country_id'),
                'district_status' => $i->post('district_status'),
            );
            $cek = $this->db->insert('data_district', $data);
        } else {
            $data = array(
                'district_name' => $i->post('district_name'),
                'country_id' => $i->post('country_id'),
                'district_status' => $i->post('district_status'),

            );
            $cek = $this->m_masterdata->update_district($i->post('district_id '), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_district($district_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_district');
        $data['data_district'] = $this->m_masterdata->get_districtById($district_id);
        $data['data_country'] = $this->m_masterdata->get_countrys();
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_district()
    {
        $i = $this->input;
        $district_id = $i->post('district_id');
        $hapus_data = $this->db->delete('data_district', array('district_id' => $district_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }
    //=============================================================================================//
    public function grant()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_grant');
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function grant_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_grant();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->grant_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->grant_id ,
                $no,
                $r->grant_name,
                $status,
                null,
            );
            $no++;
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

    public function add_grant()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'grant_name' => $i->post('grant_name'),
                'grant_status' => $i->post('grant_status'),
            );
            $cek = $this->db->insert('data_grant', $data);
        } else {
            $data = array(
                'grant_name' => $i->post('grant_name'),
                'grant_status' => $i->post('grant_status'),

            );
            $cek = $this->m_masterdata->update_grant($i->post('grant_id'), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_grant($grant_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_grant');
        $data['data_grant'] = $this->m_masterdata->get_grantById($grant_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_grant()
    {
        $i = $this->input;
        $grant_id = $i->post('grant_id');
        $hapus_data = $this->db->delete('data_grant', array('grant_id' => $grant_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    //=============================================================================================//
    public function candidates()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_candidates');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            $data['data_agency'] = $this->m_masterdata->get_agencys();
            $data['data_grant'] = $this->m_masterdata->get_grants();
            $data['data_country'] = $this->m_masterdata->get_countrys();
            $data['data_district'] = $this->m_masterdata->get_districts();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function tambah_candidates()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_input_candidates');
            $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
            $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
            $data['data_agency'] = $this->m_masterdata->get_agencys();
            $data['data_grant'] = $this->m_masterdata->get_grants();
            $data['data_country'] = $this->m_masterdata->get_countrys();
            $data['data_district'] = $this->m_masterdata->get_districts();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function candidates_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_candidates();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->tk_status ==  "1"){
                $status = "Aktif";
            }else{
                $status = "Non Aktif";
            }

            $data[] = array(
                $r->tk_id,
                $no,
                $r->tk_name,
                $r->tk_nik,
                $r->tk_gender,
                $r->agency_name,
                $r->country_name,
                $status,
                null,
            );
            $no++;
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

    public function add_candidates()
    {
        $i = $this->input;
        $nm_dokumen = rand();

        if (!empty($_FILES["dokumen"]["name"]) || !empty($_FILES["plano"]["name"])) {
            $config['upload_path'] = './uploads/candidates';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['max_size'] = 30000;
            $config['file_name'] = $nm_dokumen;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('dokumen')) {
                echo $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $nm_dokumen = $nm_dokumen . '.' . pathinfo($_FILES["dokumen"]["name"], PATHINFO_EXTENSION);
                $data = array(
                    'tk_name' => $i->post('candidates_name'),
                    'tk_nik' => $i->post('candidates_nik'),
                    'tk_gender' => $i->post('candidates_gender'),
                    'tk_birth_place' => $i->post('candidates_pob'),
                    'tk_birth_date' => $i->post('candidates_dob'),
                    'tk_address' => $i->post('candidates_address'),
                    'tk_district' => $i->post('candidates_district'),
                    'agency_id' => $i->post('agency_id'),
                    'tk_grant' => $i->post('grant_id'),
                    'tk_country' => $i->post('country_id'),
                    'tk_district_country' => $i->post('district_area'),
                    'tk_image' => $nm_dokumen,
                    'tk_status' => $i->post('candidates_status'),

                );
                $cek = $this->db->insert('data_pekerja', $data);
            }
        } else {
            $data = array(
                'tk_name' => $i->post('candidates_name'),
                'tk_nik' => $i->post('candidates_nik'),
                'tk_gender' => $i->post('candidates_gender'),
                'tk_birth_place' => $i->post('candidates_pob'),
                'tk_birth_date' => $i->post('candidates_dob'),
                'tk_address' => $i->post('candidates_address'),
                'tk_district' => $i->post('candidates_district'),
                'agency_id' => $i->post('agency_id'),
                'tk_grant' => $i->post('grant_id'),
                'tk_country' => $i->post('country_id'),
                'tk_district_country' => $i->post('district_area'),
                'tk_image' => $nm_dokumen,
                'tk_status' => $i->post('candidates_status'),

            );
            $cek = $this->db->insert('data_pekerja', $data);
        }



        echo json_encode('sukses');
    }

    public function edit_candidates($agency_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_agency');
        $data['data_provinsi'] = $this->m_masterdata->get_allProvinsi();
        $data['data_kabupaten'] = $this->m_masterdata->get_allKabupaten();
        $data['data_kecamatan'] = $this->m_masterdata->get_allKecamatan();
        $data['data_kelurahan'] = $this->m_masterdata->get_allKelurahan();
        $data['data_agency'] = $this->m_masterdata->get_agencyById($agency_id);
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_candidates()
    {
        $i = $this->input;
        $tk_id = $i->post('candidates_id');
        $hapus_data = $this->db->delete('data_pekerja', array('tk_id' => $tk_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    public function get_district_by_countryid()
    {
        $i = $this->input;
        $country_id = $i->post('country_id');
        $data = $this->m_masterdata->get_allDistrictByCountryId($country_id);
        $html = '';

        $html .= "<option value=''>Choose District Area</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->ditrict_id . ">" . $r->district_name . "</option>";
        }
        echo $html;
    }

    //=============================================================================================//
    public function candidates_blk()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_candidates_blk');
            $data['data_candidates'] = $this->m_masterdata->get_candidatess();
            $data['data_blk'] = $this->m_masterdata->get_blks();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function candidates_blk_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_candidates_blk();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->cb_status ==  "1"){
                $status = "Lulus";
            }else{
                $status = "Tidak Lulus";
            }

            $data[] = array(
                $r->cb_id,
                $no,
                $r->tk_name,
                $r->tk_nik,
                $r->blk_name,
                $status,
                null,
            );
            $no++;
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

    public function add_candidates_blk()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'blk_id' => $i->post('blk_id'),
                'tk_id' => $i->post('tk_id'),
                'cb_date_start' => $i->post('date_start'),
                'cb_date_finish' => $i->post('date_finish'),
                'cb_status' => $i->post('cb_status'),
            );
            $cek = $this->db->insert('data_candidates_blk', $data);
        } else {
            $data = array(
                'blk_id' => $i->post('blk_id'),
                'tk_id' => $i->post('tk_id'),
                'cb_date_start' => $i->post('date_start'),
                'cb_date_finish' => $i->post('date_finish'),
                'cb_status' => $i->post('cb_status'),

            );
            $cek = $this->m_masterdata->update_district($i->post('cb_id '), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_candidates_blk($district_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_district');
        $data['data_district'] = $this->m_masterdata->get_districtById($district_id);
        $data['data_country'] = $this->m_masterdata->get_countrys();
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_candidates_blk()
    {
        $i = $this->input;
        $cb_id = $i->post('blk_id');
        $hapus_data = $this->db->delete('data_candidates_blk', array('cb_id' => $cb_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }
    //=============================================================================================//
    public function candidates_lsp()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_candidates_lsp');
            $data['data_candidates'] = $this->m_masterdata->get_candidates_blks();
            $data['data_lsp'] = $this->m_masterdata->get_lspp();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function candidates_lsp_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_candidates_lsp();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->cl_status ==  "1"){
                $status = "Lulus";
            }else{
                $status = "Tidak Lulus";
            }

            $data[] = array(
                $r->cl_id,
                $no,
                $r->tk_name,
                $r->tk_nik,
                $r->lsp_name,
                $r->tuk_name,
                $status,
                null,
            );
            $no++;
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

    public function add_candidates_lsp()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'tk_id' => $i->post('tk_id'),
                'lsp_id ' => $i->post('lsp_id'),
                'tuk_id ' => $i->post('tuk_id'),
                'cl_date ' => $i->post('exam_date'),
                'cl_status' => $i->post('cl_status'),
            );
            $cek = $this->db->insert('data_candidates_lsp', $data);
        } else {
            $data = array(
                'tk_id' => $i->post('tk_id'),
                'lsp_id ' => $i->post('lsp_id'),
                'tuk_id ' => $i->post('tuk_id'),
                'cl_date ' => $i->post('exam_date'),
                'cl_status' => $i->post('cl_status'),

            );
            $cek = $this->m_masterdata->update_candidates_lsp($i->post('cl_id '), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_candidates_lsp($district_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_district');
        $data['data_district'] = $this->m_masterdata->get_districtById($district_id);
        $data['data_country'] = $this->m_masterdata->get_countrys();
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_candidates_lsp()
    {
        $i = $this->input;
        $cl_id = $i->post('lsp_id');
        $hapus_data = $this->db->delete('data_candidates_lsp', array('cl_id' => $cl_id));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }

    public function get_tuk_by_lspid()
    {
        $i = $this->input;
        $lsp_id = $i->post('lsp_id');
        $data = $this->m_masterdata->get_allTUKByLspId($lsp_id);
        $html = '';

        $html .= "<option value=''>Choose TUK</option>";
        foreach ($data as $r) {
            $html .= "<option value=" . $r->tuk_id . ">" . $r->tuk_name . "</option>";
        }
        echo $html;
    }

    //=============================================================================================//
    public function candidates_sarkes()
    {
        if ($this->session->userdata('jabatan') == 'superadmin') {
            $data = array('isi' => 'masterdata/data_candidates_sarkes');
            $data['data_candidates'] = $this->m_masterdata->get_candidates_lsps();
            $data['data_sarkes'] = $this->m_masterdata->get_sarkess();
            $this->load->view('layouts/wrapper', $data);
        } else {
            $script = "<script>
				alert('Akses Ditolak');window.location.href = '" . site_url('Login/index') . "';</script>";
            echo $script;
        }
    }

    public function candidates_sarkes_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $books = $this->m_masterdata->get_candidates_sarkes();


        $data = array();
        $no = 1;
        foreach ($books->result() as $r) {
            if($r->cb_status ==  "1"){
                $status = "Lulus";
            }else{
                $status = "Tidak Lulus";
            }

            $data[] = array(
                $r->cs_id,
                $no,
                $r->tk_name,
                $r->tk_nik,
                $r->sarkes_name,
                $r->cs_name_person,
                $r->cs_date,
                $status,
                null,
            );
            $no++;
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

    public function add_candidates_sarkes()
    {
        $i = $this->input;
        $tipe_form = $i->post('tipe_form');

        if ($tipe_form == "add") {
            $data = array(
                'tk_id' => $i->post('tk_id'),
                'cs_name_person' => $i->post('officer_name'),
                'cs_date' => $i->post('date_input'),
                'cs_status' => $i->post('cs_status'),
            );
            $cek = $this->db->insert('data_candidates_sarkes', $data);
        } else {
            $data = array(
                'tk_id' => $i->post('tk_id'),
                'cs_name_person' => $i->post('officer_name'),
                'cs_date' => $i->post('date_input'),
                'cs_status' => $i->post('cs_status'),

            );
            $cek = $this->m_masterdata->update_district($i->post('cb_id '), $data);
        }

        echo json_encode('sukses');
    }

    public function edit_candidates_sarkes($district_id)
    {
        $i = $this->input;
        $data = array('isi' => 'masterdata/edit_district');
        $data['data_district'] = $this->m_masterdata->get_districtById($district_id);
        $data['data_country'] = $this->m_masterdata->get_countrys();
        $this->load->view('layouts/wrapper', $data);
    }

    public function hapus_candidates_sarkes()
    {
        $i = $this->input;
        $cs_id  = $i->post('sarkes_id');
        $hapus_data = $this->db->delete('data_candidates_sarkes', array('cs_id' => $cs_id ));
        if ($hapus_data) {
            echo json_encode('suceess');
        }
    }
}
