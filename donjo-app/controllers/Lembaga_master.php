<?php



defined('BASEPATH') || exit('No direct script access allowed');

require_once APPPATH . 'controllers/Kelompok_master.php';

class Lembaga_master extends Kelompok_master
{
    protected $tipe = 'lembaga';

    public function __construct()
    {
        parent::__construct();

        $this->modul_ini     = 'info-desa';
        $this->sub_modul_ini = 'lembaga-desa';
    }
}
