<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Laporan_apbdes extends Admin_Controller
{
    protected $tipe = 'laporan_apbdes';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_sinkronisasi_model', 'sinkronisasi');
        $this->modul_ini     = 'keuangan';
        $this->sub_modul_ini = 'laporan-apbdes';
        $this->sinkronisasi->set_tipe($this->tipe);
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $start  = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search[value]');
            $order  = $this->sinkronisasi::ORDER[$this->input->post('order[0][column]')];
            $dir    = $this->input->post('order[0][dir]');
            $tahun  = $this->input->post('filter-tahun');

            return json([
                'draw'            => $this->input->post('draw'),
                'recordsTotal'    => $this->sinkronisasi->get_data()->count_all_results(),
                'recordsFiltered' => $this->sinkronisasi->get_data($search, $tahun)->count_all_results(),
                'data'            => $this->sinkronisasi->get_data($search, $tahun)->order_by($order, $dir)->limit($length, $start)->get()->result(),
            ]);
        }

        $this->render('opendk/index', [
            'judul' => ($this->tipe == 'laporan_apbdes') ? 'Laporan APBDes' : 'Laporan Penduduk',
            'kolom' => ($this->tipe == 'laporan_apbdes') ? 'Semester' : 'Bulan',
            'tahun' => $this->sinkronisasi->get_tahun(),
        ]);
    }

    public function form(int $id = 0)
    {
        $this->redirect_hak_akses('u');

        if ($id) {
            $data['main']        = $this->sinkronisasi->find($id) ?? show_404();
            $data['form_action'] = site_url("{$this->controller}/update/{$id}");
        } else {
            $data['main']        = null;
            $data['form_action'] = site_url("{$this->controller}/insert");
        }

        $data['tahun'] = $this->sinkronisasi->get_tahun();

        $this->load->view("opendk/form_{$this->tipe}", $data);
    }

    public function insert()
    {
        $this->redirect_hak_akses('u');
        $this->sinkronisasi->insert();
        redirect($this->controller);
    }

    public function update(int $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->sinkronisasi->update($id);
        redirect($this->controller);
    }

    public function delete_all()
    {
        $this->redirect_hak_akses('h');
        $this->sinkronisasi->delete_all();
        redirect($this->controller);
    }

    public function unduh(int $id = 0)
    {
        $nama_file = $this->sinkronisasi->find($id)->nama_file;
        ambilBerkas($nama_file, $this->controller, null, LOKASI_DOKUMEN);
    }

    public function kirim()
    {
        $this->redirect_hak_akses('u');

        foreach (glob(LOKASI_DOKUMEN . '*_opendk.zip') as $file) {
            if (file_exists($file)) {
                unlink($file);
                break;
            }
        }

        $desa_id = kode_wilayah($this->header['desa']['kode_desa']);
        $id      = $this->input->post('id_cb');

        //Tambah/Ubah Data
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => "{$this->setting->api_opendk_server}/api/v1/" . str_replace('_', '-', $this->tipe),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode(['desa_id' => $desa_id, $this->tipe => $this->sinkronisasi->opendk($id)]),
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Content-Type: application/json',
                "Authorization: Bearer {$this->setting->api_opendk_key}",
            ],
        ]);

        $response  = json_decode(curl_exec($curl));
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (! curl_errno($curl) && $http_code !== 422) {
            // Ubah tgl kirim
            $this->sinkronisasi->kirim($id);
        }

        curl_close($curl);
        $this->session->unset_userdata(['success', 'error_msg']);
        $this->session->set_flashdata('notif', $response);

        redirect($this->controller);
    }
}
