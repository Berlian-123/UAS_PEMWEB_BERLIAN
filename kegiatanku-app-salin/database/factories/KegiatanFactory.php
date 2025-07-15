<?php

use Faker\Generator as Faker;

$factory->define(App\Kegiatan::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return App\User::inRandomOrder()->first()->id ?? factory(App\User::class)->create()->id;
        },
        'judul' => $faker->sentence(3),
        'deskripsi' => $faker->paragraph,
        'tanggal' => $faker->date(),
        'status' => $faker->randomElement(['belum', 'proses', 'selesai']),
    ];
});
