<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    // Nama tabel (opsional, karena Laravel otomatis pakai 'user_profiles')
    protected $table = 'user_profiles';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'alamat',
        'tanggal_lahir',
    ];

    // Relasi: UserProfile milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
