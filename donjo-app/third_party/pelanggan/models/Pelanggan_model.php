<?php



defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

class Pelanggan_model extends MY_Model
{
    /**
     * @var Client HTTP Client
     */
    protected $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client();
    }

    public function status_langganan()
    {
        if (empty($response = $this->api_pelanggan_pemesanan()) || config_item('demo_mode')) {
            return null;
        }

        $tgl_akhir = $response->body->tanggal_berlangganan->akhir;

        if (empty($tgl_akhir)) { // pemesanan bukan premium
            if ($response->body->pemesanan) {
                foreach ($response->body->pemesanan as $pemesanan) {
                    $akhir[] = $pemesanan->tgl_akhir;
                }

                $masa_berlaku = calculate_date_intervals($akhir);
            }
        } else { // pemesanan premium
            $tgl_akhir    = strtotime($tgl_akhir);
            $masa_berlaku = round(($tgl_akhir - time()) / (60 * 60 * 24));
        }

        switch (true) {
            case $masa_berlaku > 30:
                $status = ['status' => 1, 'warna' => 'lightgreen', 'ikon' => 'fa-battery-full'];
                break;

            case $masa_berlaku > 10:
                $status = ['status' => 2, 'warna' => 'orange', 'ikon' => 'fa-battery-half'];
                break;

            default:
                $status = ['status' => 3, 'warna' => 'pink', 'ikon' => 'fa-battery-empty'];
        }
        $status['masa'] = $masa_berlaku;

        return $status;
    }

    /**
     * Ambil data pemesanan dari api layanan.opendeda.id
     *
     * @return mixed
     */
    public function api_pelanggan_pemesanan()
    {
        if (empty($this->setting->layanan_opendesa_token)) {
            $this->session->set_userdata('error_status_langganan', 'Token Pelanggan Kosong.');

            return null;
        }

        if ($cache = $this->cache->file->get('status_langganan')) {
            $this->session->set_userdata('error_status_langganan', 'Tunggu sebentar, halaman akan dimuat ulang.');

            return $cache;
        }
    }
}
