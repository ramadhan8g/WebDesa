<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Vaksin extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vaksin_covid_model');
    }

    public function index()
    {
        if (! $this->web_menu_model->menu_aktif('data-vaksinasi')) {
            show_404();
        }

        $data = $this->includes;

        $data['main']           = $this->vaksin_covid_model->list_penduduk(0);
        $data['heading']        = 'Daftar Nama Warga Yang Telah Divaksin';
        $data['title']          = $data['heading'];
        $data['halaman_statis'] = 'vaksin/index';

        $this->_get_common_data($data);
        $this->set_template('layouts/halaman_statis.tpl.php');
        $this->load->view($this->template, $data);
    }
}
