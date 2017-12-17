<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'content' => $faker->sentence,
        'user_id' => Factory(App\User::class)->create()->id
    ];
});
