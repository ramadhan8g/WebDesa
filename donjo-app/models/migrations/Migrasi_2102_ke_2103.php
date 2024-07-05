<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2102_ke_2103 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        // $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2011');
        // Skip

        status_sukses($hasil);

        return $hasil;
    }
}
