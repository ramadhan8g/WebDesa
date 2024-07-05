<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

defined('BASEPATH') || exit('No direct script access allowed');

class PermohonanSurat extends BaseModel
{
    public const BELUM_LENGKAP         = 0;
    public const SEDANG_DIPERIKSA      = 1;
    public const MENUNGGU_TANDA_TANGAN = 2;
    public const SIAP_DIAMBIL          = 3;
    public const SUDAH_DIAMBIL         = 4;
    public const DIBATALKAN            = 5;
    public const STATUS_PERMOHONAN     = [
        self::BELUM_LENGKAP         => 'Belum Lengkap',
        self::SEDANG_DIPERIKSA      => 'Sedang Diperiksa',
        self::MENUNGGU_TANDA_TANGAN => 'Menunggu Tandatangan',
        self::SIAP_DIAMBIL          => 'Siap Diambil',
        self::SUDAH_DIAMBIL         => 'Sudah Diambil',
        self::DIBATALKAN            => 'Dibatalkan',
    ];

    /**
     * {@inheritDoc}
     */
    protected $table = 'permohonan_surat';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'id_pemohon',
        'id_surat',
        'isian_form',
        'alasan',
        'keterangan',
        'status',
        'no_hp_aktif',
        'syarat',
        'alasan',
    ];

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'isian_form' => 'json',
        'syarat'     => 'json',
    ];

    /**
     * {@inheritDoc}
     */
    protected $with = ['surat', 'penduduk'];

    /**
     * Getter untuk mapping status permohonan.
     *
     * @return string
     */
    public function getStatusPermohonanAttribute()
    {
        return static::STATUS_PERMOHONAN[$this->status];
    }

    /**
     * Getter untuk mapping syartsurat permohonan.
     *
     * @return string
     */
    public function getSyaratSuratAttribute()
    {
        if ($this->syarat == null) {
            return null;
        }

        $dokumen = Dokumen::where('id_pend', $this->id_pemohon)->whereIn('id', $this->syarat)->get();

        return $dokumen->map(static function ($syarat) {
            $syarat->nama_syarat = $syarat->jenisDokumen->ref_syarat_nama;

            return $syarat;
        });
    }

    /**
     * Setter untuk id surat permohonan.
     *
     * @return void
     */
    public function setIdSuratAttribute(string $slug)
    {
        $this->attributes['id_surat'] = FormatSurat::where('url_surat', $slug)->first()->id;
    }

    /**
     * Scope query untuk pengguna.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePengguna($query)
    {
        // return $query->where('id_pemohon', auth('jwt')->user()->penduduk->id);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_pemohon');
    }

    public function surat()
    {
        return $this->belongsTo(FormatSurat::class, 'id_surat');
    }
}
