<?php



namespace App\Enums;

defined('BASEPATH') || exit('No direct script access allowed');

class HubunganRTMEnum extends BaseEnum
{
    public const KEPALA_RUMAH_TANGGA = 1;
    public const ANGGOTA             = 2;

    /**
     * Override method all()
     */
    public static function all(): array
    {
        return [
            self::KEPALA_RUMAH_TANGGA => 'Kepala Rumah Tangga',
            self::ANGGOTA             => 'Anggota',
        ];
    }
}
