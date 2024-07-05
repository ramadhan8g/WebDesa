<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Pemerintah extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (! $this->web_menu_model->menu_aktif('pemerintah')) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);

        $data['pemerintah']     = $data['aparatur_desa']['daftar_perangkat'];
        $data['halaman_statis'] = 'pemerintah/index';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }
}
