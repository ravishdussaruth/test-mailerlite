<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use \App\Models\Bank\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'details' => $faker->text,
        'amount'  => $faker->numberBetween(1000, 2000)
    ];
});
