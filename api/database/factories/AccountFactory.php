<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bank\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        'balance'       => $faker->numberBetween(15000, 100000),
        'limit_per_day' => $faker->numberBetween(1000, 5000)
    ];
});

$factory->afterCreatingState(Account::class, 'with_transaction', function (Account $account, Faker $faker) {
    $transactions = factory(\App\Models\Bank\Transaction::class)->createMany([
        [
            'amount' => 2000
        ],
        [
            'amount' => 4000
        ]
    ]);

    $account->transactions()->attach($transactions->pluck('id')->all(), [
        'from_or_to' => \App\Enums\Account::FROM,
        'created_at' => \Illuminate\Support\Carbon::today()
    ]);

    // Set one transaction for yesterday.
    $account->transactions()->attach(factory(\App\Models\Bank\Transaction::class)->create(['amount' => 2000])->id, [
        'from_or_to' => \App\Enums\Account::TO,
        'created_at' => \Illuminate\Support\Carbon::yesterday()
    ]);
});

$factory->state(Account::class, 'with_client', function (Faker $faker) {
    return [
        'client_id' => factory(\Laravel\Passport\Client::class)->create()->id
    ];
});
