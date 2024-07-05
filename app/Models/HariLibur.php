<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class HariLibur extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kehadiran_hari_libur';

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
        'tanggal',
        'keterangan',
    ];
}
