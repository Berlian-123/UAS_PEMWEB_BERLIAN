<?php

use Faker\Generator as Faker;

$factory->define(App\Catatan::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'kegiatan_id' => function () {
            return factory(App\Kegiatan::class)->create()->id;
        },
        'judul' => $faker->sentence,
        'isi' => $faker->paragraph,
        'tanggal' => $faker->date,
    ];
});
