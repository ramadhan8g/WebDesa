<?php



use App\Models\SettingAplikasi;

defined('BASEPATH') || exit('No direct script access allowed');

class Status_desa extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 'info-desa';
        $this->sub_modul_ini      = 'status-desa';
        $this->header['kategori'] = 'status sdgs';
    }

    public function index()
    {
        if (session('navigasi') == 'sdgs') {
            return $this->sdgs();
        }

        return $this->idm();
    }

    private function idm()
    {
        $tahun = session('tahun') ?? ($this->input->post('tahun') ?? ($this->setting->tahun_idm) ?? date('Y'));

        $data = [
            'tahun' => (int) $tahun,
            'idm'   => idm($this->header['desa']['kode_desa'], $tahun),
        ];

        return view('admin.status_desa.idm', $data);
    }

    public function perbarui_idm(int $tahun)
    {
        if (cek_koneksi_internet() && $tahun) {
            $kode_desa = $this->header['desa']['kode_desa'];
            $cache     = 'idm_' . $tahun . '_' . $kode_desa . '.json';

            // Cek server Kemendes sebelum hapus cache
            try {
                $client = new \GuzzleHttp\Client();
                $client->get(config_item('api_idm') . "/{$kode_desa}/{$tahun}", [
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'verify' => false,
                ]);

                $this->cache->file->delete($cache);
                set_session('tahun', $tahun);

                redirect_with('success', 'Berhasil Perbarui Data');
            } catch (Exception $e) {
                log_message('error', $e->getMessage());
            }
        }

        redirect_with('error', 'Tidak dapat mengambil data IDM.');
    }

    public function simpan(int $tahun)
    {
        SettingAplikasi::where('key', 'tahun_idm')->update(['value' => $tahun]);
        set_session('tahun', $tahun);

        redirect_with('success', 'Berhasil Simpan Data');
    }

    private function sdgs()
    {
        set_session('navigasi', 'sdgs');

        $sdgs      = sdgs();
        $kode_desa = $this->header['desa']['kode_desa'];

        return view('admin.status_desa.sdgs', compact('sdgs', 'kode_desa'));
    }

    public function perbarui_bps()
    {
        if ($this->input->is_ajax_request()) {
            $kode_bps = $this->request['kode_bps'];
            SettingAplikasi::where('key', 'kode_desa_bps')->update(['value' => $kode_bps]);

            return json([
                'status' => true,
            ]);
        }

        return json([
            'status'  => false,
            'message' => 'Akses tidak di ijinkan',
        ]);
    }

    public function perbarui_sdgs()
    {
        set_session('navigasi', 'sdgs');

        if (cek_koneksi_internet()) {
            $kode_desa = setting('kode_desa_bps');
            $cache     = 'sdgs_' . $kode_desa . '.json';

            // Cek server Kemendes sebelum hapus cache
            try {
                $client = new \GuzzleHttp\Client();
                $client->get(config_item('api_sdgs') . $kode_desa, [
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'verify' => false,
                ]);

                $this->cache->file->delete($cache);

                redirect_with('success', 'Berhasil Perbarui Data');
            } catch (Exception $e) {
                log_message('error', $e->getMessage());
            }
        }

        redirect_with('error', 'Tidak dapat mengambil data SDGS.');
    }

    public function navigasi($navigasi = 'idm')
    {
        redirect_with('navigasi', $navigasi);
    }
}
