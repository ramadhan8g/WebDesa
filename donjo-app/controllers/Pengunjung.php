<?php



use App\Models\Config;

defined('BASEPATH') || exit('No direct script access allowed');

class Pengunjung extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('statistik_pengunjung');
        $this->modul_ini     = 'admin-web';
        $this->sub_modul_ini = 'pengunjung';
    }

    public function index()
    {
        $data['hari_ini']   = $this->statistik_pengunjung->get_pengunjung_total('1');
        $data['kemarin']    = $this->statistik_pengunjung->get_pengunjung_total('2');
        $data['minggu_ini'] = $this->statistik_pengunjung->get_pengunjung_total('3');
        $data['bulan_ini']  = $this->statistik_pengunjung->get_pengunjung_total('4');
        $data['tahun_ini']  = $this->statistik_pengunjung->get_pengunjung_total('5');
        $data['jumlah']     = $this->statistik_pengunjung->get_pengunjung_total(null);
        $data['main']       = $this->statistik_pengunjung->get_pengunjung($this->session->id);

        $this->render('pengunjung/table', $data);
    }

    public function detail($id = null)
    {
        $this->session->set_userdata('id', $id);

        redirect('pengunjung');
    }

    public function clear()
    {
        $this->session->unset_userdata('id');

        redirect('pengunjung');
    }

    public function cetak()
    {
        $data['config'] = Config::first();
        $data['main']   = $this->statistik_pengunjung->get_pengunjung($this->session->id);
        $this->load->view('pengunjung/print', $data);
    }

    public function unduh()
    {
        $data['aksi']     = 'unduh';
        $data['config']   = Config::first();
        $data['filename'] = underscore('Laporan Data Statistik Pengunjung Website');
        $data['main']     = $this->statistik_pengunjung->get_pengunjung($this->session->id);
        $this->load->view('pengunjung/excel', $data);
    }
}
