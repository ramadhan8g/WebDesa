<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Paud extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sasaran_paud';

    /**
     * The table update parameter.
     *
     * @var string
     */
    public $primaryKey = 'id_sasaran_paud';

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

    public function kia()
    {
        return $this->belongsTo(KIA::class, 'kia_id');
    }

    public function scopeFilter($query, array $filters)
    {
        if (! empty($filters['tahun'])) {
            $query->whereYear('sasaran_paud.created_at', $filters['tahun']);
        }

        if (! empty($filters['posyandu'])) {
            $query->where('posyandu_id', $filters['posyandu']);
        }

        return $query;
    }
}
