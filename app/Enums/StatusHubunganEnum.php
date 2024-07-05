<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class StatusHubunganEnum
{
    public const KEPALA_KELUARGA = 1;
    public const SUAMI           = 2;
    public const ISTRI           = 3;
    public const ANAK            = 4;
    public const MENANTU         = 5;
    public const CUCU            = 6;
    public const ORANGTUA        = 7;
    public const MERTUA          = 8;
    public const FAMILI_LAIN     = 9;
    public const PEMBANTU        = 10;
    public const LAINNYA         = 11;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::KEPALA_KELUARGA => 'Kepala Keluarga',
            self::SUAMI           => 'Suami',
            self::ISTRI           => 'Istri',
            self::ANAK            => 'Anak',
            self::MENANTU         => 'Menantu',
            self::CUCU            => 'Cucu',
            self::ORANGTUA        => 'Orang Tua',
            self::MERTUA          => 'Mertua',
            self::FAMILI_LAIN     => 'Famili Lain',
            self::PEMBANTU        => 'Pembantu',
            self::LAINNYA         => 'Lainnya',
        ];
    }
}
