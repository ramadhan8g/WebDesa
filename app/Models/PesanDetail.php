<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class PesanDetail extends BaseModel
{
    protected $table    = 'pesan_detail';
    protected $fillable = ['text', 'pesan_id', 'pesan_detail', 'nama_pengirim', 'id', 'pengirim'];

    public function headerPesan()
    {
        return $this->hasOne(Pesan::class, 'pesan_id', 'id');
    }

    public function getCustomDateAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }
}
