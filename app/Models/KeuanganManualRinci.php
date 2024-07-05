<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class KeuanganManualRinci extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keuangan_manual_rinci';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'Tahun',
        'Kd_Akun',
        'Kd_Keg',
        'Kd_Rincian',
        'Nilai_Anggaran',
        'Nilai_Realisasi',
    ];

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];
}
