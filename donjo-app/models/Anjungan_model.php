<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Anjungan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notif_model');
    }

    public function cek_anjungan()
    {
        $ip          = $this->input->ip_address();
        $mac_address = $mac_address ?: $this->session->mac_address;

        try {
            $this->db
                ->group_start()
                ->where('ip_address', $ip)
                ->or_where('id_pengunjung', $_COOKIE['pengunjung']);
            if ($mac_address) {
                $this->db->or_where('mac_address', $mac_address);
            }

            return $this->db
                ->group_end()
                ->where('status', 1)
                ->order_by('tipe', 'asc')
                ->get('anjungan')
                ->row_array();
        } catch (MY_Exceptions $e) {
            return [];
        }
    }
}
