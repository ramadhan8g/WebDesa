<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Pembangunan extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pembangunan';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'id_lokasi',
        'sumber_dana',
        'judul',
        'slug',
        'keterangan',
        'lokasi',
        'lat',
        'lng',
        'volume',
        'tahun_anggaran',
        'pelaksana_kegiatan',
        'status',
        'created_at',
        'updated_at',
        'foto',
        'anggaran',
        'perubahan_anggaran',
        'sumber_biaya_pemerintah',
        'sumber_biaya_provinsi',
        'sumber_biaya_kab_kota',
        'sumber_biaya_swadaya',
        'sumber_biaya_jumlah',
        'manfaat',
    ];

    public function pembangunanDokumentasi()
    {
        return $this->hasMany(PembangunanDokumentasi::class, 'id_pembangunan');
    }

    public function wilayah()
    {
        return $this->hasOne(Wilayah::class, 'id', 'id_lokasi');
    }

    /**
     * Get the lokasi.
     *
     * @return string
     */
    public function getlokasiPembAttribute()
    {
        if ($this->lokasi == null) {
            return 'Dusun ' . $this->wilayah->dusun . (($this->wilayah->rw != 0) ? " - Rw {$this->wilayah->rw}" : '') . (($this->wilayah->rt != 0) ? "/RT {$this->wilayah->rw}" : '');
        }

        return $this->lokasi;
    }
}
