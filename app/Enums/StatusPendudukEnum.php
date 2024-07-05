<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class StatusPendudukEnum
{
    public const TETAP       = 1;
    public const TIDAK_TETAP = 2;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::TETAP       => 'Tetap',
            self::TIDAK_TETAP => 'Tidak Tetap',
        ];
    }
}
