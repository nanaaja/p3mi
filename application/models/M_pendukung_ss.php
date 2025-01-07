<?php

class M_pendukung_ss extends CI_Model
{
    private $table = 'data_pendukung';
    private $column_order = array('id_pendukung', 'nik', 'jk', 'alamat', 'umur', 'no_hp', 'nama_relawan', 'nama_prov', 'nama_kab', 'nama_kec', 'nama_kel', 'nama_tps', null); // Kolom yang dapat diurutkan
    private $column_search = array('nik', 'jk', 'alamat', 'umur', 'no_hp', 'nama_relawan', 'nama_prov', 'nama_kab', 'nama_kec', 'nama_kel', 'nama_tps'); // Kolom yang dapat dicari
    private $order = array('id_pendukung' => 'asc'); // Default sorting

    // Fungsi untuk mengambil data dari database
    public function get_datatables_data($postData)
    {
        $this->_get_datatables_query($postData);

        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }

        $query = $this->db->get();
        return array(
            "draw" => intval($postData['draw']),
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered($postData),
            "data" => $query->result()
        );
    }

    // Query utama dengan filter dan sorting
    private function _get_datatables_query($postData)
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
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($postData['search']['value']) { // Jika ada pencarian
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($postData['order'])) { // Sorting
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $this->db->order_by(key($this->order), $this->order[key($this->order)]);
        }
    }

    // Fungsi menghitung semua data
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Fungsi menghitung data yang difilter
    public function count_filtered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
}
