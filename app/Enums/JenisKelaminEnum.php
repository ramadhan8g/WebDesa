<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class JenisKelaminEnum extends BaseEnum
{
    public const LAKI_LAKI = 1;
    public const PEREMPUAN = 2;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::LAKI_LAKI => 'Laki-laki',
            self::PEREMPUAN => 'Perempuan',
        ];
    }
}
