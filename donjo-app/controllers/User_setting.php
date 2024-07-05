<?php



use App\Models\Config;

defined('BASEPATH') || exit('No direct script access allowed');

class User_setting extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('passwords');
        $this->load->library('Reset/Password', '', 'password');
        $this->load->library('OTP/OTP_manager', null, 'otp_library');
        $this->load->model('user_model');
    }

    public function index()
    {
        $id           = $_SESSION['user'];
        $data['main'] = $this->user_model->get_user($id);
        $this->load->view('setting', $data);
    }

    public function update_password($id = '')
    {
        $this->user_model->update_password($id);
        if ($this->session->success == -1) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('main');
        }
    }

    // Kata sandi harus 6 sampai 20 karakter dan sekurangnya berisi satu angka dan satu huruf besar dan satu huruf kecil
    public function syarat_sandi($str)
    {
        return (bool) (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/', $str));
    }

    public function change_pwd()
    {
        $id                  = $_SESSION['user'];
        $data['main']        = $this->user_model->get_user($id);
        $data['header']      = Config::first();
        $data['latar_login'] = to_base64(default_file(LATAR_SITEMAN, DEFAULT_LATAR_SITEMAN));
        $this->load->view('setting_pwd', $data);
    }
}
