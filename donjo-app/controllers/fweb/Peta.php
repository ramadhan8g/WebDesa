<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Peta extends Web_Controller
{
    public function index()
    {
        if (! $this->web_menu_model->menu_aktif('peta')) {
            show_404();
        }

        $this->load->model(['wilayah_model', 'referensi_model', 'laporan_penduduk_model', 'plan_garis_model', 'plan_lokasi_model', 'data_persil_model', 'plan_area_model', 'pembangunan_model']);

        $data = $this->includes;

        $data['list_dusun']         = $this->wilayah_model->list_dusun();
        $data['wilayah']            = $this->wilayah_model->list_wil();
        $data['desa']               = $this->header;
        $data['title']              = 'Peta ' . ucwords($this->setting->sebutan_desa . ' ' . $data['desa']['nama_desa']);
        $data['dusun_gis']          = $data['list_dusun'];
        $data['rw_gis']             = $this->wilayah_model->list_rw();
        $data['rt_gis']             = $this->wilayah_model->list_rt();
        $data['list_ref']           = $this->referensi_model->list_ref(STAT_PENDUDUK);
        $data['covid']              = $this->laporan_penduduk_model->list_data('covid');
        $data['lokasi']             = $this->plan_lokasi_model->list_lokasi(1);
        $data['garis']              = $this->plan_garis_model->list_garis(1);
        $data['area']               = $this->plan_area_model->list_area(1);
        $data['lokasi_pembangunan'] = $this->pembangunan_model->list_lokasi_pembangunan(1);
        $data['persil']             = $this->data_persil_model->list_data();
        $data['halaman_peta']       = 'web/halaman_statis/peta';

        $this->_get_common_data($data);
        $this->set_template('layouts/peta_statis.tpl.php');
        $this->load->view($this->template, $data);
    }
}
