<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class PembangunanDokumentasi extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pembangunan_ref_dokumentasi';

    public function pembangunan()
    {
        return $this->belongsTo(Pembangunan::class, 'id_pembangunan', 'id');
    }
}
