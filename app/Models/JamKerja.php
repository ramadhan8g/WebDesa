<?php



namespace App\Models;

use Carbon\Carbon;

defined('BASEPATH') || exit('No direct script access allowed');

class JamKerja extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kehadiran_jam_kerja';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeLibur($query)
    {
        return $query->where('status', 0)->where('nama_hari', $this->getNamaHari());
    }

    public function scopeJamKerja($query)
    {
        $waktu = date('H:i');

        return $query
            ->selectRaw('id, nama_hari, jam_masuk, status, keterangan')
            ->selectRaw(sprintf('date_add(jam_keluar, interval %s minute) as jam_keluar', setting('rentang_waktu_kehadiran')))
            ->where('nama_hari', $this->getNamaHari())
            ->where(static function ($q) use ($waktu) {
                $q->whereTime('jam_masuk', '>', $waktu)
                    ->orWhereRaw('date_add(jam_keluar, interval ? minute) < ?', [setting('rentang_waktu_kehadiran'), $waktu]);
            });
    }

    protected function getNamaHari()
    {
        return Carbon::now()->dayName;
    }
}
