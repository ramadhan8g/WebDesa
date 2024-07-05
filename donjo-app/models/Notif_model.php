<?php



class Notif_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function permohonan_surat_baru()
    {
        return $this->db->where('status', 1)
            ->get('permohonan_surat')->num_rows();
    }

    public function komentar_baru()
    {
        return $this->db->where('id_artikel !=', LAPORAN_MANDIRI)
            ->where('status', 2)
            ->get('komentar')->num_rows();
    }

    /**
     * Tipe 1: Inbox untuk admin, Outbox untuk pengguna layanan mandiri
     * Tipe 2: Outbox untuk admin, Inbox untuk pengguna layanan mandiri
     *
     * @param mixed $tipe
     * @param mixed $nik
     */
    // TODO : Gunakan id penduduk
    public function inbox_baru($tipe = 1, $nik = '')
    {
        if ($nik) {
            $this->db->where('email', $nik);
        }

        return $this->db
            ->where('id_artikel', LAPORAN_MANDIRI)
            ->where('status', 2)
            ->where('tipe', $tipe)
            ->where('is_archived', 0)
            ->get('komentar')
            ->num_rows();
    }

    // Notifikasi pada layanan mandiri, ditampilkan jika ada surat belum lengkap (0) atau surat siap diambil (3)
    public function surat_perlu_perhatian($id = '')
    {
        return $this->db
            ->where('id_pemohon', $id)
            ->where_in('status', [0, 3])
            ->get('permohonan_surat')
            ->num_rows();
    }

    public function get_notif_by_kode($kode)
    {
        return $this->db->where('kode', $kode)->get('notifikasi')->row_array();
    }

    public function notifikasi($notif)
    {
        $aksi                = explode(',', $notif['aksi']);
        $notif['aksi_ya']    = $aksi[0];
        $notif['aksi_tidak'] = $aksi[1];
        $notif['isi']        = str_replace(['\n', '\"SEBAGAIMANA ADANYA\"'], ['', '"SEBAGAIMANA ADANYA"'], $notif['isi']);

        return $notif;
    }

    private function masih_berlaku($notif)
    {
        switch ($notif['kode']) {
            case 'tracking_off':
                if ($this->setting->enable_track) {
                    $this->db->where('kode', 'tracking_off')
                        ->update('notifikasi', ['aktif' => 0]);

                    return false;
                }
                break;
        }

        return true;
    }

    public function update_notifikasi($kode, $non_aktifkan = false)
    {
        // update tabel notifikasi
        $notif = $this->notif_model->get_notif_by_kode($kode);

        $tgl_sekarang     = date('Y-m-d H:i:s');
        $frekuensi        = $notif['frekuensi'];
        $string_frekuensi = '+' . $frekuensi . ' Days';
        $tambah_hari      = strtotime($string_frekuensi); // tgl hari ini ditambah frekuensi
        $data             = [
            'tgl_berikutnya' => date('Y-m-d H:i:s', $tambah_hari),
            'updated_by'     => $this->session->user,
            'updated_at'     => date('Y-m-d H:i:s'),
            'aktif'          => 1,
        ];
        // Non-aktifkan pengumuman kalau dicentang
        if ($notif['jenis'] == 'pengumuman' && $non_aktifkan) {
            $data['aktif'] = 0;
        }

        $this->db->where('kode', $kode)
            ->update('notifikasi', $data);
    }

    // Ambil semua notifikasi yang siap untuk tampil
    // Urut persetujuan dulu
    public function get_semua_notif()
    {
        $hari_ini = new DateTime();
        $compare  = $hari_ini->format('Y-m-d H:i:s');

        return $this->db->where('tgl_berikutnya <=', $compare)
            ->select('*')
            ->select("IF (jenis = 'persetujuan', CONCAT('A',id), CONCAT('Z',id)) AS urut")
            ->where('aktif', 1)
            ->order_by('urut', 'ASC')
            ->get('notifikasi')->result_array();
    }

    public function insert_notif($data)
    {
        $sql = $this->db->insert_string('notifikasi', $data) . duplicate_key_update_str($data);
        $this->db->query($sql);
    }
}
