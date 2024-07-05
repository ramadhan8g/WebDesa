<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Analisis_klasifikasi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (! $this->session->has_userdata('analisis_master')) {
            $this->session->success   = -1;
            $this->session->error_msg = 'Pilih master analisis terlebih dahulu';

            redirect('analisis_master');
        }

        $this->load->model(['analisis_klasifikasi_model', 'analisis_master_model']);
        $this->session->submenu  = 'Data Klasifikasi';
        $this->session->asubmenu = "{$this->controller}";
        $this->modul_ini         = 'analisis';
        $this->sub_modul_ini     = 'master-analisis';
    }

    public function clear()
    {
        $this->session->unset_userdata(['cari']);

        redirect($this->controller);
    }

    public function index($p = 1, $o = 0)
    {
        unset($_SESSION['cari2']);
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']          = $this->analisis_klasifikasi_model->paging($p, $o);
        $data['main']            = $this->analisis_klasifikasi_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']         = $this->analisis_klasifikasi_model->autocomplete();
        $data['analisis_master'] = $this->analisis_master_model->get_analisis_master($this->session->analisis_master);

        $this->render('analisis_klasifikasi/table', $data);
    }

    public function form($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['analisis_klasifikasi'] = $this->analisis_klasifikasi_model->get_analisis_klasifikasi($id);
            $data['form_action']          = site_url("{$this->controller}/update/{$p}/{$o}/{$id}");
        } else {
            $data['analisis_klasifikasi'] = null;
            $data['form_action']          = site_url("{$this->controller}/insert");
        }

        $data['analisis_master'] = $this->analisis_master_model->get_analisis_master($this->session->analisis_master);

        $this->load->view('analisis_klasifikasi/ajax_form', $data);
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari != '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }

        redirect($this->controller);
    }

    public function insert()
    {
        $this->redirect_hak_akses('u');
        $this->analisis_klasifikasi_model->insert();

        redirect($this->controller);
    }

    public function update($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->analisis_klasifikasi_model->update($id);

        redirect("{$this->controller}/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('h');
        $this->analisis_klasifikasi_model->delete($id);

        redirect("{$this->controller}/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->redirect_hak_akses('h');
        $this->analisis_klasifikasi_model->delete_all();

        redirect("{$this->controller}/index/{$p}/{$o}");
    }
}
