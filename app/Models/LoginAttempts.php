<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class LoginAttempts extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login_attempts';

    /**
     * The table update parameter.
     *
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];
}
