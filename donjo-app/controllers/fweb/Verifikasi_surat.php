<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Verifikasi_surat extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['keluar_model', 'url_shortener_model', 'stat_shortener_model']);
    }

    public function cek($alias = null)
    {
        $cek = $this->url_shortener_model->get_url($alias);
        if (! $cek) {
            show_404();
        }

        $this->stat_shortener_model->add_log($cek->id);

        redirect($cek->url);
    }

    public function encode($id_dokumen = null)
    {
        $id_encoded = $this->url_shortener_model->encode_id($id_dokumen);

        redirect('verifikasi-surat/' . $id_encoded);
    }

    public function decode($id_encoded = null)
    {
        $id_decoded = $this->url_shortener_model->decode_id($id_encoded);

        $data['config'] = $this->header;
        $data['surat']  = $this->keluar_model->verifikasi_data_surat($id_decoded, $this->header['kode_desa']);

        if (! $data['surat']) {
            show_404();
        }

        $this->load->view("{$this->includes['folder_themes']}/partials/surat/index", $data);
    }
}
