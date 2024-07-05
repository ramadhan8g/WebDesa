<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class GrupKontak extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontak_grup';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_grup';

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'nama_grup',
        'keterangan',
    ];

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function anggota()
    {
        return $this->hasMany(AnggotaGrup::class, 'id_grup', 'id_grup');
    }
}
