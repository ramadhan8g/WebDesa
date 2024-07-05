<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Garis extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'garis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'path',
        'enabled',
        'ref_line',
        'foto',
        'desk',
        'id_cluster',
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
        $foto = LOKASI_FOTO_GARIS . 'kecil_' . $this->attributes['foto'];

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
        $foto = LOKASI_FOTO_GARIS . 'sedang_' . $this->attributes['foto'];

        if (file_exists(FCPATH . $foto)) {
            return $foto;
        }

        return null;
    }
}
