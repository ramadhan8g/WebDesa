<?php



namespace App\Models;

use App\Traits\Author;

defined('BASEPATH') || exit('No direct script access allowed');

class AnjunganMenu extends BaseModel
{
    use Author;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anjungan_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'icon',
        'link',
        'link_tipe',
        'urut',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        // 'createdBy',
        // 'updatedBy',
    ];

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
