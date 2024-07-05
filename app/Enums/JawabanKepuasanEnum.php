<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class JawabanKepuasanEnum extends BaseEnum
{
    public const SANGAT_PUAS = 1;
    public const PUAS        = 2;
    public const CUKUP_PUAS  = 3;
    public const TIDAK_PUAS  = 4;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::SANGAT_PUAS => 'Sangat Puas',
            self::PUAS        => 'Puas',
            self::CUKUP_PUAS  => 'Cukup Puas',
            self::TIDAK_PUAS  => 'Tidak Puas',
        ];
    }
}
