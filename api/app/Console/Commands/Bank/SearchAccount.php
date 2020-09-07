<?php

namespace App\Console\Commands\Bank;

use Illuminate\Console\Command;
use App\Repositories\Bank\Accounts;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a bank account details.';

    /**
     * The account repository.
     *
     * @var Accounts
     */
    protected $accounts;

    /**
     * Create a new command instance.
     *
     * @param Accounts $accounts
     *
     * @return void
     */
    public function __construct(Accounts $accounts)
    {
        parent::__construct();

        $this->accounts = $accounts;
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
                $accountData = $this->getBankId();
            } while (!$this->confirm('Are you sure about the account details?'));

            $account = $this->accounts->where($accountData)->first();

            $this->info("Account Name: $account->name");
            $this->info("Account Client Id: {$account->client->id}");
            $this->info("Account Secret: {$account->client->secret}");
        } catch (ModelNotFoundException $e) {
            $this->error('Bank Account could not be found .' . $e);
        }
    }

    /**
     * Retrieve bank id from user.
     *
     * @return array
     */
    protected function getBankId()
    {
        return [
            'id'          => $this->ask('Bank Account Id: ')
        ];
    }
}
