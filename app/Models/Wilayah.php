<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Wilayah extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tweb_wil_clusterdesa';

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
     * Scope query untuk dusun
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeDusun($query)
    {
        return $query->where('rt', '=', '0')->where('rw', '=', '0');
    }

    /**
     * Scope query untuk rw.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRw($query)
    {
        return $query->where('rt', '=', '0')->where('rw', '!=', '0');
    }

    /**
     * Scope query untuk rt
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRt($query)
    {
        return $query->where('rt', '!=', '0');
    }
}
