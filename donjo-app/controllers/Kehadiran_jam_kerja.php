<?php



use App\Models\JamKerja;

defined('BASEPATH') || exit('No direct script access allowed');

class Kehadiran_jam_kerja extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 'kehadiran';
        $this->sub_modul_ini      = 'jam-kerja';
        $this->header['kategori'] = 'kehadiran';
    }

    public function index()
    {
        return view('admin.jam_kerja.index');
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            return datatables()->of(JamKerja::query())
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    if (can('u')) {
                        return '<a href="' . route('kehadiran_jam_kerja.form', $row->id) . '" class="btn btn-warning btn-sm"  title="Ubah Data"><i class="fa fa-edit"></i></a> ';
                    }
                })
                ->editColumn('status', static function ($row) {
                    return ($row->status == 1) ? '<span class="label label-success">Hari Kerja</span>' : '<span class="label label-danger">Hari Libur</span>';
                })
                ->editColumn('jam_masuk', static function ($row) {
                    return date('H:i', strtotime($row->jam_masuk));
                })
                ->editColumn('jam_keluar', static function ($row) {
                    return date('H:i', strtotime($row->jam_keluar));
                })
                ->rawColumns(['aksi', 'status'])
                ->make();
        }

        return show_404();
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u');

        $action      = 'Ubah';
        $form_action = route('kehadiran_jam_kerja.update', $id);

        $kehadiran_jam_kerja = JamKerja::findOrFail($id);

        return view('admin.jam_kerja.form', compact('action', 'form_action', 'kehadiran_jam_kerja'));
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u');

        $update = JamKerja::findOrFail($id);

        if ($update->update($this->validate($this->request))) {
            redirect_with('success', 'Berhasil Ubah Data');
        }

        redirect_with('error', 'Gagal Ubah Data');
    }

    private function validate($request = [])
    {
        return [
            'jam_masuk'  => (string) date('H:i:s', strtotime($request['jam_masuk'])),
            'jam_keluar' => (string) date('H:i:s', strtotime($request['jam_keluar'])),
            'status'     => (int) ($request['status']),
            'keterangan' => strip_tags($request['keterangan']),
        ];
    }
}
