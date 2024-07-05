<?php



use App\Models\Config;

defined('BASEPATH') || exit('No direct script access allowed');

class Periksa extends CI_Controller
{
    public $header;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->db_error['code'] === 1049) {
            redirect('koneksi-database');
        }

        $this->load->model(['periksa_model', 'user_model']);
        $this->header      = Config::first();
        $this->latar_login = default_file(LATAR_LOGIN . $this->periksa_model->getSetting('latar_login'), DEFAULT_LATAR_SITEMAN);
    }

    public function index()
    {
        if ($this->session->periksa_data != 1) {
            redirect('periksa/login');
        }

        if ($this->session->message_query || $this->session->message_exception) {
            log_message('error', $this->session->message_query);
            log_message('error', $this->session->message_exception);
        }

        return view('periksa.index', array_merge($this->periksa_model->periksa, ['header' => $this->header]));
    }

    public function perbaiki()
    {
        if ($this->session->periksa_data != 1) {
            redirect('periksa/login');
        }
        $this->periksa_model->perbaiki();
        $this->session->unset_userdata(['db_error', 'message', 'message_query', 'heading', 'message_exception']);

        redirect('/');
    }

    // Login khusus untuk periksa
    public function login()
    {
        if ($this->session->periksa_data == 1) {
            redirect('periksa');
        }

        $this->session->siteman_wait = 0;
        $data                        = [
            'header'      => $this->header,
            'form_action' => site_url('periksa/auth'),
            'latar_login' => $this->latar_login,
        ];

        $this->setting->sebutan_desa      = $this->periksa_model->getSetting('sebutan_desa');
        $this->setting->sebutan_kabupaten = $this->periksa_model->getSetting('sebutan_kabupaten');
        $this->load->view('siteman', $data);
    }

    // Login khusus untuk periksa
    public function auth()
    {
        $method       = $this->input->method(true);
        $allow_method = ['POST'];
        if (! in_array($method, $allow_method)) {
            redirect('periksa/login');
        }
        $this->user_model->siteman();

        if ($this->session->siteman != 1) {
            // Gagal otentifikasi atau bukan admin
            redirect('periksa');
        }
        if ($this->session->grup != 1) {
            // Bukan admin
            $this->user_model->logout();
            redirect('periksa');
        }

        // Bedakan dengan status login biasa supaya dipaksa login lagi setelah selesai perbaiki data
        $this->session->periksa_data = 1;
        redirect('periksa');
    }
}
