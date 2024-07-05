<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class SatuanWaktuEnum extends BaseEnum
{
    public const HARI   = 1;
    public const MINGGU = 2;
    public const BULAN  = 3;
    public const TAHUN  = 4;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::HARI   => 'Hari',
            self::MINGGU => 'Minggu',
            self::BULAN  => 'Bulan',
            self::TAHUN  => 'Tahun',
        ];
    }
}
