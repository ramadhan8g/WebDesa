<?php



use App\Models\Config;

defined('BASEPATH') || exit('No direct script access allowed');

class pengaduan extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['pengaduan_model', 'theme_model']);
    }

    public function index()
    {
        $cari = $this->input->get('cari');
        $data = [
            'header'        => Config::first(),
            'pengaduan'     => $this->pengaduan_model->list_data($cari),
            'form_action'   => site_url('pengaduan/kirim'),
            'search_action' => site_url('pengaduan'),
            'cari'          => $cari,
            'allstatus'     => $this->pengaduan_model->get_data()->count_all_results(),
            'status1'       => $this->pengaduan_model->get_data('1')->count_all_results(),
            'status2'       => $this->pengaduan_model->get_data('2')->count_all_results(),
            'status3'       => $this->pengaduan_model->get_data('3')->count_all_results(),
        ];

        $this->load->view('pengaduan/index', $data);
    }

    public function kirim()
    {
        $result = $this->pengaduan_model->insert();

        if ($result) {
            $this->session->set_flashdata('notif', [
                'status' => 'success',
                'pesan'  => 'Pengaduan berhasil dikirim.',
            ]);
        }

        redirect('pengaduan');
    }
}
