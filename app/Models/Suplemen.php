<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Suplemen extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'suplemen';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'slug',
        'sasaran',
        'keterangan',
    ];
}
