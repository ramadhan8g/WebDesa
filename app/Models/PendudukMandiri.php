<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class PendudukMandiri extends BaseModel
{
    /**
     * {@inheritDoc}
     */
    public const CREATED_AT = 'tanggal_buat';

    /**
     * {@inheritDoc}
     */
    public const UPDATED_AT = 'updated_at';

    /**
     * {@inheritDoc}
     */
    protected $primaryKey = 'id_pend';

    /**
     * {@inheritDoc}
     */
    protected $table = 'tweb_penduduk_mandiri';

    /**
     * {@inheritDoc}
     */
    public $incrementing = false;

    /**
     * {@inheritDoc}
     */
    protected $hidden = [
        'pin',
        'remember_token',
    ];

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * {@inheritDoc}
     */
    protected $with = [
        'penduduk',
    ];

    /**
     * Scope query untuk aktif
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    public function scopeStatus($query, $value = 1)
    {
        return $query->where('aktif', $value);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return BelongsTo
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_pend');
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return BelongsTo
     */
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_pend');
    }

    /**
     * Get email penduduk attribute.
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->penduduk->email;
    }
}
