<?php



use App\Models\SyaratSurat;

defined('BASEPATH') || exit('No direct script access allowed');

class Surat_mohon extends Admin_Controller
{
    private $viewPath = 'admin.syaratan_surat';

    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'layanan-surat';
        $this->sub_modul_ini = 'daftar-persyaratan';
    }

    public function index()
    {
        return view("{$this->viewPath}.index");
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            return datatables()->of(SyaratSurat::query())
                ->addColumn('ceklist', static function ($row) {
                    if (can('h')) {
                        return '<input type="checkbox" name="id_cb[]" value="' . $row->ref_syarat_id . '"/>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    $aksi = '';

                    if (can('u')) {
                        $aksi .= '<a href="' . route('surat_mohon.form', $row->ref_syarat_id) . '" class="btn btn-warning btn-sm"  title="Ubah Data"><i class="fa fa-edit"></i></a> ';
                    }

                    if (can('h')) {
                        $aksi .= '<a href="#" data-href="' . route('surat_mohon.delete', $row->ref_syarat_id) . '" class="btn bg-maroon btn-sm"  title="Hapus Data" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></a> ';
                    }

                    return $aksi;
                })
                ->rawColumns(['ceklist', 'aksi'])
                ->make();
        }

        return show_404();
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u');

        if ($id) {
            $action      = 'Ubah';
            $form_action = route('surat_mohon.update', $id);

            $ref_syarat_surat = SyaratSurat::findOrFail($id);
        } else {
            $action           = 'Tambah';
            $form_action      = route('surat_mohon.insert');
            $ref_syarat_surat = null;
        }

        return view("{$this->viewPath}.form", compact('action', 'form_action', 'ref_syarat_surat'));
    }

    public function insert()
    {
        $this->redirect_hak_akses('u');

        if (SyaratSurat::create(static::validate($this->request))) {
            redirect_with('success', 'Berhasil Tambah Data');
        }
        redirect_with('error', 'Gagal Tambah Data');
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u');

        $data = SyaratSurat::findOrFail($id);

        if ($data->update(static::validate($this->request))) {
            redirect_with('success', 'Berhasil Ubah Data');
        }
        redirect_with('error', 'Gagal Ubah Data');
    }

    public function delete($id = '')
    {
        $this->redirect_hak_akses('h');

        if (SyaratSurat::destroy($id)) {
            redirect_with('success', 'Berhasil Hapus Data');
        }
        redirect_with('error', 'Gagal Hapus Data');
    }

    public function deleteAll()
    {
        $this->redirect_hak_akses('h');

        if (SyaratSurat::destroy($this->request['id_cb'])) {
            redirect_with('success', 'Berhasil Hapus Data');
        }
        redirect_with('error', 'Gagal Hapus Data');
    }

    // Hanya filter inputan
    protected static function validate($request = [])
    {
        return [
            'ref_syarat_nama' => nama_terbatas($request['ref_syarat_nama']),
        ];
    }
}
