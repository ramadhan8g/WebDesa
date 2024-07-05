<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2312_ke_2401 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2306');

        status_sukses($hasil);

        return $hasil;
    }
}
