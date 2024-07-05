<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class LogBackup extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_backup';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    protected $fillable = ['ukuran', 'path', 'status', 'downloaded_at', 'permanen', 'pid_process'];
    protected $casts    = [
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H:i:s',
        'downloaded_at' => 'datetime:Y-m-d H:i:s',
    ];
}
