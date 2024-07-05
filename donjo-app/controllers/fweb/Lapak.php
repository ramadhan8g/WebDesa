<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Lapak extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lapak_model');
    }

    public function index($p = 1)
    {
        if (! $this->web_menu_model->menu_aktif('lapak')) {
            show_404();
        }

        if ($this->setting->tampilkan_lapak_web == 0) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);

        $data['id_kategori'] = $this->input->get('id_kategori', true);
        $data['keyword']     = $this->input->get('keyword', true);

        // TODO : Sederhanakan bagian panging dengan suffix
        $data['paging']       = $this->lapak_model->paging_produk($p, $data['keyword'], $data['id_kategori']);
        $data['paging_page']  = 'lapak';
        $data['paging_range'] = 3;
        $data['start_paging'] = max($data['paging']->start_link, $p - $data['paging_range']);
        $data['end_paging']   = min($data['paging']->end_link, $p + $data['paging_range']);
        $data['pages']        = range($data['start_paging'], $data['end_paging']);

        if ($data['keyword']) {
            $data['produk'] = $this->lapak_model->get_produk($data['keyword'], 1);
        } else {
            $data['produk'] = $this->lapak_model->get_produk('', 1);
        }

        if ($data['id_kategori'] != '') {
            $data['produk'] = $data['produk']->where('id_produk_kategori', $data['id_kategori']);
        }

        $data['produk']         = $data['produk']->limit($data['paging']->per_page, $data['keyword'] ? 0 : $data['paging']->offset)->get()->result();
        $data['kategori']       = $this->lapak_model->get_kategori()->get()->result();
        $data['halaman_statis'] = 'lapak/index';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }
}
