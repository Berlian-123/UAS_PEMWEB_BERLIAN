<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    protected $fillable = ['user_id', 'judul', 'isi', 'tanggal'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kegiatan()
{
    return $this->belongsTo('App\Kegiatan');
}
}
