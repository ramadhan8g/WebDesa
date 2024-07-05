<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Dokumen_web extends Web_Controller
{
    /**
     * Unduh berkas berdasarkan kolom dokumen.id
     *
     * @param int $id_dokumen Id berkas pada koloam dokumen.id
     *
     * @return void
     */
    public function unduh_berkas($id_dokumen)
    {
        $this->load->model('web_dokumen_model');

        // Ambil nama berkas dari database
        $berkas = $this->web_dokumen_model->get_nama_berkas($id_dokumen);
        ambilBerkas($berkas, null, null, LOKASI_DOKUMEN);
    }

    public function tampil($slug = null)
    {
        $slug        = decrypt($slug);
        $part        = explode('/', $slug);
        $nama_file   = end($part);
        $lokasi_file = str_replace($nama_file, '', $slug);

        return ambilBerkas($nama_file, null, null, $lokasi_file, true);
    }

    public function unduh($slug = null)
    {
        $slug        = decrypt($slug);
        $part        = explode('/', $slug);
        $nama_file   = end($part);
        $lokasi_file = str_replace($nama_file, '', $slug);

        return ambilBerkas($nama_file, null, null, $lokasi_file);
    }
}
