<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'balance' => $faker->randomFloat(),
        'color' => $faker->word,
        'description' => $faker->text,
        'user_id' => factory(App\User::class),
    ];
});
