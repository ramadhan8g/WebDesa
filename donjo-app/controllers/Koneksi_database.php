<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Koneksi_database extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->db_error['code'] !== 1049) {
            redirect(site_url());
        }

        return view('periksa.koneksi');
    }
}
