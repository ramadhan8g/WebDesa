<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Sosmed extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('web_sosmed_model');
        $this->modul_ini     = 'admin-web';
        $this->sub_modul_ini = 'media-sosial';
    }

    public function index()
    {
        $sosmed = $this->session->userdata('sosmed');

        if (! $sosmed) {
            $sosmed = 'facebook';
        }

        $data['media']       = $sosmed;
        $data['main']        = $this->web_sosmed_model->get_sosmed($sosmed);
        $data['list_sosmed'] = $this->web_sosmed_model->list_sosmed();
        $data['form_action'] = site_url("sosmed/update/{$sosmed}");

        $this->session->unset_userdata('sosmed');

        $this->render('sosmed/sosmed', $data);
    }

    public function tab($sosmed)
    {
        $this->session->set_userdata('sosmed', $sosmed);

        redirect('sosmed');
    }

    public function update($sosmed)
    {
        $this->redirect_hak_akses('u');
        $this->web_sosmed_model->update($sosmed);
        $redirect = (! empty($sosmed)) ? "sosmed/tab/{$sosmed}" : 'sosmed';
        redirect($redirect);
    }
}
