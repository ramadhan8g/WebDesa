<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class DisposisiSuratmasuk extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'disposisi_surat_masuk';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_disposisi';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_surat_masuk',
        'id_desa_pamong',
        'disposisi_ke',
    ];
}
