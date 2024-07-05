<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

// class User extends Authenticatable implements JWTSubject
class User extends BaseModel
{
    // use HasApiTokens;
    // use HasFactory;
    // use Notifiable;

    protected $table = 'user';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'foto',
        'last_login',
        'id_telegram',
        'notif_telegram',
        'telegram_verified_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'    => 'datetime',
        'telegram_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        // return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function pamong()
    {
        return $this->hasOne(Pamong::class, 'pamong_id', 'pamong_id');
    }

    /**
     * Scope query untuk status pengguna
     *
     * @param mixed $query
     * @param mixed $status
     *
     * @return Builder
     */
    public function scopeStatus($query, $status = 1)
    {
        return $query->where('active', $status);
    }
}
