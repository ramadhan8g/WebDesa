<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Laporan_rentan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['laporan_bulanan_model', 'wilayah_model']);
        $this->modul_ini     = 'statistik';
        $this->sub_modul_ini = 'laporan-kelompok-rentan';
    }

    public function clear()
    {
        $session = ['cari', 'filter', 'dusun', 'rw', 'rt'];
        $this->session->unset_userdata($session);
        $this->session->per_page = 20;
        session_error_clear();

        redirect('laporan_rentan');
    }

    public function index()
    {
        $data['dusun']      = $this->session->dusun ?? '';
        $data['config']     = $this->header['desa'];
        $data['list_dusun'] = $this->wilayah_model->list_dusun();
        $data['main']       = $this->laporan_bulanan_model->list_data();
        $this->render('laporan/kelompok', $data);
    }

    public function cetak()
    {
        $data['config'] = $this->header['desa'];
        $data['main']   = $this->laporan_bulanan_model->list_data();
        $this->load->view('laporan/kelompok_print', $data);
    }

    public function excel()
    {
        $data['config'] = $this->header['desa'];
        $data['main']   = $this->laporan_bulanan_model->list_data();
        $this->load->view('laporan/kelompok_excel', $data);
    }

    public function dusun()
    {
        $dusun = $this->input->post('dusun');
        if ($dusun != '') {
            $this->session->dusun = $dusun;
        } else {
            $this->session->unset_userdata('dusun');
        }
        redirect('laporan_rentan');
    }
}
