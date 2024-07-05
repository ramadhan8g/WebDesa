<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

use App\Traits\Author;

class LogRestoreDesa extends BaseModel
{
    use Author;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_restore_desa';

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
