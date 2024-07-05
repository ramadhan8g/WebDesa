<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Notif extends Admin_Controller
{
    public function update_pengumuman()
    {
        $this->notif_model->update_notifikasi($this->input->post('kode'), $this->input->post('non_aktifkan'));
    }
}
