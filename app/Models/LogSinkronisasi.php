<?php



namespace App\Models;

use App\Traits\Author;

defined('BASEPATH') || exit('No direct script access allowed');

class LogSinkronisasi extends BaseModel
{
    use Author;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_sinkronisasi';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    protected $fillable = [
        'modul',
        'created_by',
        'updated_by',
    ];
}
