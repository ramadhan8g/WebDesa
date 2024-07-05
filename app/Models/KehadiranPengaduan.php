<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class KehadiranPengaduan extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kehadiran_pengaduan';

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
        'waktu',
        'status',
        'keterangan',
        'id_penduduk',
        'id_pamong',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    public function pamong()
    {
        return $this->belongsTo(Pamong::class, 'id_pamong');
    }

    public function mandiri()
    {
        return $this->belongsTo(PendudukMandiri::class, 'id_penduduk');
    }
}
