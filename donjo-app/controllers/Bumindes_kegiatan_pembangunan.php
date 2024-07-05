<?php



defined('BASEPATH') || exit('No direct script access allowed');

require_once APPPATH . 'controllers/Bumindes_rencana_pembangunan.php';

class Bumindes_kegiatan_pembangunan extends Bumindes_rencana_pembangunan
{
    protected $tipe  = 'kegiatan';
    protected $order = [];

    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'buku-administrasi-desa';
        $this->sub_modul_ini = 'administrasi-pembangunan';

        $this->order = [
            1  => 'judul',
            2  => 'volume',
            3  => 'sumber_biaya_pemerintah',
            4  => 'sumber_biaya_provinsi',
            5  => 'sumber_biaya_kab_kota',
            6  => 'sumber_biaya_swadaya',
            7  => 'sumber_biaya_jumlah',
            11 => 'pelaksana_kegiatan',
            12 => 'keterangan',
        ][$this->input->post('order[0][column]')];
    }
}
