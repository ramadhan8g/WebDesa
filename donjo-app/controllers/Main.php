<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['track_model', 'grup_model']);
    }

    public function index()
    {
        // Kalau sehabis periksa data, paksa harus login lagi
        if ($this->session->periksa_data == 1) {
            $this->user_model->logout();
        }

        if (isset($_SESSION['siteman']) && $_SESSION['siteman'] == 1) {
            $this->track_model->track_desa('main');
            $this->load->model('user_model');
            $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

            switch ($grup) {
                case 1: redirect('hom_sid');
                    break;

                case 2: redirect('hom_sid');
                    break;

                case 3: redirect('web/clear');
                    break;

                case 4: redirect('web/clear');
                    break;

                default:
                    $modul_awal = $this->grup_model->modul_awal($grup);
                    redirect($modul_awal);
                    break;
            }
        } elseif ($this->setting->offline_mode > 0) {
            // Jika website hanya bisa diakses user, maka harus login dulu
            redirect('siteman');
        } else {
            redirect('/');
        }
    }
}
