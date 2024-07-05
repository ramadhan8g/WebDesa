<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_fitur_premium_2012 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Jalankan migrasi sebelumnya
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2011');

        // Tambah field keyboard
        if (! $this->db->field_exists('keyboard', 'anjungan')) {
            $fields = [
                'keyboard' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => '1',
                    'after'      => 'keterangan',
                ],
            ];

            $hasil = $hasil && $this->dbforge->add_column('anjungan', $fields);
        }

        return $hasil;
    }
}
