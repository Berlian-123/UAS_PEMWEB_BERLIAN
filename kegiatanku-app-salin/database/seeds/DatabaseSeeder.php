<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(App\User::class, 5)->create()->each(function ($user) {
            // Buat 1 profil untuk user
            factory(App\UserProfile::class)->create([
                'user_id' => $user->id,
            ]);

            // Buat 2-3 kegiatan per user
            $user->kegiatans()->saveMany(
                factory(App\Kegiatan::class, 3)->make()
            )->each(function ($kegiatan) use ($user) {
                // Untuk setiap kegiatan, buat 2 catatan
                $kegiatan->catatans()->saveMany(
                    factory(App\Catatan::class, 2)->make([
                        'user_id' => $user->id
                    ])
                );
            });
        });
    }
}
