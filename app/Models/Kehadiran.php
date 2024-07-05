<?php



namespace App\Models;

use Carbon\Carbon;

defined('BASEPATH') || exit('No direct script access allowed');

class Kehadiran extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kehadiran_perangkat_desa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal',
        'pamong_id',
        'jam_masuk',
        'jam_keluar',
        'status_kehadiran',
    ];

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define a many-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function pamong()
    {
        return $this->belongsTo(Pamong::class, 'pamong_id', 'pamong_id');
    }

    public function scopeLupaAbsen($query, $tanggal)
    {
        $jam = JamKerja::where('nama_hari', Carbon::createFromFormat('Y-m-d', $tanggal)->dayName)->first('jam_keluar');

        return $query->where('tanggal', $tanggal)
            ->where('status_kehadiran', 'hadir')
            ->where('jam_keluar', null)
            ->take(1)
            ->update([
                'jam_keluar'       => $jam->jam_keluar,
                'status_kehadiran' => 'lupa melapor keluar',
            ]);
    }

    public function scopeFilter($query, array $filters)
    {
        if (! empty($filters['tanggal'])) {
            [$awal, $akhir] = explode(' - ', $filters['tanggal']);
            $query->whereBetween('tanggal', [$awal, $akhir]);
        }

        if (! empty($filters['status'])) {
            $query->where('status_kehadiran', $filters['status']);
        }

        if (! empty($filters['pamong'])) {
            $query->where('pamong_id', $filters['pamong']);
        }

        return $query;
    }
}
