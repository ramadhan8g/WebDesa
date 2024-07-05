<?php



use App\Models\Pamong;

defined('BASEPATH') || exit('No direct script access allowed');

class Inventaris_gedung extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['inventaris_gedung_model', 'pamong_model', 'aset_model']);
        $this->modul_ini     = 'sekretariat';
        $this->sub_modul_ini = 61;
    }

    public function index()
    {
        $data['main']   = $this->inventaris_gedung_model->list_inventaris();
        $data['total']  = $this->inventaris_gedung_model->sum_inventaris();
        $data['pamong'] = Pamong::penandaTangan()->get();
        $data['tip']    = 1;

        $this->render('inventaris/gedung/table', $data);
    }

    public function view($id)
    {
        $data['main'] = $this->inventaris_gedung_model->view($id);
        $data['tip']  = 1;

        $this->render('inventaris/gedung/view_inventaris', $data);
    }

    public function view_mutasi($id)
    {
        $data['main'] = $this->inventaris_gedung_model->view_mutasi($id);
        $data['tip']  = 2;

        $this->render('inventaris/gedung/view_mutasi', $data);
    }

    public function edit($id)
    {
        $this->redirect_hak_akses('u');
        $data['main']      = $this->inventaris_gedung_model->view($id);
        $data['aset']      = $this->aset_model->list_aset(4);
        $data['count_reg'] = $this->inventaris_gedung_model->count_reg();
        $data['get_kode']  = $this->header['desa'];
        $data['kd_reg']    = $this->inventaris_gedung_model->list_inventaris_kd_register();
        $data['tip']       = 1;

        $this->render('inventaris/gedung/edit_inventaris', $data);
    }

    public function edit_mutasi($id)
    {
        $this->redirect_hak_akses('u');
        $data['main'] = $this->inventaris_gedung_model->edit_mutasi($id);
        $data['tip']  = 2;

        $this->render('inventaris/gedung/edit_mutasi', $data);
    }

    public function form()
    {
        $this->redirect_hak_akses('u');
        $data['tip']       = 1;
        $data['get_kode']  = $this->header['desa'];
        $data['aset']      = $this->aset_model->list_aset(4);
        $data['count_reg'] = $this->inventaris_gedung_model->count_reg();

        $this->render('inventaris/gedung/form_tambah', $data);
    }

    public function form_mutasi($id)
    {
        $this->redirect_hak_akses('u');
        $data['main'] = $this->inventaris_gedung_model->view($id);
        $data['tip']  = 2;

        $this->render('inventaris/gedung/form_mutasi', $data);
    }

    public function mutasi()
    {
        $data['main'] = $this->inventaris_gedung_model->list_mutasi_inventaris();
        $data['tip']  = 2;

        $this->render('inventaris/gedung/table_mutasi', $data);
    }

    public function cetak($tahun, $penandatangan)
    {
        $data['header'] = $this->header['desa'];
        $data['total']  = $this->inventaris_gedung_model->sum_print($tahun);
        $data['print']  = $this->inventaris_gedung_model->cetak($tahun);
        $data['pamong'] = $this->pamong_model->get_data($penandatangan);

        $this->load->view('inventaris/gedung/inventaris_print', $data);
    }

    public function download($tahun, $penandatangan)
    {
        $data['header'] = $this->header['desa'];
        $data['total']  = $this->inventaris_gedung_model->sum_print($tahun);
        $data['print']  = $this->inventaris_gedung_model->cetak($tahun);
        $data['pamong'] = $this->pamong_model->get_data($penandatangan);

        $this->load->view('inventaris/gedung/inventaris_excel', $data);
    }
}
