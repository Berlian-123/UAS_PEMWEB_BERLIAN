<?php

use Faker\Generator as Faker;

$factory->define(App\UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'alamat' => $faker->address,
        'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
    ];
});
