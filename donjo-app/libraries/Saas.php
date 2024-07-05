<?php



use Carbon\Carbon;

class Saas
{
    /**
     * @var CI_Controller
     */
    protected $ci;

    public function __construct()
    {
        $this->ci = get_instance();
    }

    /**
     * Peringatatan informasi layanan Saas.
     *
     * @return mixed
     */
    public function peringatan()
    {
        if ($layanan = $this->ci->cache->file->get('status_langganan')) {
            return collect($layanan->body->pemesanan)
                ->map(static function ($data) {
                    $saas                   = collect($data->layanan)->where('nama', 'Langganan SaaS')->first();
                    $saas->tgl_mulai        = Carbon::parse($data->tgl_mulai);
                    $saas->tgl_akhir        = Carbon::parse($data->tgl_akhir);
                    $saas->status_pemesanan = $data->status_pemesanan;
                    $saas->sisa_aktif       = $saas->tgl_akhir->diffInDays(Carbon::now()) + 1;

                    return $saas;
                })
                ->filter(static function ($data) {
                    if (isset($data->nama)) {
                        return $data;
                    }
                });
        }

        return collect();
    }
}
