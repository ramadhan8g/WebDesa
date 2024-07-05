<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Masuk_ektp extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        mandiri_timeout();
        $this->session->login_ektp = true;
        $this->load->model(['mandiri_model', 'theme_model']);
        if ($this->setting->layanan_mandiri == 0) {
            show_404();
        }
    }

    public function index()
    {
        $mac_address = $this->input->get('mac_address', true);
        $token       = $this->input->get('token_layanan', true);
        if (($mac_address && $token == $this->setting->layanan_opendesa_token) || $this->session->mandiri == 1) {
            $this->session->mac_address = $mac_address;
            redirect('layanan-mandiri/beranda');
        }

        //Initialize Session ------------
        $this->session->unset_userdata('balik_ke');
        if (! isset($this->session->mandiri)) {
            // Belum ada session variable
            $this->session->mandiri      = 0;
            $this->session->mandiri_try  = 4;
            $this->session->mandiri_wait = 0;
            $this->session->login_ektp   = true;
        }

        $data = [
            'header'              => $this->header,
            'latar_login_mandiri' => $this->theme_model->latar_login_mandiri(),
            'cek_anjungan'        => $this->cek_anjungan,
            'form_action'         => site_url('layanan-mandiri/cek-ektp'),
        ];

        if ($this->setting->tampilan_anjungan == 1) {
            $this->load->model('first_gallery_m');

            $data['daftar_album'] = $this->first_gallery_m->sub_gallery_show($this->setting->tampilan_anjungan_slider);
        }

        $this->load->view(MANDIRI . '/masuk', $data);
    }

    public function cek_ektp()
    {
        $this->mandiri_model->siteman_ektp();
        redirect('layanan-mandiri/beranda');
    }
}
