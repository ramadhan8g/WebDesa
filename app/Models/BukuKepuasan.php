<?php



namespace App\Models;

use App\Enums\JawabanKepuasanEnum;

class BukuKepuasan extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buku_kepuasan';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The appends with the model.
     *
     * @var array
     */
    protected $appends = [
        'jawaban',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];

    /**
     * Getter untuk jawaban
     *
     * @return string
     */
    public function getJawabanAttribute()
    {
        return JawabanKepuasanEnum::all()[$this->id_jawaban];
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function tamu()
    {
        return $this->hasOne(BukuTamu::class, 'id', 'id_nama');
    }
}
