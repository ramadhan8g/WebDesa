<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Posyandu extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posyandu';

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
     * The casts with the model.
     *
     * @var array
     */
    // protected $casts = [
    //     'status' => 'boolean',
    // ];

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function peserta()
    // {
    //     return $this->hasMany(BantuanPeserta::class, 'program_id');
    // }

    /**
     * Scope query untuk status bantuan
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    // public function scopeStatus($query, $value = 1)
    // {
    //     return $query->where('status', $value);
    // }
}
