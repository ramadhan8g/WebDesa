<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class LogPenduduk extends BaseModel
{
    /**
     * KETERANGAN kode_peristiwa di log_penduduk
     * 1 = insert penduduk baru dengan status lahir
     * 2 = penduduk mati
     * 3 = penduduk pindah keluar
     * 4 = penduduk hilang
     * 5 = insert penduduk baru pindah masuk
     * 6 = penduduk tidak tetap pergi
     */
    public const BARU_LAHIR = 1;

    public const MATI              = 2;
    public const PINDAH_KELUAR     = 3;
    public const HILANG            = 4;
    public const BARU_PINDAH_MASUK = 5;
    public const TIDAK_TETAP_PERGI = 6;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_penduduk';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'tgl_lapor'     => 'datetime:Y-m-d',
        'tgl_peristiwa' => 'datetime:Y-m-d',
    ];
}
