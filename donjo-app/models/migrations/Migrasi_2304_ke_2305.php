<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2304_ke_2305 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2210');

        status_sukses($hasil);

        return $hasil;
    }
}
