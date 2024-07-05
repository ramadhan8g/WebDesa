<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class SyaratSurat extends BaseModel
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ref_syarat_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_syarat_surat';

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
    protected $fillable = ['ref_syarat_nama'];

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dokumen()
    {
        // https://github.com/OpenSID/opensid-laravel/blob/main/app/Models/SyaratSurat.php
        // return $this->hasMany(Dokumen::class, 'id_syarat')->where('id_pend', auth('jwt')->id());

        return $this->hasMany(Dokumen::class, 'id_syarat');
    }
}
