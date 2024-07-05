<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Idm extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($tahun = null)
    {
        if (! $this->web_menu_model->menu_aktif('status-idm/' . $tahun) || null === $tahun) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);

        $data['idm']            = idm($data['desa']['kode_desa'], $tahun);
        $data['halaman_statis'] = 'idm/index';

        $this->_get_common_data($data);
        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }
}
