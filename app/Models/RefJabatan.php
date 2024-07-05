<?php



namespace App\Models;

use App\Traits\Author;

defined('BASEPATH') || exit('No direct script access allowed');

class RefJabatan extends BaseModel
{
    use Author;

    public const KADES  = 1;
    public const SEKDES = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_jabatan';

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'jenis',
        'tupoksi',
        'created_by',
        'updated_by',
    ];

    // get data jabatan jenis kades
    public static function getKades()
    {
        return self::whereJenis(self::KADES)->first();
    }

    // get data jabatan jenis sekdes
    public static function getSekdes()
    {
        return self::whereJenis(self::SEKDES)->first();
    }

    // get data jabatan jenis sekdes
    public static function getKadesSekdes()
    {
        return [
            self::getKades()->id,
            self::getSekdes()->id,
        ];
    }

    // scope
    public function scopeUrut($query, $order = 'ASC')
    {
        return $query->orderByRaw('CASE WHEN jenis = 0 THEN 999999 ELSE jenis END', $order);
    }
}
