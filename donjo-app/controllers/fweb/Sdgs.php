<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Sdgs extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (! $this->web_menu_model->menu_aktif('status-sdgs')) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);
        $data['halaman_statis'] = 'sdgs/index';
        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }
}
