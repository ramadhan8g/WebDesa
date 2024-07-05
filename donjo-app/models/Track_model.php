<?php



use App\Models\Artikel;
use App\Models\BantuanPeserta;
use App\Models\Config;
use App\Models\Dokumen;
use App\Models\Keluarga;
use App\Models\LogSurat;
use App\Models\Penduduk;
use App\Models\PendudukMandiri;
use App\Models\Persil;
use App\Models\User;

defined('BASEPATH') || exit('No direct script access allowed');

class Track_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function track_desa($dari)
    {
        if ($this->setting->enable_track == false) {
            return;
        }
        // Track web dan admin masing2 maksimum sekali sehari
        if (strpos(current_url(), 'first') !== false) {
            if ($this->session->has_userdata('track_web') && $this->session->track_web == date('Y m d')) {
                return;
            }
        } else {
            if ($this->session->has_userdata('track_admin') && $this->session->track_admin == date('Y m d')) {
                return;
            }
        }

        $this->session->set_userdata('balik_ke', $dari);
        $this->kirim_data();
    }

    public function kirim_data()
    {
        /**
         * Jangan kirim data ke pantau jika versi demo
         * cegah error karena tabel belum ada
         */
        if (config_item('demo_mode') || ! $this->db->field_exists('deleted_at', 'log_surat')) {
            return;
        }

        if (! $this->db->field_exists('deleted_at', 'log_surat')) { // cegah error karena tabel belum ada
            return;
        }

        if (defined('ENVIRONMENT')) {
            switch (ENVIRONMENT) {
                case 'development':
                    // Jangan kirim data ke pantau jika versi development
                    return;

                case 'testing':
                case 'production':
                    $tracker = config_item('server_pantau');
                    break;

                default:
                    exit('The application environment is not set correctly.');
            }
        }

        $config = Config::first();

        $desa = [
            'nama_desa'           => $config->nama_desa,
            'kode_desa'           => $config->kode_desa,
            'kode_pos'            => $config->kode_pos,
            'nama_kecamatan'      => $config->nama_kecamatan,
            'kode_kecamatan'      => $config->kode_kecamatan,
            'nama_kabupaten'      => $config->nama_kabupaten,
            'kode_kabupaten'      => $config->kode_kabupaten,
            'nama_provinsi'       => $config->nama_propinsi,
            'kode_provinsi'       => $config->kode_propinsi,
            'lat'                 => $config->lat,
            'lng'                 => $config->lng,
            'alamat_kantor'       => $config->alamat_kantor,
            'email_desa'          => $config->email_desa,
            'telepon'             => $config->telepon,
            'url'                 => current_url(),
            'ip_address'          => $_SERVER['SERVER_ADDR'],
            'external_ip'         => get_external_ip(),
            'version'             => AmbilVersi(),
            'jml_penduduk'        => Penduduk::status(1)->count(),
            'jml_artikel'         => Artikel::count(),
            'jml_surat_keluar'    => LogSurat::whereNull('deleted_at')->count(),
            'jml_peserta_bantuan' => BantuanPeserta::count(),
            'jml_mandiri'         => PendudukMandiri::count(),
            'jml_pengguna'        => User::count(),
            'jml_unsur_peta'      => $this->jml_unsur_peta(),
            'jml_persil'          => Persil::count(),
            'jml_dokumen'         => Dokumen::hidup()->count(),
            'jml_keluarga'        => Keluarga::status()->count(),
            'jml_surat_tte'       => LogSurat::whereNull('deleted_at')->where('tte', '=', 1)->count(), // jumlah surat terverifikasi secara tte
            'modul_tte'           => (LogSurat::whereNull('deleted_at')->where('tte', '=', 1)->count() > 0 && setting('tte') == 1) ? 1 : 0, // cek modul tte
        ];

        if ($this->abaikan($desa)) {
            return;
        }

        $trackSID_output = httpPost($tracker . '/api/track/desa?token=' . config_item('token_pantau'), $desa); // kirim ke tracksid.
        $this->cek_notifikasi_TrackSID($trackSID_output);

        if (strpos(current_url(), 'first') !== false) {
            $this->session->set_userdata('track_web', date('Y m d'));
        } else {
            $this->session->set_userdata('track_admin', date('Y m d'));
        }
    }

    private function cek_notifikasi_TrackSID($trackSID_output)
    {
        if (! empty($trackSID_output)) {
            $array_output = json_decode($trackSID_output, true);
            $this->load->model('notif_model');

            foreach ($array_output as $notif) {
                $notif['aksi_ya']    = $this->aksi_valid($notif['aksi_ya']) ?: 'notif/update_pengumuman';
                $notif['aksi_tidak'] = $this->aksi_valid($notif['aksi_tidak']) ?: 'notif/update_pengumuman';
                $notif['aksi']       = $notif['aksi_ya'] . ',' . $notif['aksi_tidak'];

                $this->notif_model->insert_notif([
                    'kode'           => $notif['kode'],
                    'judul'          => $notif['judul'],
                    'jenis'          => $notif['jenis'],
                    'isi'            => $notif['isi'],
                    'server'         => $notif['server'],
                    'tgl_berikutnya' => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                    'updated_by'     => 0,
                    'frekuensi'      => $notif['frekuensi'],
                    'aksi'           => $notif['aksi_ya'] . ',' . $notif['aksi_tidak'],
                    'aktif'          => $notif['aktif'],
                ]);
            }
        }
    }

    private function aksi_valid($aksi)
    {
        $aksi_valid = ['setting/aktifkan_tracking'];

        return in_array($aksi, $aksi_valid) ? $aksi : '';
    }

    /*
     * Jangan rekam, jika:
     * - ada kolom nama wilayah kurang dari 4 karakter, kecuali desa boleh 3 karakter
     * - ada kolom wilayah yang masih merupakan contoh (berisi karakter non-alpha atau tulisan 'contoh', 'demo' atau 'sampel')
    */
    public function abaikan($data)
    {
        $regex   = '/[^\.a-zA-Z\s:-]|contoh|demo\s+|sampel\s+/i';
        $abaikan = false;
        $desa    = trim($data['nama_desa']);
        $kec     = trim($data['nama_kecamatan']);
        $kab     = trim($data['nama_kabupaten']);
        $prov    = trim($data['nama_provinsi']);
        if (strlen($desa) < 3 || strlen($kec) < 4 || strlen($kab) < 4 || strlen($prov) < 4) {
            $abaikan = true;
        } elseif (preg_match($regex, $desa) || preg_match($regex, $kec) || preg_match($regex, $kab) || preg_match($regex, $prov)) {
            $abaikan = true;
        }

        return $abaikan;
    }

    private function jml_unsur_peta()
    {
        return $this->db->get('area')->num_rows() + $this->db->get('garis')->num_rows() + $this->db->get('lokasi')->num_rows();
    }
}
