<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2208_ke_2209 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2202');

        status_sukses($hasil);

        return $hasil;
    }
}
