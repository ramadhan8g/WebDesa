<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Modul extends Admin_Controller
{
    private $list_session;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['modul_model']);
        $this->modul_ini     = 'pengaturan';
        $this->sub_modul_ini = 'modul';
        $this->list_session  = ['status', 'cari', 'module'];
    }

    public function clear()
    {
        $this->session->unset_userdata($this->list_session);
        redirect('modul');
    }

    public function index()
    {

       
        $id = $this->session->module;

        if (! $id) {
            foreach ($this->list_session as $list) {
                $data[$list] = $this->session->{$list} ?: '';
            }

            $data['sub_modul'] = null;
            $data['main']      = $this->modul_model->list_data();
            $data['keyword']   = $this->modul_model->autocomplete();
        } else {
            $data['sub_modul'] = $this->modul_model->get_data($id);
            $data['main']      = $this->modul_model->list_sub_modul($id);
        }
        // dump($data);
        $this->render('setting/modul/table', $data);
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u');
        $data['list_icon'] = $this->modul_model->list_icon();
        if ($id) {
            $data['modul']       = $this->modul_model->get_data($id);
            $data['form_action'] = site_url("modul/update/{$id}");
        } else {
            $data['modul']       = null;
            $data['form_action'] = site_url('modul/insert');
        }

        $this->render('setting/modul/form', $data);
    }

    public function sub_modul($id = '')
    {
        $this->session->module = $id;

        redirect('modul');
    }

    public function filter($filter)
    {
        $value = $this->input->post($filter);
        if ($value != '') {
            $this->session->{$filter} = $value;
        } else {
            $this->session->unset_userdata($filter);
        }
        redirect('modul');
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u');
        $this->modul_model->update($id);
        $parent = $this->input->post('parent');
        if ($parent == 0) {
            redirect('modul');
        } else {
            redirect("modul/sub_modul/{$parent}");
        }
    }

    public function lock($id = 0, $val = 1)
    {
        $this->redirect_hak_akses('u');
        $this->modul_model->lock($id, $val);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function ubah_server()
    {
        $this->redirect_hak_akses('u');
        $this->setting_model->update_penggunaan_server();
        redirect('modul');
    }

    public function default_server()
    {
        $this->redirect_hak_akses('u');
        $this->modul_model->default_server();
        $this->clear();
    }
}
