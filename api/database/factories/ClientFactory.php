<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Laravel\Passport\Client::class, function (Faker $faker) {
    return [
        'name'                   => 'client_grant',
        'secret'                 => Str::random(40),
        'redirect'               => $faker->url,
        'personal_access_client' => false,
        'password_client'        => false,
        'revoked'                => false
    ];
});
