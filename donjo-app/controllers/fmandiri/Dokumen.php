<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Dokumen extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['penduduk_model', 'web_dokumen_model', 'keluarga_model', 'referensi_model']);
        $this->controller = 'layanan-mandiri/dokumen';
    }

    public function index()
    {
        $this->render('dokumen/index', [
            'dokumen'            => $this->penduduk_model->list_dokumen($this->is_login->id_pend),
            'jenis_syarat_surat' => $this->referensi_model->list_by_id('ref_syarat_surat', 'ref_syarat_id'),
        ]);
    }

    public function form($id = '')
    {
        if ($this->is_login->kk_level == '1') { //Jika Kepala Keluarga
            $data['kk'] = $this->keluarga_model->list_anggota($this->is_login->id_kk);
        }

        if ($id) {
            $data['dokumen']     = $this->web_dokumen_model->get_dokumen($id, $this->is_login->id_pend) ?? show_404();
            $data['anggota']     = array_column($this->web_dokumen_model->get_dokumen_di_anggota_lain($id), 'id_pend');
            $data['aksi']        = 'Ubah';
            $data['form_action'] = site_url("{$this->controller}/ubah/{$id}");
        } else {
            $data['dokumen']     = null;
            $data['anggota']     = null;
            $data['aksi']        = 'Tambah';
            $data['form_action'] = site_url("{$this->controller}/tambah");
        }

        $data['jenis_syarat_surat'] = $this->referensi_model->list_by_id('ref_syarat_surat', 'ref_syarat_id');

        $this->render('dokumen/form', $data);
    }

    public function tambah()
    {
        if ($this->web_dokumen_model->insert($this->is_login->id_pend, true)) {
            redirect_with('success', 'Berhasil tambah dokumen');
        } else {
            redirect_with('error', 'Gagal tambah dokumen -> ' . $this->session->error_msg);
        }
    }

    public function ubah($id = '')
    {
        $this->web_dokumen_model->get_dokumen($id) ?? show_404();

        if ($this->web_dokumen_model->update($id, $this->is_login->id_pend, true)) {
            redirect_with('success', 'Berhasil ubah dokumen');
        } else {
            redirect_with('error', 'Gagal ubah dokumen -> ' . $this->session->error_msg);
        }
    }

    public function hapus($id = '')
    {
        $this->web_dokumen_model->get_dokumen($id, $this->session->is_login->id_pend) ?? show_404();

        if ($this->web_dokumen_model->delete($id)) {
            redirect_with('success', 'Berhasil hapus dokumen');
        } else {
            redirect_with('error', 'Gagal hapus dokumen');
        }
    }

    public function unduh($id = '')
    {
        // Ambil nama berkas dari database
        if ($berkas = $this->web_dokumen_model->get_nama_berkas($id, $this->is_login->id_pend)) {
            ambilBerkas($berkas, null, null, LOKASI_DOKUMEN);
        } else {
            redirect_with('error', 'Gagal ubah dokumen');
        }
    }
}
