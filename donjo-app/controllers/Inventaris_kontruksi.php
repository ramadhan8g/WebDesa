<?php



use App\Models\Pamong;

defined('BASEPATH') || exit('No direct script access allowed');

class Inventaris_kontruksi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['inventaris_kontruksi_model', 'pamong_model', 'aset_model']);
        $this->modul_ini     = 'sekretariat';
        $this->sub_modul_ini = 61;
    }

    public function index()
    {
        $data['main']   = $this->inventaris_kontruksi_model->list_inventaris();
        $data['total']  = $this->inventaris_kontruksi_model->sum_inventaris();
        $data['pamong'] = Pamong::penandaTangan()->get();
        $data['tip']    = 1;

        $this->render('inventaris/kontruksi/table', $data);
    }

    public function view($id)
    {
        $data['main'] = $this->inventaris_kontruksi_model->view($id);
        $data['tip']  = 1;

        $this->render('inventaris/kontruksi/view_inventaris', $data);
    }

    public function edit($id)
    {
        $this->redirect_hak_akses('u');
        $data['main'] = $this->inventaris_kontruksi_model->view($id);
        $data['tip']  = 1;

        $this->render('inventaris/kontruksi/edit_inventaris', $data);
    }

    public function form()
    {
        $this->redirect_hak_akses('u');
        $data['tip'] = 1;

        $this->render('inventaris/kontruksi/form_tambah', $data);
    }

    public function cetak($tahun, $penandatangan)
    {
        $data['header'] = $this->header['desa'];
        $data['total']  = $this->inventaris_kontruksi_model->sum_print($tahun);
        $data['print']  = $this->inventaris_kontruksi_model->cetak($tahun);
        $data['pamong'] = $this->pamong_model->get_data($penandatangan);

        $this->load->view('inventaris/kontruksi/inventaris_print', $data);
    }

    public function download($tahun, $penandatangan)
    {
        $data['header'] = $this->header['desa'];
        $data['total']  = $this->inventaris_kontruksi_model->sum_print($tahun);
        $data['print']  = $this->inventaris_kontruksi_model->cetak($tahun);
        $data['pamong'] = $this->pamong_model->get_data($penandatangan);

        $this->load->view('inventaris/kontruksi/inventaris_excel', $data);
    }
}
