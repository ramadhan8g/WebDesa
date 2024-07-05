<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2302_ke_2303 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2208');

        status_sukses($hasil);

        return $hasil;
    }
}
