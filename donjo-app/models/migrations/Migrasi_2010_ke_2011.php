<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2010_ke_2011 extends MY_model
{
    public function up()
    {
        $hasil = true;

        $hasil = $hasil && $this->tambah_kolom_ket($hasil);
        // Ubah tipe data field nilai menjadi INT
        $hasil = $hasil && $this->db->query('ALTER TABLE `analisis_parameter` MODIFY COLUMN nilai INT(3) NOT NULL DEFAULT 0');
        $hasil = $hasil && $this->db->query('ALTER TABLE `analisis_parameter` MODIFY COLUMN kode_jawaban INT(3) DEFAULT 0');

        status_sukses($hasil);

        return $hasil;
    }

    private function tambah_kolom_ket($hasil)
    {
        //tambah kolom keterangan di tabel kelompok_anggota
        if (! $this->db->field_exists('keterangan', 'kelompok_anggota')) {
            $hasil = $hasil && $this->dbforge->add_column('kelompok_anggota', [
                'keterangan' => [
                    'type' => 'text',
                    'null' => true,
                ],
            ]);
        }

        return $hasil;
    }
}
