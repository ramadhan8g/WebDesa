<?php



use App\Models\Kelompok as LembagaModel;

defined('BASEPATH') || exit('No direct script access allowed');

class Lembaga extends Web_Controller
{
    protected $tipe = 'lembaga';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('kelompok_model');
        $this->kelompok_model->set_tipe($this->tipe);
    }

    public function detail($slug = null)
    {
        $id = LembagaModel::tipe($this->tipe)->where('slug', $slug)->first()->id;

        if (! $this->web_menu_model->menu_aktif("data-lembaga/{$id}")) {
            show_404();
        }

        $data = $this->includes;

        $data['detail']   = $this->kelompok_model->get_kelompok($id);
        $data['title']    = 'Data Lembaga ' . $data['detail']['nama'];
        $data['anggota']  = $this->kelompok_model->list_anggota(0, 0, 500, $id, 'anggota');
        $data['pengurus'] = $this->kelompok_model->list_pengurus($id);

        // Jika lembaga tdk tersedia / sudah terhapus pd modul lembaga
        if ($data['detail'] == null) {
            show_404();
        }

        $this->_get_common_data($data);
        $this->set_template('layouts/kelompok.tpl.php');
        $this->load->view($this->template, $data);
    }
}
