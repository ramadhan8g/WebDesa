<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'migrasi';

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
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'premium' => 'json',
    ];
}
