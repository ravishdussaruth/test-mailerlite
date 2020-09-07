<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Bank\Account::class)->states(['with_transaction', 'with_client'])->create([
            'name'      => 'John',
            'balance'   => 15000
        ]);

        factory(\App\Models\Bank\Account::class)->states('with_client')->create([
            'name'    => 'Peter',
            'balance' => 100000
        ]);
    }
}
