<?php



use App\Models\KehadiranPengaduan;
use App\Models\Pamong;
use Illuminate\Support\Facades\DB;

defined('BASEPATH') || exit('No direct script access allowed');

class Kehadiran_perangkat extends Mandiri_Controller
{
    public function index()
    {
        $kehadiran = Pamong::kehadiranPamong()
            ->daftar()
            ->where(static function ($query) {
                $query->where('tanggal', DB::raw('curdate()'))
                    ->orWhereNull('tanggal');
            })
            ->orderBy('urut')
            ->get();
        $perangkat = $kehadiran->each(function ($item) {
            if ($item->id_penduduk != $this->session->is_login->id_pend) {
                return $item->id_penduduk = 0;
            }

            return $item;
        })->values()->all();

        $this->render('kehadiran', compact('perangkat'));
    }

    public function lapor($id)
    {
        $data = [
            'waktu'       => date('Y-m-d H:i:s'),
            'status'      => 1,
            'id_penduduk' => $this->session->is_login->id_pend,
            'id_pamong'   => $id,
        ];

        if (KehadiranPengaduan::create($data)) {
            redirect('layanan-mandiri/kehadiran');
        }

        redirect('layanan-mandiri/kehadiran');
    }
}
