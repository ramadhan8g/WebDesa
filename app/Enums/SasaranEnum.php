<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class SasaranEnum extends BaseEnum
{
    public const PENDUDUK     = 1;
    public const KELUARGA     = 2;
    public const RUMAH_TANGGA = 3;
    public const KELOMPOK     = 4;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::PENDUDUK     => 'Penduduk',
            self::KELUARGA     => 'Keluarga / KK',
            self::RUMAH_TANGGA => 'Rumah Tangga',
            self::KELOMPOK     => 'Kelompok/Organisasi Kemasyarakatan',
        ];
    }
}
