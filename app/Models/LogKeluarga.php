<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class LogKeluarga extends BaseModel
{
    /**
     * KETERANGAN id_peristiwa di log_keluarga
     * 1 - keluarga baru
     * 2 - kepala keluarga status dasar 'mati'
     * 3 - kepala keluarga status dasar 'pindah'
     * 4 - kepala keluarga status dasar 'hilang'
     * 5 - keluarga baru datang
     * 6 - kepala keluarga status dasar 'pergi' (seharusnya tidak ada)
     * 11- kepala keluarga status dasar 'tidak valid' (seharusnya tidak ada)
     * 12- anggota keluarga keluar atau pecah dari keluarga
     * 13 - keluarga dihapus
     * 14 - kepala keluarga status dasar kembali 'hidup' (salah mengisi di log_penduduk)
     */
    public const KELUARGA_BARU = 1;

    public const KEPALA_KELUARGA_MATI          = 2;
    public const KEPALA_KELUARGA_PINDAH        = 3;
    public const KEPALA_KELUARGA_HILANG        = 4;
    public const KELUARGA_BARU_DATANG          = 5;
    public const KEPALA_KELUARGA_PERGI         = 6;
    public const KEPALA_KELUARGA_TIDAK_VALID   = 11;
    public const ANGGOTA_KELUARGA_PECAH        = 12;
    public const KELUARGA_HAPUS                = 13;
    public const KEPALA_KELUARGA_KEMBALI_HIDUP = 14;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_keluarga';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];
}
