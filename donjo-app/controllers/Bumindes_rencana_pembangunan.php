<?php



use App\Enums\SatuanWaktuEnum;
use App\Models\Pembangunan;

defined('BASEPATH') || exit('No direct script access allowed');

class Bumindes_rencana_pembangunan extends Admin_Controller
{
    protected $tipe  = 'rencana';
    protected $order = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembangunan_model', 'model');
        $this->load->model('pamong_model');
        $this->modul_ini     = 'buku-administrasi-desa';
        $this->sub_modul_ini = 'administrasi-pembangunan';
        $this->model->set_tipe($this->tipe);

        $this->order = [
            1  => 'judul',
            2  => 'alamat',
            3  => 'sumber_biaya_pemerintah',
            4  => 'sumber_biaya_provinsi',
            5  => 'sumber_biaya_kab_kota',
            6  => 'sumber_biaya_swadaya',
            7  => 'sumber_biaya_jumlah',
            8  => 'pelaksana_kegiatan',
            9  => 'manfaat',
            10 => 'keterangan',
        ][$this->input->post('order[0][column]')];
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $start  = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search[value]');
            $order  = $this->order;

            $dir   = $this->input->post('order[0][dir]');
            $tahun = $this->input->post('tahun');

            return json([
                'draw'            => $this->input->post('draw'),
                'recordsTotal'    => $this->model->get_data()->count_all_results(),
                'recordsFiltered' => $this->model->get_data($search, $tahun)->count_all_results(),
                'data'            => $this->model->get_data($search, $tahun)->order_by($order, $dir)->limit($length, $start)->get()->result(),
            ]);
        }

        $this->render('bumindes/pembangunan/main', [
            'tipe'         => ucwords($this->tipe),
            'list_tahun'   => $this->model->list_filter_tahun(),
            'satuan_waktu' => SatuanWaktuEnum::all(),
            'selected_nav' => $this->tipe,
            'subtitle'     => 'Buku ' . ucwords($this->tipe) . ' Pembangunan',
            'main_content' => 'bumindes/pembangunan/' . $this->tipe . '/index',
        ]);
    }

    public function dialog($aksi = '')
    {
        $data = [
            'aksi'        => $aksi,
            'form_action' => site_url('bumindes_' . $this->tipe . '_pembangunan/cetak/' . $aksi),
            'isi'         => 'bumindes/pembangunan/ajax_dialog',
            'list_tahun'  => $this->model->list_filter_tahun(),
        ];

        $this->load->view('global/dialog_cetak', $data);
    }

    public function cetak($aksi = '')
    {
        $tahun = $this->input->post('tahun');

        $data           = $this->modal_penandatangan();
        $data['aksi']   = $aksi;
        $data['main']   = $this->model->get_data('', $tahun)->get()->result();
        $data['config'] = $this->header['desa'];
        if ($tahun == 'semua') {
            $tahun_pembangunan = Pembangunan::selectRaw('MIN(CAST(tahun_anggaran AS CHAR)) as awal, MAX(CAST(tahun_anggaran AS CHAR)) as akhir ')->first();
            $data['tahun']     = ($tahun_pembangunan->awal == $tahun_pembangunan->akhir) ? $tahun_pembangunan->awal : "{$tahun_pembangunan->awal} -  {$tahun_pembangunan->akhir}";
        }
        $data['satuan_waktu'] = SatuanWaktuEnum::all();
        $data['tgl_cetak']    = $this->input->post('tgl_cetak');
        $data['file']         = 'Buku ' . ucwords($this->tipe) . ' Kerja Pembangunan';
        $data['isi']          = 'bumindes/pembangunan/' . $this->tipe . '/cetak';
        $data['letak_ttd']    = ['1', '1', '3'];

        $this->load->view('global/format_cetak', $data);
    }

    // Lainnya
    public function lainnya($submenu)
    {
        $this->render('bumindes/pembangunan/main', [
            'selected_nav' => $submenu,
            'main_content' => 'bumindes/pembangunan/content_rencana',
        ]);
    }
}
