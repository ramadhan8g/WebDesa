<?php



namespace App\Models;

defined('BASEPATH') || exit('No direct script access allowed');

class Pesan extends BaseModel
{
    protected $table    = 'pesan';
    protected $fillable = ['id', 'judul', 'jenis', 'sudah_dibaca', 'diarsipkan'];

    public function detailPesan()
    {
        return $this->hasMany(PesanDetail::class, 'pesan_id', 'id');
    }

    public function getCustomDateAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }
}
