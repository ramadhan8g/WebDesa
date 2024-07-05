<?php



defined('BASEPATH') || exit('No direct script access allowed');

require_once APPPATH . 'controllers/Bumindes_rencana_pembangunan.php';

class Bumindes_hasil_pembangunan extends Bumindes_rencana_pembangunan
{
    protected $tipe  = 'hasil';
    protected $order = [];

    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'buku-administrasi-desa';
        $this->sub_modul_ini = 'administrasi-pembangunan';

        $this->order = [
            1 => 'judul',
            2 => 'volume',
            3 => 'jml_anggaran',
            4 => 'alamat',
            5 => 'keterangan',
        ][$this->input->post('order[0][column]')];
    }
}
