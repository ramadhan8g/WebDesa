<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class KB extends BaseModel
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'tweb_cara_kb';

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
}
