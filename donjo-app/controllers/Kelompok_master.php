<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Kelompok_master extends Admin_Controller
{
    private $_set_page;
    private $_list_session;
    protected $tipe = 'kelompok';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['kelompok_master_model']);
        $this->modul_ini     = 'kependudukan';
        $this->sub_modul_ini = 'kelompok';
        $this->_set_page     = ['20', '50', '100'];
        $this->_list_session = ['cari', 'filter'];
        $this->kelompok_master_model->set_tipe($this->tipe);
    }

    public function clear()
    {
        $this->session->unset_userdata($this->_list_session);
        $this->session->per_page = $this->_set_page[0];

        redirect($this->controller);
    }

    public function index($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        foreach ($this->_list_session as $list) {
            $data[$list] = $this->session->{$list} ?: '';
        }

        $per_page = $this->input->post('per_page');
        if (isset($per_page)) {
            $this->session->per_page = $per_page;
        }

        $data['func']     = 'index';
        $data['set_page'] = $this->_set_page;
        $data['paging']   = $this->kelompok_master_model->paging($p);
        $data['main']     = $this->kelompok_master_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']  = $this->kelompok_master_model->autocomplete();
        $data['tipe']     = $this->tipe;

        $this->render('kelompok_master/table', $data);
    }

    public function form($id = 0)
    {
        $this->redirect_hak_akses('u');
        if ($id) {
            $data['kelompok_master'] = $this->kelompok_master_model->get_kelompok_master($id);
            $data['form_action']     = site_url("{$this->controller}/update/{$id}");
        } else {
            $data['kelompok_master'] = null;
            $data['form_action']     = site_url("{$this->controller}/insert");
        }

        $data['tipe'] = $this->tipe;

        $this->render('kelompok_master/form', $data);
    }

    public function filter($filter)
    {
        $value = $this->input->post($filter);
        if ($value != '') {
            $this->session->{$filter} = $value;
        } else {
            $this->session->unset_userdata($filter);
        }

        redirect($this->controller);
    }

    public function insert()
    {
        $this->redirect_hak_akses('u');
        $this->kelompok_master_model->insert();

        redirect($this->controller);
    }

    public function update($id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->kelompok_master_model->update($id);

        redirect($this->controller);
    }

    public function delete($id = 0)
    {
        $this->redirect_hak_akses('h');
        $this->kelompok_master_model->delete($id);

        redirect($this->controller);
    }

    public function delete_all()
    {
        $this->redirect_hak_akses('h');
        $this->kelompok_master_model->delete_all();

        redirect($this->controller);
    }
}
