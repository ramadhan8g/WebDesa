<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class KlasifikasiSurat extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'klasifikasi_surat';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'nama',
        'uraian',
        'enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Scope query untuk enabled
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    public function scopeEnabled($query, $value = 1)
    {
        return $query->where('enabled', $value);
    }
}
