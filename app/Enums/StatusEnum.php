<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class StatusEnum extends BaseEnum
{
    public const YA    = 1;
    public const TIDAK = 0;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::YA    => 'Ya',
            self::TIDAK => 'Tidak',
        ];
    }
}
