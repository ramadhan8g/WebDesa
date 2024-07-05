<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class DaftarKontak extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontak';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_kontak';

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'telepon',
        'email',
        'telegram',
        'hubung_warga',
        'keterangan',
    ];
}
