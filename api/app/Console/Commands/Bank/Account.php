<?php

namespace App\Console\Commands\Bank;

use App\Repositories\Bank\Accounts;
use Illuminate\Console\Command;

class Account extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new bank account with api key.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            do {
                $accountData = $this->getBankAccountDetails();
            } while (!$this->confirm('Are you sure about the account details?'));

            $account = factory(\App\Models\Bank\Account::class)->create(array_merge($accountData, [
                'client_id' => factory(\Laravel\Passport\Client::class)->create([
                    'name' => $accountData['name'] . ' ' . 'Grant'
                ])->id
            ]));

            $this->info("Account created: $account->name");
            $this->info("Account Client Id: {$account->client->id}");
            $this->info("Account Secret: {$account->client->secret}");
        } catch (\Exception  $e) {
            $this->error('Could not create account.' . $e);
        }
    }

    /**
     * Get details to create bank account.
     *
     * @return array
     */
    protected function getBankAccountDetails(): array
    {
        return [
            'name'          => $this->ask('Bank Account Name: '),
            'balance'       => $this->ask('Bank Account Balance: '),
            'limit_per_day' => $this->ask('Set Limit per day: ', 2000),
            'currency'      => $this->ask('Balance Currency: ', 'usd')
        ];
    }
}
