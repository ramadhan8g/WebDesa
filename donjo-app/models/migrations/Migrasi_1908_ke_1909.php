<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_1908_ke_1909 extends CI_model
{
    public function up()
    {
        if (! $this->db->table_exists('keluarga_aktif')) {
            $sql = 'CREATE VIEW keluarga_aktif AS SELECT k.*
	  			FROM tweb_keluarga k
	  			LEFT JOIN tweb_penduduk p ON k.nik_kepala = p.id
	  			WHERE p.status_dasar = 1';
            $this->db->query($sql);
        }
        // Tambah kolom slug untuk artikel
        if (! $this->db->field_exists('slug', 'artikel')) {
            $fields         = [];
            $fields['slug'] = [
                'type'       => 'varchar',
                'constraint' => 200,
                'null'       => true,
                'default'    => null,
            ];
            $this->dbforge->add_column('artikel', $fields);
        }
        // Tambahkan slug untuk setiap artikel yg belum memiliki
        $list_artikel = $this->db->select('id, judul, slug')->get('artikel')->result_array();
        if ($list_artikel) {
            foreach ($list_artikel as $artikel) {
                if (! empty($artikel['slug'])) {
                    continue;
                }
                $slug = url_title($artikel['judul'], 'dash', true);
                $this->db->where('id', $artikel['id'])->update('artikel', ['slug' => $slug]);
            }
        }

        //tambah kolom keterangan untuk log_surat
        if (! $this->db->field_exists('keterangan', 'log_surat')) {
            $fields               = [];
            $fields['keterangan'] = [
                'type'       => 'varchar',
                'constraint' => 200,
                'null'       => true,
                'default'    => null,
            ];
            $this->dbforge->add_column('log_surat', $fields);
        }
    }
}
