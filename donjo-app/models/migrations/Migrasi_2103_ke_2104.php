<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2103_ke_2104 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        // $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2012');
        // Skip

        status_sukses($hasil);

        return $hasil;
    }
}
