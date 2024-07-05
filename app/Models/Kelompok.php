<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Kelompok extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelompok';

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

    /**
     * Define a one-to-many relationship.
     *
     * @return HasMany
     */
    public function ketua()
    {
        return $this->hasOne(Penduduk::class, 'id', 'id_ketua');
    }

    /**
     * Scope query untuk status kelompok
     *
     * @param mixed $query
     * @param mixed $status
     *
     * @return Builder
     */
    public function scopeStatus($query, $status = 1)
    {
        return $query->whereHas('ketua', static function ($q) use ($status) {
            $q->status($status);
        });
    }

    /**
     * Scope query untuk tipe kelompok
     *
     * @param mixed $query
     * @param mixed $tipe
     *
     * @return Builder
     */
    public function scopeTipe($query, $tipe = 'kelompok')
    {
        return $query->where('tipe', $tipe);
    }
}
