<?php



use App\Models\Config;
use Illuminate\Support\Facades\Schema;

defined('BASEPATH') || exit('No direct script access allowed');

class Header_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache');
    }

    // ---
    public function get_data()
    {
        $outp['desa']  = Schema::hasColumn('tweb_desa_pamong', 'jabatan_id') ? Config::first() : null;
        $outp['modul'] = $this->cache->pakai_cache(function () {
            $this->load->model('modul_model');

            return $this->modul_model->list_aktif();
        }, "{$this->session->user}_cache_modul", 604800);

        return $outp;
    }
}
