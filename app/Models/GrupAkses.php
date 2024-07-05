<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class GrupAkses extends BaseModel
{
    public const ADMINISTRATOR = 1;
    public const OPERATOR      = 2;
    public const REDAKSI       = 3;
    public const KONTRIBUTOR   = 4;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grup_akses';
}
