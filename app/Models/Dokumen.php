<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Dokumen extends BaseModel
{
    public const DOKUMEN_WARGA = 1;
    public const ENABLE        = 1;
    public const DISABLE       = 0;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dokumen';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'attr' => '[]',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'attr' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'satuan',
        'nama',
        'enabled',
        'tgl_upload',
        'id_pend',
        'kategori',
        'id_syarat',
        'dok_warga',
    ];

    /**
     * {@inheritDoc}
     */
    protected $with = [
        'kategoriDokumen',
    ];

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return BelongsTo
     */
    public function jenisDokumen()
    {
        return $this->belongsTo(SyaratSurat::class, 'id_syarat');
    }

    /**
     * Scope a query to only users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePengguna($query)
    {
        // return $query->where('id_pend', auth('jwt')->id());
    }

    /**
     * Getter untuk menambahkan url file.
     *
     * @return string
     */
    public function getUrlFileAttribute()
    {
        // try {
        //     return Storage::disk('ftp')->exists("desa/upload/dokumen/{$this->satuan}")
        //         ? Storage::disk('ftp')->url("desa/upload/dokumen/{$this->satuan}")
        //         : null;
        // } catch (Exception $e) {
        //     Log::error($e);
        // }
    }

    /**
     * Getter untuk donwload file.
     *
     * @return string
     */
    public function getDownloadDokumenAttribute()
    {
        // try {
        //     return Storage::disk('ftp')->exists("desa/upload/dokumen/{$this->satuan}")
        //         ? Storage::disk('ftp')->download("desa/upload/dokumen/{$this->satuan}")
        //         : null;
        // } catch (Exception $e) {
        //     Log::error($e);
        // }
    }

    /**
     * Scope query untuk status dokumen
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeHidup($query)
    {
        return $query->where('deleted', '!=', 1);
    }

    /**
     * Scope query untuk status aktif
     *
     * @param Builder $query
     * @param string  $status
     *
     * @return Builder
     */
    public function scopeAktif($query, $status = '1')
    {
        return $query->where('enabled', $status);
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function kategoriDokumen()
    {
        return $this->hasOne(RefDokumen::class, 'id', 'kategori');
    }

    /**
     * Scope query untuk menyaring data dokumen berdasarkan parameter yang ditentukan
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    public function scopeFilters($query, array $filters = [])
    {
        foreach ($filters as $key => $value) {
            $query->when($value ?? false, static function ($query) use ($value, $key) {
                $query->where($key, $value);
            });
        }

        return $query;
    }

    /**
     * Scope query untuk kategori dokumen
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    public function scopeKategori($query, $value = 1)
    {
        return $query->where('kategori', $value);
    }
}
