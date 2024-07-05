<?php



defined('BASEPATH') || exit('No direct script access allowed');

require_once APPPATH . 'controllers/Laporan_apbdes.php';

class Laporan_penduduk extends Laporan_apbdes
{
    protected $tipe = 'laporan_penduduk';

    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'statistik';
        $this->sub_modul_ini = 'laporan-penduduk';
    }
}
