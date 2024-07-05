<?php



use App\Models\Kehadiran;
use App\Models\Pamong;
use Illuminate\Support\Facades\DB;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;

defined('BASEPATH') || exit('No direct script access allowed');

class Kehadiran_rekapitulasi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 'kehadiran';
        $this->sub_modul_ini      = 'rekapitulasi';
        $this->header['kategori'] = 'kehadiran';
    }

    public function index()
    {
        $pamong    = Pamong::daftar()->get();
        $kehadiran = Kehadiran::get();

        return view('admin.rekapitulasi.index', compact('pamong', 'kehadiran'));
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            $filters = [
                'tanggal' => $this->input->get('daterange'),
                'status'  => $this->input->get('status'),
                'pamong'  => $this->input->get('pamong'),
            ];

            return datatables()->of(Kehadiran::with(['pamong', 'pamong.penduduk', 'pamong.jabatan'])
                ->select('*', DB::raw('TIMEDIFF( jam_keluar, jam_masuk ) as total'))
                ->filter($filters))
                ->addIndexColumn()
                ->editColumn('tanggal', static function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->editColumn('jam_masuk', static function ($row) {
                    return date('H:i', strtotime($row->jam_masuk));
                })
                ->editColumn('jam_keluar', static function ($row) {
                    return $row->jam_keluar == null ? '-' : date('H:i', strtotime($row->jam_keluar));
                })
                ->editColumn('total', static function ($row) {
                    return date('H:i', strtotime($row->total));
                })
                ->editColumn('status_kehadiran', static function ($row) {
                    $tipe = ($row->status_kehadiran == 'hadir') ? 'success' : (($row->status_kehadiran == 'tidak berada di kantor') ? 'danger' : 'warning');

                    return '<span class="label label-' . $tipe . '">' . ucwords($row->status_kehadiran) . ' </span>';
                })
                ->rawColumns(['status_kehadiran'])
                ->make();
        }

        return show_404();
    }

    public function ekspor()
    {
        $filters = [
            'tanggal' => $this->input->get('daterange'),
            'status'  => $this->input->get('status'),
            'pamong'  => $this->input->get('pamong'),
        ];

        $judul = [
            'Nama',
            'Jabatan',
            'Tanggal',
            'Jam Masuk',
            'Jam Keluar',
            'Total Waktu',
            'Status Kehadiran',
        ];

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser(namafile('kehadiran') . '.xlsx');
        $writer->addRow(WriterEntityFactory::createRowFromArray($judul));

        $data_kehadiran = Kehadiran::with(['pamong'])
            ->select('*', Kehadiran::raw('TIMEDIFF( jam_keluar, jam_masuk ) as total'))
            ->filter($filters)
            ->get();

        foreach ($data_kehadiran as $row) {
            $data = [
                $row->pamong->pamong_nama != null ? $row->pamong->pamong_nama : $row->pamong->penduduk->nama,
                $row->pamong->jabatan->nama,
                tgl_indo($row->tanggal),
                date('H:i', strtotime($row->jam_masuk)),
                $row->jam_keluar == null ? '-' : date('H:i', strtotime($row->jam_keluar)),
                date('H:i', strtotime($row->total)),
                ucwords($row->status_kehadiran),
            ];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }
}
