<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ImportController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_masterdata');
		$this->load->model('m_user');
		$this->load->library('excel');

		if ($this->session->userdata('is_login') !== true) {
			redirect(site_url("Login"));
		}
	}

	public function import_excel_tps()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 3; $row <= $highestRow; $row++) {
					if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {

						$temp_data[] = array(
							'no_tps'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'nama_tps'	=> $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'alamat'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'dpt'		=> $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'id_kel'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
						);
					}
				}
			}

			$insert = $this->db->insert_batch('data_tps', $temp_data);
			if ($insert) {
				$script = "<script>
				window.location.href = '" . site_url('MasterData/tps') . "';</script>";
				echo $script;
			} else {
				$script = "<script>
				alert('Data Gagal ditambahkan');window.location.href = '" . site_url('MasterData/tps') . "';</script>";
				echo $script;
			}
		} else {
			$script = "<script>
				alert('Data Gagal diimport');window.location.href = '" . site_url('MasterData/tps') . "';</script>";
			echo $script;
		}
	}
	public function import_excel_koordinator()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 3; $row <= $highestRow; $row++) {
					if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {

						$temp_data[] = array(
							'nama_koordinator'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'nik'	=> $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'jk'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'alamat'	=> $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'no_telp'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'id_kel'	=> $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
							'id_user'	=> $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
						);

						$temp_user[] = array(
							'id_user'	=> $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
							'username'	=> $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'password'	=> password_hash($worksheet->getCellByColumnAndRow(8, $row)->getValue(), PASSWORD_DEFAULT),
							'jabatan'	=> $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
							'nama'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'id_tps'	=> $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
							'jk'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'no_hp'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
						);
					}
				}
			}
			$insert_user = $this->db->insert_batch('user', $temp_user);
			$insert = $this->db->insert_batch('data_koordinator', $temp_data);
			if ($insert_user && $insert ) {
				$script = "<script>
				window.location.href = '" . site_url('MasterData/koordinator') . "';</script>";
				echo $script;
			} else {
				$script = "<script>
				alert('Data Gagal ditambahkan');window.location.href = '" . site_url('MasterData/koordinator') . "';</script>";
				echo $script;
			}
		} else {
			$script = "<script>
				alert('Data Gagal diimport');window.location.href = '" . site_url('MasterData/koordinator') . "';</script>";
			echo $script;
		}
	}

	public function import_excel_relawan()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 3; $row <= $highestRow; $row++) {
					if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
						$temp_data[] = array(
							'nama_relawan'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'nik'	=> $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'jk'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'usia'	=> $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'no_telp'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'id_koordinator'	=> $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
							'id_kel'	=> $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
							'id_user'	=> $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
						);

						$temp_user[] = array(
							'id_user'	=> $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'username'	=> $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
							'password'	=> password_hash($worksheet->getCellByColumnAndRow(9, $row)->getValue(), PASSWORD_DEFAULT),
							'jabatan'	=> $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
							'nama'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'id_tps'	=> $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
							'jk'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'no_hp'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
						);
					}
				}
			}

			$insert_user = $this->db->insert_batch('user', $temp_user);
			$insert = $this->db->insert_batch('data_relawan', $temp_data);
			if ($insert_user && $insert ) {
				$script = "<script>
				window.location.href = '" . site_url('MasterData/relawan') . "';</script>";
				echo $script;
			} else {
				$script = "<script>
				alert('Data Gagal ditambahkan');window.location.href = '" . site_url('MasterData/relawan') . "';</script>";
				echo $script;
			}
		} else {
			$script = "<script>
				alert('Data Gagal diimport');window.location.href = '" . site_url('MasterData/relawan') . "';</script>";
			echo $script;
		}
	}

	public function import_excel_pendukung()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 3; $row <= $highestRow; $row++) {
					if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
						$temp_data[] = array(
							'nama'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'nik'	=> (int)$worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'jk'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'alamat'	=> $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'umur'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'no_hp'	=> $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
							'id_relawan'	=> $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
							'id_tps'	=> $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'id_user'	=> $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
						);
					}
				}
			}

			$insert = $this->db->insert_batch('data_pendukung', $temp_data);
			if ($insert) {
				$script = "<script>
				window.location.href = '" . site_url('MasterData/pendukung') . "';</script>";
				echo $script;
			} else {
				$script = "<script>
				alert('Data Gagal ditambahkan');window.location.href = '" . site_url('MasterData/pendukung') . "';</script>";
				echo $script;
			}
		} else {
			$script = "<script>
				alert('Data Gagal diimport');window.location.href = '" . site_url('MasterData/pendukung') . "';</script>";
			echo $script;
		}
	}
	public function import_excel_suara()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 3; $row <= $highestRow; $row++) {
					if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
						$temp_data[] = array(
							'id_caleg'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'id_tps'	=> $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'suara'	=> $worksheet->getCellByColumnAndRow(2, $row)->getValue()
						);
					}
				}
			}

			$insert = $this->db->insert_batch('data_suara', $temp_data);
			if ($insert) {
				$script = "<script>
				window.location.href = '" . site_url('Suara/data_suara') . "';</script>";
				echo $script;
			} else {
				$script = "<script>
				alert('Data Gagal ditambahkan');window.location.href = '" . site_url('Suara/data_suara') . "';</script>";
				echo $script;
			}
		} else {
			$script = "<script>
				alert('Data Gagal diimport');window.location.href = '" . site_url('Suara/data_suara') . "';</script>";
			echo $script;
		}
	}

	public function import_excel_saksi()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 3; $row <= $highestRow; $row++) {
					if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() != '') {
						$temp_user[] = array(
							'id_user'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'username'	=> $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'password'	=> password_hash($worksheet->getCellByColumnAndRow(2, $row)->getValue(), PASSWORD_DEFAULT),
							'jabatan'	=> $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'nama'	=> $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'id_tps'	=> $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
							'jk'	=> $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'no_hp'	=> $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
						);

						$data_saksi[] = array(
							'id_user'	=> $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'nik'	=> $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
						);
					}
				}
			}

			$insert_user = $this->db->insert_batch('user', $temp_user);
			$insert_saksi = $this->db->insert_batch('data_saksi', $data_saksi);
			if ($insert_user && $insert_saksi) {
				$script = "<script>
				window.location.href = '" . site_url('MasterData/saksi') . "';</script>";
				echo $script;
			} else {
				$script = "<script>
				alert('Data Gagal ditambahkan');window.location.href = '" . site_url('MasterData/saksi') . "';</script>";
				echo $script;
			}
		} else {
			$script = "<script>
				alert('Data Gagal diimport');window.location.href = '" . site_url('MasterData/saksi') . "';</script>";
			echo $script;
		}
	}
}
