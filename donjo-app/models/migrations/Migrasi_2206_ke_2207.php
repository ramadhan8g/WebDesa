<?php



class Migrasi_2206_ke_2207 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2112');

        status_sukses($hasil);

        return $hasil;
    }
}
