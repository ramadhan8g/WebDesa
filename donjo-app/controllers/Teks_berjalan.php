<?php



use App\Enums\SistemEnum;

defined('BASEPATH') || exit('No direct script access allowed');

class Teks_berjalan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('teks_berjalan_model');
        $this->load->model('web_artikel_model');
        $this->modul_ini     = 'admin-web';
        $this->sub_modul_ini = 'teks-berjalan';
    }

    public function index()
    {
        $data['main'] = $this->teks_berjalan_model->list_data();

        $this->render('web/teks_berjalan/table', $data);
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u', $_SERVER['HTTP_REFERER']);
        $data['list_artikel'] = $this->web_artikel_model->list_data(999, 6, 0);

        if ($id) {
            $data['teks']        = $this->teks_berjalan_model->get_teks($id);
            $data['form_action'] = site_url("teks_berjalan/update/{$id}");
        } else {
            $data['teks']        = null;
            $data['form_action'] = site_url('teks_berjalan/insert');
        }

        $data['daftar_tampil'] = SistemEnum::all();

        $this->render('web/teks_berjalan/form', $data);
    }

    public function insert()
    {
        $this->redirect_hak_akses('u', $_SERVER['HTTP_REFERER']);
        $this->teks_berjalan_model->insert();
        redirect('teks_berjalan');
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u', $_SERVER['HTTP_REFERER']);
        $this->teks_berjalan_model->update($id);
        redirect('teks_berjalan');
    }

    public function delete($id = '')
    {
        $this->redirect_hak_akses('h', 'teks_berjalan');
        $this->teks_berjalan_model->delete($id);
        redirect('teks_berjalan');
    }

    public function delete_all()
    {
        $this->redirect_hak_akses('h', 'teks_berjalan');
        $this->teks_berjalan_model->delete_all();
        redirect('teks_berjalan');
    }

    public function urut($id = 0, $arah = 0)
    {
        $this->redirect_hak_akses('u', $_SERVER['HTTP_REFERER']);
        $urut = $this->teks_berjalan_model->urut($id, $arah);
        redirect("teks_berjalan/index/{$page}");
    }

    public function lock($id = 0, $val = 1)
    {
        $this->redirect_hak_akses('u', $_SERVER['HTTP_REFERER']);
        $this->teks_berjalan_model->lock($id, $val);
        redirect('teks_berjalan');
    }
}
