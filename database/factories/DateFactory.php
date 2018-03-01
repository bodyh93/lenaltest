<?php

use Faker\Generator as Faker;

$factory->define(App\Date::class, function (Faker $faker) {
    return [
        'day' => $faker->numberBetween(1,28),
        'month' => $faker->numberBetween(1,12),
        'year' => $faker->numberBetween(1,2999)
    ];
});
