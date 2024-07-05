<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2108_ke_2109 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2102');

        status_sukses($hasil);

        return $hasil;
    }
}
