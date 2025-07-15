<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatans';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'tanggal',
        'status',
    ];

    // Relasi: Kegiatan dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function catatans()
{
    return $this->hasMany('App\Catatan');
}
}