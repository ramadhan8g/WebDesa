<?php



use App\Models\Kelompok as KelompokModel;

defined('BASEPATH') || exit('No direct script access allowed');

class Kelompok extends Web_Controller
{
    protected $tipe = 'kelompok';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('kelompok_model');
        $this->kelompok_model->set_tipe($this->tipe);
    }

    public function detail($slug = null)
    {
        $id = KelompokModel::tipe()->where('slug', $slug)->first()->id;

        if (! $this->web_menu_model->menu_aktif("data-kelompok/{$id}")) {
            show_404();
        }

        $data = $this->includes;

        $data['detail']   = $this->kelompok_model->get_kelompok($id);
        $data['title']    = 'Data Kelompok ' . $data['detail']['nama'];
        $data['anggota']  = $this->kelompok_model->list_anggota(0, 0, 500, $id, 'anggota');
        $data['pengurus'] = $this->kelompok_model->list_pengurus($id);

        // Jika kelompok tdk tersedia / sudah terhapus pd modul kelompok
        if ($data['detail'] == null) {
            show_404();
        }

        $this->_get_common_data($data);
        $this->set_template('layouts/kelompok.tpl.php');
        $this->load->view($this->template, $data);
    }
}
