<?php



use App\Models\KehadiranPengaduan;

defined('BASEPATH') || exit('No direct script access allowed');

class Kehadiran_pengaduan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 'kehadiran';
        $this->sub_modul_ini      = 'kehadiran-pengaduan';
        $this->header['kategori'] = 'kehadiran';
    }

    public function index()
    {
        return view('admin.pengaduan.index');
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            return datatables()->of(KehadiranPengaduan::with(['pamong.penduduk', 'mandiri.penduduk']))
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    if (can('u')) {
                        return '<a href="' . route('kehadiran_pengaduan.form', $row->id) . '" class="btn btn-warning btn-sm"  title="Ubah Data"><i class="fa fa-edit"></i></a> ';
                    }
                })
                ->editColumn('waktu', static function ($row) {
                    return tgl_indo2($row->waktu);
                })
                ->rawColumns(['aksi'])
                ->make();
        }

        return show_404();
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u');

        $action      = 'Ubah';
        $form_action = route('kehadiran_pengaduan.update', $id);

        $kehadiran_pengaduan = KehadiranPengaduan::findOrFail($id);

        return view('admin.pengaduan.form', compact('action', 'form_action', 'kehadiran_pengaduan'));
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u');

        $update = KehadiranPengaduan::findOrFail($id);

        if ($update->update($this->validate($this->request))) {
            redirect_with('success', 'Berhasil Ubah Data');
        }

        redirect_with('error', 'Gagal Ubah Data');
    }

    private function validate($request = [])
    {
        return [
            'keterangan' => strip_tags($request['keterangan']),
        ];
    }
}
