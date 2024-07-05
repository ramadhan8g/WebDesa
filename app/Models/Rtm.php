<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Rtm extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tweb_rtm';

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
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function kepalaKeluarga()
    {
        return $this->hasOne(Penduduk::class, 'id', 'nik_kepala');
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function anggota()
    {
        return $this->hasMany(Penduduk::class, 'id_rtm', 'no_kk');
    }

    /**
     * Scope query untuk status rumah tangga
     *
     * @return Builder
     */
    public function scopeStatus()
    {
        return static::whereHas('kepalaKeluarga', static function ($query) {
            $query->status()->where('rtm_level', '1');
        });
    }
}
