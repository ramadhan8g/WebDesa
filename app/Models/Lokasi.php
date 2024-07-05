<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Lokasi extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lokasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'path',
        'enabled',
        'ref_polygon',
        'foto',
        'id_cluster',
        'desk',
    ];

    /**
     * The appends with the model.
     *
     * @var array
     */
    protected $appends = [
        'foto_kecil',
        'foto_sedang',
    ];

    /**
     * Getter untuk foto kecil.
     *
     * @return string
     */
    public function getFotoKecilAttribute()
    {
        $foto = LOKASI_FOTO_LOKASI . 'kecil_' . $this->attributes['foto'];

        if (file_exists(FCPATH . $foto)) {
            return $foto;
        }

        return null;
    }

    /**
     * Getter untuk foto sedang.
     *
     * @return string
     */
    public function getFotoSedangAttribute()
    {
        $foto = LOKASI_FOTO_LOKASI . 'sedang_' . $this->attributes['foto'];

        if (file_exists(FCPATH . $foto)) {
            return $foto;
        }

        return null;
    }
}
