<?php



defined('BASEPATH') || exit('No direct script access allowed');

/*
 * User: didikkurniawan
 * Date: 10/1/16
 * Time: 06:59
 */
class Api_inventaris_tanah extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventaris_tanah_model');
    }

    public function add()
    {
        $this->redirect_hak_akses('u');
        $data = $this->inventaris_tanah_model->add([
            'nama_barang'        => $this->input->post('nama_barang_save', true),
            'kode_barang'        => $this->input->post('kode_barang', true),
            'register'           => $this->input->post('register', true),
            'luas'               => bilangan($this->input->post('luas')),
            'tahun_pengadaan'    => bilangan($this->input->post('tahun_pengadaan')),
            'letak'              => $this->input->post('letak', true),
            'hak'                => $this->input->post('hak', true),
            'no_sertifikat'      => $this->input->post('no_sertifikat', true),
            'tanggal_sertifikat' => $this->input->post('tanggal_sertifikat', true),
            'penggunaan'         => $this->input->post('penggunaan', true),
            'asal'               => $this->input->post('asal', true),
            'harga'              => bilangan($this->input->post('harga')),
            'keterangan'         => $this->input->post('keterangan', true),
            'visible'            => 1,
            'created_by'         => $this->session->user,
            'updated_by'         => $this->session->user,
        ]);
        if ($data) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
        redirect('inventaris_tanah');
    }

    public function add_mutasi()
    {
        $this->redirect_hak_akses('u');
        $id_asset = $this->input->post('id_inventaris_tanah');
        $data     = $this->inventaris_tanah_model->add_mutasi([
            'id_inventaris_tanah' => $id_asset,
            'jenis_mutasi'        => $this->input->post('mutasi'),
            'status_mutasi'       => $this->input->post('status_mutasi'),
            'tahun_mutasi'        => $this->input->post('tahun_mutasi'),
            'harga_jual'          => $this->input->post('harga_jual'),
            'sumbangkan'          => $this->input->post('sumbangkan'),
            'keterangan'          => $this->input->post('keterangan'),
            'visible'             => 1,
            'created_by'          => $this->session->user,
            'updated_by'          => $this->session->user,
        ]);
        if ($data) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
        redirect('inventaris_tanah/mutasi');
    }

    public function update($id)
    {
        $this->redirect_hak_akses('u');
        $data = $this->inventaris_tanah_model->update($id, [
            'nama_barang'        => $this->input->post('nama_barang_save', true),
            'kode_barang'        => $this->input->post('kode_barang', true),
            'register'           => $this->input->post('register', true),
            'luas'               => bilangan($this->input->post('luas')),
            'tahun_pengadaan'    => bilangan($this->input->post('tahun_pengadaan')),
            'letak'              => $this->input->post('letak', true),
            'hak'                => $this->input->post('hak', true),
            'no_sertifikat'      => $this->input->post('no_sertifikat', true),
            'tanggal_sertifikat' => $this->input->post('tanggal_sertifikat', true),
            'penggunaan'         => $this->input->post('penggunaan', true),
            'asal'               => $this->input->post('asal', true),
            'harga'              => bilangan($this->input->post('harga')),
            'keterangan'         => $this->input->post('keterangan', true),
            'updated_at'         => date('Y-m-d H:i:s'),
            'visible'            => 1,
        ]);
        if ($data) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
        redirect('inventaris_tanah');
    }

    public function update_mutasi($id)
    {
        $this->redirect_hak_akses('u');
        $id_asset = $this->input->post('id_asset');
        $data     = $this->inventaris_tanah_model->update_mutasi($id, [
            'jenis_mutasi'  => ($this->input->post('status_mutasi') == 'Hapus') ? $this->input->post('mutasi') : null,
            'status_mutasi' => $this->input->post('status_mutasi'),
            'tahun_mutasi'  => $this->input->post('tahun_mutasi'),
            'harga_jual'    => $this->input->post('harga_jual') || null,
            'sumbangkan'    => $this->input->post('sumbangkan') || null,
            'keterangan'    => $this->input->post('keterangan'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'visible'       => 1,
        ]);
        if ($data) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
        redirect('inventaris_tanah/mutasi');
    }

    public function delete($id)
    {
        $this->redirect_hak_akses('h', 'inventaris_tanah');
        $data = $this->inventaris_tanah_model->delete($id);
        if ($data) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
        redirect('inventaris_tanah');
    }

    public function delete_mutasi($id)
    {
        $this->redirect_hak_akses('h', 'inventaris_tanah/mutasi');
        $data = $this->inventaris_tanah_model->delete_mutasi($id);
        if ($data) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
        redirect('inventaris_tanah/mutasi');
    }
}
