<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class StatusDasarEnum
{
    public const HIDUP       = 1;
    public const MATI        = 2;
    public const PINDAH      = 3;
    public const HILANG      = 4;
    public const PERGI       = 6;
    public const TIDAK_VALID = 9;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::HIDUP       => 'Hidup',
            self::MATI        => 'Mati',
            self::PINDAH      => 'Pindah',
            self::HILANG      => 'Hilang',
            self::PERGI       => 'Pergi',
            self::TIDAK_VALID => 'Tidak Valid',
        ];
    }
}
