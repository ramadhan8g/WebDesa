<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Analisis_periode extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (! $this->session->has_userdata('analisis_master')) {
            $this->session->success   = -1;
            $this->session->error_msg = 'Pilih master analisis terlebih dahulu';

            redirect('analisis_master');
        }

        $this->load->model(['analisis_periode_model', 'analisis_master_model']);
        $this->session->submenu  = 'Data Periode';
        $this->session->asubmenu = 'analisis_periode';
        $this->modul_ini         = 'analisis';
        $this->sub_modul_ini     = 'master-analisis';
    }

    public function clear()
    {
        $this->session->unset_userdata(['cari', 'state']);

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

        if (isset($_SESSION['state'])) {
            $data['state'] = $_SESSION['state'];
        } else {
            $data['state'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']          = $this->analisis_periode_model->paging($p, $o);
        $data['main']            = $this->analisis_periode_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']         = $this->analisis_periode_model->autocomplete();
        $data['analisis_master'] = $this->analisis_master_model->get_analisis_master($this->session->analisis_master);
        $data['list_state']      = $this->analisis_periode_model->list_state();

        $this->render('analisis_periode/table', $data);
    }

    public function form($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['analisis_periode'] = $this->analisis_periode_model->get_analisis_periode($id);
            $data['form_action']      = site_url("{$this->controller}/update/{$p}/{$o}/{$id}");
        } else {
            $data['analisis_periode'] = null;
            $data['form_action']      = site_url("{$this->controller}/insert");
        }

        $data['analisis_master'] = $this->analisis_master_model->get_analisis_master($this->session->analisis_master);

        $this->render('analisis_periode/form', $data);
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

    public function state()
    {
        $filter = $this->input->post('state');
        if ($filter != 0) {
            $_SESSION['state'] = $filter;
        } else {
            unset($_SESSION['state']);
        }

        redirect($this->controller);
    }

    public function insert()
    {
        $this->redirect_hak_akses('u');
        $this->analisis_periode_model->insert();

        redirect($this->controller);
    }

    public function update($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->analisis_periode_model->update($id);

        redirect("{$this->controller}/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('h');
        $this->analisis_periode_model->delete($id);

        redirect("{$this->controller}/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->redirect_hak_akses('h');
        $this->analisis_periode_model->delete_all();

        redirect("{$this->controller}/index/{$p}/{$o}");
    }

    public function list_state()
    {
        $sql   = 'SELECT * FROM analisis_ref_state';
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
