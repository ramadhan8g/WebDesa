<?php



use App\Models\AnjunganMenu;
use App\Models\Artikel;
use App\Models\Config;
use App\Models\Galery;
use Carbon\Carbon;

defined('BASEPATH') || exit('No direct script access allowed');

class Anjungan extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('web');
        $this->load->model('pamong_model');
        if (! cek_anjungan() || $this->cek_anjungan['tipe'] != 1) {
            redirect('layanan-mandiri/beranda');
        }
    }

    public function index()
    {
        $menu = AnjunganMenu::where('status', 1)->get()->map(static function ($item) {
            $item->link = menu_slug($item->link);

            return $item;
        });

        $jumlah_artikel = setting('anjungan_layar') == 1 ? 4 : 6;

        $data = [
            'header'        => $this->header,
            'cek_anjungan'  => $this->cek_anjungan,
            'arsip_terkini' => Artikel::arsip()->orderBy('tgl_upload', 'DESC')->limit($jumlah_artikel)->get(),
            'arsip_populer' => Artikel::arsip()->orderBy('hit', 'DESC')->limit($jumlah_artikel)->get(),
            'tanggal'       => Carbon::now()->dayName . ', ' . date('d/m/Y'),
            'menu'          => $menu,
            'slides'        => count($menu) > 5 ? 5 : count($menu),
            'teks_berjalan' => setting('anjungan_teks_berjalan'),
            'gambar'        => Galery::where('parrent', setting('anjungan_slide'))->where('enabled', 1)->get(),
            'nama_desa'     => Config::first()->nama_desa,
            'pamong'        => $this->pamong_model->list_aparatur_desa()['daftar_perangkat'],
        ];

        $layar = setting('anjungan_layar') == 1 ? 'index' : 'potrait';

        return view('layanan_mandiri.anjungan.' . $layar, $data);
    }
}
