<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2203_ke_2204 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2109');

        status_sukses($hasil);

        return $hasil;
    }
}
