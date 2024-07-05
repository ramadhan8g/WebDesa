<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2011_ke_2012 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Tambah kolom masa_berlaku & satuan_masa_berlaku di tweb_surat_format
        if (! $this->db->field_exists('masa_berlaku', 'tweb_surat_format')) {
            $fields = [
                'masa_berlaku' => [
                    'type'       => 'INT',
                    'constraint' => 3,
                    'default'    => '1',
                ],
                'satuan_masa_berlaku' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 15,
                    'default'    => 'M',
                ],
            ];

            $hasil = $this->dbforge->add_column('tweb_surat_format', $fields);
        }

        // Pengaturan Token TrackSID
        if (! $this->db->field_exists('token_opensid', 'setting_aplikasi')) {
            $query = "
                INSERT INTO `setting_aplikasi` (`id`, `key`, `value`, `keterangan`, `jenis`, `kategori`) VALUES
                (43, 'token_opensid', '', 'Token OpenSID', '', 'sistem')
                ON DUPLICATE KEY UPDATE `key` = VALUES(`key`), keterangan = VALUES(keterangan), jenis = VALUES(jenis), kategori = VALUES(kategori)";
            $hasil = $hasil && $this->db->query($query);
        }

        status_sukses($hasil);

        return $hasil;
    }
}
