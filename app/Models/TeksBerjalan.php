<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class TeksBerjalan extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teks_berjalan';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The casts with the model.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Scope query untuk status
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    // TODO :: ganti jadi YA (1) dan TIDAK (0)
    public function scopeStatus($query, $value = 1)
    {
        return $query->where('status', $value);
    }

    /**
     * Scope query untuk tipe
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    public function scopeTipe($query, $value = 1)
    {
        return $query->where('tipe', $value);
    }
}
