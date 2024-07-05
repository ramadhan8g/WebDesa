<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Info_sistem extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'pengaturan';
        $this->sub_modul_ini = 'info-sistem';
        $this->load->helper('directory');
    }

    public function index()
    {
        // Logs viewer
        $this->load->library('Log_Viewer');

        $data                      = $this->log_viewer->showLogs();
        $data['ekstensi']          = $this->setting_model->cekEkstensi();
        $data['kebutuhan_sistem']  = $this->setting_model->cekKebutuhanSistem();
        $data['php']               = $this->setting_model->cekPhp();
        $data['mysql']             = $this->setting_model->cekDatabase();
        $data['disable_functions'] = $this->setting_model->disableFunctions();
        // $data['free_space']        = $this->convertDisk(disk_free_space('/'));
        // $data['total_space']       = $this->convertDisk(disk_total_space('/'));
        $data['disk'] = false;

        $this->render('setting/info_sistem/index', $data);
    }

    public function remove_log()
    {
        $path = config_item('log_path');
        $file = base64_decode($this->input->get('f'), true);

        if ($this->input->post()) {
            $files = $this->input->post('id_cb');

            foreach ($files as $file) {
                $file = $path . basename($file);
                unlink($file);
            }
        }

        redirect($this->controller);
    }

    private function convertDisk($disk)
    {
        $si_prefix = ['B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
        $base      = 1024;
        $class     = min((int) log($disk, $base), count($si_prefix) - 1);

        return sprintf('%1.2f', $disk / $base ** $class) . ' ' . $si_prefix[$class] . '<br />';
    }

    public function cache_desa()
    {
        $dir = config_item('cache_path');

        foreach (directory_map($dir) as $file) {
            if ($file !== 'index.html') {
                unlink($dir . DIRECTORY_SEPARATOR . $file);
            }
        }

        status_sukses(true);

        redirect($this->controller);
    }

    public function cache_blade()
    {
        $dir = config_item('cache_blade');

        foreach (directory_map($dir) as $file) {
            if ($file !== 'index.html') {
                unlink($dir . DIRECTORY_SEPARATOR . $file);
            }
        }

        status_sukses(true);

        redirect($this->controller);
    }
}
