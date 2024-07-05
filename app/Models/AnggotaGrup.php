<?php



namespace App\Models;

use Illuminate\Support\Facades\DB;

defined('BASEPATH') || exit('No direct script access allowed');

class AnggotaGrup extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anggota_grup_kontak';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_grup_kontak';

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'id_grup',
        'id_kontak',
        'id_penduduk',
    ];

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function grupKontak()
    {
        return $this->hasOne(GrupKontak::class, 'id_grup', 'id_grup');
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function daftarKontak()
    {
        return $this->hasOne(DaftarKontak::class, 'id_kontak', 'id_kontak');
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function penduduk()
    {
        return $this->hasOne(Penduduk::class, 'id', 'id_penduduk')->status();
    }

    public function scopeDataAnggota($query)
    {
        return $query
            ->leftJoin('kontak as k', 'anggota_grup_kontak.id_kontak', '=', 'k.id_kontak')
            ->leftJoin('tweb_penduduk as p', static function ($penduduk) {
                $penduduk->on('anggota_grup_kontak.id_penduduk', '=', 'p.id')
                    ->where('p.status_dasar', '=', 1);
            })
            ->select(
                'anggota_grup_kontak.*',
                DB::raw('(CASE WHEN anggota_grup_kontak.id_kontak IS NULL THEN p.nama ELSE k.nama END) AS nama'),
                DB::raw('(CASE WHEN anggota_grup_kontak.id_kontak IS NULL THEN p.telepon ELSE k.telepon END) AS telepon'),
                DB::raw('(CASE WHEN anggota_grup_kontak.id_kontak IS NULL THEN p.email ELSE k.email END) AS email'),
                DB::raw('(CASE WHEN anggota_grup_kontak.id_kontak IS NULL THEN p.telegram ELSE k.telegram END) AS telegram'),
                DB::raw('(CASE WHEN anggota_grup_kontak.id_kontak IS NULL THEN p.hubung_warga ELSE k.hubung_warga END) AS hubung_warga'),
            );
    }
}
