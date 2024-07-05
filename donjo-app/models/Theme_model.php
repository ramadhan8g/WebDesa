<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Theme_model extends CI_Model
{
    public $tema;
    public $folder;

    public function __construct()
    {
        parent::__construct();
        $this->tema   = str_replace('desa/', '', $this->setting->web_theme);
        $this->folder = preg_match('/desa\\//', strtolower($this->setting->web_theme)) ? 'desa/themes' : 'vendor/themes';
        if (empty($this->setting->web_theme) || ! file_exists(FCPATH . "{$this->folder}/{$this->tema}/template.php")) {
            $this->tema   = 'esensi';
            $this->folder = 'vendor/themes';
        }
    }

    /**
     * Tema sistem ada di subfolder themes/
     * Tema buatan sistem ada di subfolder desa/themes/
     * Hanya tampilkan tema yang memiliki file template.php
     */
    public function list_all()
    {
        $tema_sistem = glob('vendor/themes/*', GLOB_ONLYDIR);
        $tema_desa   = glob('desa/themes/*', GLOB_ONLYDIR);
        $tema_semua  = array_merge($tema_sistem, $tema_desa);
        $list_tema   = [];

        foreach ($tema_semua as $tema) {
            if (is_file(FCPATH . $tema . '/template.php')) {
                $list_tema[] = str_replace(['vendor/', 'themes/'], '', $tema);
            }
        }

        return $list_tema;
    }

    // Mengambil latar belakang website ubahan
    public function latar_website()
    {
        $ubahan_tema   = "desa/pengaturan/{$this->tema}/images/";
        $bawaan_tema   = "{$this->folder}/{$this->tema}/assets/css/images/latar_website.jpg";
        $latar_website = is_file($ubahan_tema) ? $ubahan_tema : $bawaan_tema;

        return is_file($latar_website) ? $latar_website : null;
    }

    public function lokasi_latar_website()
    {
        $folder = "desa/pengaturan/{$this->tema}/images/";
        file_exists($folder) || mkdir($folder, 0755, true);

        return $folder;
    }

    // Mengambil latar belakang login mandiri ubahan
    public function latar_login_mandiri()
    {
        return file_exists(FCPATH . LATAR_KEHADIRAN) ? LATAR_KEHADIRAN : DEFAULT_LATAR_KEHADIRAN;
    }
}
