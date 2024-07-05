<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Galery extends BaseModel
{
    public const PARRENT = 0;

    /**
     * {@inheritDoc}
     */
    protected $table = 'gambar_gallery';

    /**
     * {@inheritDoc}
     */
    public $timestamps = false;

    /**
     * {@inheritDoc}
     */
    protected $appends = ['url_gambar'];

    /**
     * {@inheritDoc}
     */
    protected $hidden = [
        'parrent', 'enabled', 'tgl_upload', 'tipe', 'slider', 'urut',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parrent');
    }

    public function getUrlGambarAttribute()
    {
        // try {
        //     return Storage::disk('ftp')->exists("desa/upload/galeri/kecil_{$this->gambar}")
        //         ? Storage::disk('ftp')->url("desa/upload/galeri/kecil_{$this->gambar}")
        //         : null;
        // } catch (Exception $e) {
        //     Log::error($e);
        // }
    }
}
