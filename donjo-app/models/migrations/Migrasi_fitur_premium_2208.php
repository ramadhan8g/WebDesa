<?php



use App\Models\Config;
use App\Models\LogKeluarga;
use App\Models\Pamong;
use Illuminate\Support\Facades\Schema;

defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_fitur_premium_2208 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Jalankan migrasi sebelumnya
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2207');
        $hasil = $hasil && $this->migrasi_2022070551($hasil);
        $hasil = $hasil && $this->migrasi_2022070451($hasil);
        $hasil = $hasil && $this->migrasi_2022070751($hasil);
        $hasil = $hasil && $this->migrasi_2022071851($hasil);
        $hasil = $hasil && $this->migrasi_2022072751($hasil);

        return $hasil && $this->migrasi_2022073151($hasil);
    }

    protected function migrasi_2022070551($hasil)
    {
        // Hanya jalankan sebelum migrasi perubahan fungsi a.n dan u.b
        if (! Schema::hasColumn('tweb_desa_pamong', 'jabatan_id')) {
            $config = Config::first();

            if ($config->pamong_id && Pamong::where('pamong_ttd', 1)->count() > 1) {
                return $hasil && Pamong::whereNotIn('pamong_id', [$config->pamong_id])->update(['pamong_ttd' => 0]);
            }
        }

        return $hasil;
    }

    protected function migrasi_2022070451($hasil)
    {
        $hasil = $hasil && $this->db
            ->where('id', 7)
            ->update('setting_modul', ['url' => '']);

        $hasil = $hasil && $this->db
            ->where('parent', 7)
            ->update('setting_modul', ['hidden' => 0]);

        $hasil = $hasil && $this->db
            ->where([
                'id'    => 213,
                'modul' => 'data_persil',
            ])
            ->update('setting_modul', [
                'modul' => 'Daftar Persil',
                'ikon'  => 'fa-list',
            ]);

        $this->cache->hapus_cache_untuk_semua('_cache_modul');

        return $hasil;
    }

    protected function migrasi_2022071851($hasil)
    {
        if (! $this->db->field_exists('permanen', 'log_backup')) {
            $fields = [
                'permanen' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'null'       => false,
                    'default'    => 0,
                    'after'      => 'path',
                ],
            ];
            $hasil = $hasil && $this->dbforge->add_column('log_backup', $fields);
        }

        return $hasil;
    }

    protected function migrasi_2022070751($hasil)
    {
        // tambahkan pengaturan
        return $hasil && $this->tambah_setting([
            'key'        => 'font_surat',
            'value'      => 'Arial',
            'keterangan' => 'Font Surat Utama',
            'kategori'   => 'format_surat',
        ]);
    }

    protected function migrasi_2022072751($hasil)
    {
        if ($this->db->field_exists('updated_at', 'tweb_penduduk_mandiri')) {
            $hasil = $hasil && $this->dbforge->modify_column('tweb_penduduk_mandiri', 'updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        }

        if ($this->db->field_exists('id', 'ibu_hamil')) {
            $hasil = $hasil && $this->dbforge->modify_column('ibu_hamil', [
                'id' => [
                    'name'           => 'id_ibu_hamil',
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                    'unsigned'       => true,
                ],
            ]);
        }

        if ($this->db->field_exists('id', 'bulanan_anak')) {
            $hasil = $hasil && $this->dbforge->modify_column('bulanan_anak', [
                'id' => [
                    'name'           => 'id_bulanan_anak',
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                    'unsigned'       => true,
                ],
            ]);
        }

        if ($this->db->field_exists('id', 'sasaran_paud')) {
            $hasil = $hasil && $this->dbforge->modify_column('sasaran_paud', [
                'id' => [
                    'name'           => 'id_sasaran_paud',
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                    'unsigned'       => true,
                ],
            ]);
        }

        return $hasil;
    }

    protected function migrasi_2022073151($hasil)
    {
        // Cek duplikasi log_keluarga dengan id_peristiwa kematian (2) yang sama dalam 1 kk
        $cek_log = LogKeluarga::where('id_peristiwa', 2)
            ->groupBy('id_kk')
            ->havingRaw('COUNT(id_kk) > 1')
            ->pluck('id_kk');

        foreach ($cek_log as $key => $value) {
            $log_keluarga = LogKeluarga::where('id_kk', $value)->where('id_peristiwa', 2)->orderBy('tgl_peristiwa', 'asc')->pluck('id')->toArray();
            unset($log_keluarga[0]);

            // Hapus log mati ganda
            if ($log_keluarga) {
                $hasil = $hasil && LogKeluarga::destroy($log_keluarga);
            }
        }

        return $hasil;
    }
}
