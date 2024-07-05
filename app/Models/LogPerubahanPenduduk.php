<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class LogPerubahanPenduduk extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_perubahan_penduduk';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['penduduk'];

    public function penduduk()
    {
        return $this->hasOne(Penduduk::class, 'id', 'id_pend');
    }
}
