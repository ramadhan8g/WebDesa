<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class RefDokumen extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_dokumen';

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
    ];
}
