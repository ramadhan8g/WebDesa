<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class BantuanPeserta extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_peserta';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['bantuan'];

    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class, 'program_id');
    }

    /**
     * Scope query untuk peserta.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePeserta($query)
    {
        // return $query->where('peserta', auth('jwt')->user()->penduduk->nik);
    }
}
