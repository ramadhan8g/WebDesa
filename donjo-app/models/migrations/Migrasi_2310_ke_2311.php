<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2310_ke_2311 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2304');

        status_sukses($hasil);

        return $hasil;
    }
}
