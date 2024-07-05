<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Notif_web extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notif_model');
    }

    public function inbox()
    {
        $j = $this->notif_model->inbox_baru($tipe = 2, $this->is_login->nik);
        if ($j > 0) {
            echo $j;
        }
    }

    public function surat_perlu_perhatian()
    {
        $j = $this->notif_model->surat_perlu_perhatian($this->is_login->id_pend);
        if ($j > 0) {
            echo $j;
        }
    }
}
