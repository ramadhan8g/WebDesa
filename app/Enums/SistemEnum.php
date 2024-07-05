<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class SistemEnum extends BaseEnum
{
    public const WEBSITE       = 1;
    public const ADMINISTRATOR = 2;
    public const KEHADIRAN     = 4;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::WEBSITE       => 'Website',
            self::ADMINISTRATOR => 'Administrator',
            self::KEHADIRAN     => 'Kehadiran',
        ];
    }
}
