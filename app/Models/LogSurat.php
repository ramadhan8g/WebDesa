<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

defined('BASEPATH') || exit('No direct script access allowed');

class LogSurat extends BaseModel
{
    public const KONSEP  = 0;
    public const CETAK   = 1;
    public const TOLAK   = -1;
    public const PERIKSA = 0;
    public const TERIMA  = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_surat';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['formatSurat', 'penduduk', 'pamong', 'tolak'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    public function formatSurat()
    {
        return $this->belongsTo(FormatSurat::class, 'id_format_surat');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_pend');
    }

    public function pamong()
    {
        return $this->belongsTo(Pamong::class, 'id_pamong');
    }

    public function tolak()
    {
        return $this->hasMany(LogTolak::class, 'id_surat');
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
        // return $query->where('id_pend', auth('jwt')->user()->penduduk->id);
    }

    /**
     * Scope query untuk Status LogSurat
     *
     * @param mixed $query
     * @param mixed $value
     *
     * @return Builder
     */
    public function scopeStatus($query, $value = 1)
    {
        return $query->where('status', $value);
    }

    public function getFormatPenomoranSuratAttribute()
    {
        $thn                = $this->tahun ?? date('Y');
        $bln                = $this->bulan ?? date('m');
        $format_nomor_surat = ($this->formatSurat->format_nomor == '') ? setting('format_nomor_surat') : $this->formatSurat->format_nomor;
        $config             = Config::first();

        $format_nomor_surat = str_replace('[nomor_surat]', "{$this->no_surat}", $format_nomor_surat);
        $array_replace      = [
            '[kode_surat]'   => $this->formatSurat->kode_surat,
            '[tahun]'        => $thn,
            '[bulan_romawi]' => bulan_romawi((int) $bln),
            '[kode_desa]'    => $config->kode_desa,
        ];

        return str_replace(array_keys($array_replace), array_values($array_replace), $format_nomor_surat);
    }

    public function getFileSuratAttribute()
    {
        if ($this->lampiran != null) {
            return FCPATH . LOKASI_ARSIP . pathinfo($this->nama_surat, PATHINFO_FILENAME);
        }
    }
}
