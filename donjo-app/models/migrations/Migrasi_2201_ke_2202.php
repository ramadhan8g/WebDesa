<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2201_ke_2202 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2107');

        status_sukses($hasil);

        return $hasil;
    }
}
