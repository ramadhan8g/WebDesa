<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Pendapat extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['pendapat_model']);
        $this->modul_ini     = 'layanan-mandiri';
        $this->sub_modul_ini = 'pendapat';
    }

    public function index()
    {
        $tipe                  = $this->session->flashdata('tipe');
        $data['list_pendapat'] = unserialize(NILAI_PENDAPAT);

        foreach ($data['list_pendapat'] as $key => $value) {
            $data["pilihan_{$key}"] = $this->pendapat_model->get_pilihan($tipe, $key);
        }

        $data['main']   = $this->pendapat_model->get_pendapat($tipe);
        $data['detail'] = $this->pendapat_model->get_data($tipe);

        $this->render('pendapat/index', $data);
    }

    public function detail(int $tipe = 1)
    {
        $this->session->set_flashdata('tipe', $tipe);

        redirect('pendapat');
    }
}
