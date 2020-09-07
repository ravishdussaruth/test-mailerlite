<?php

namespace App\Repositories\Bank;

use App\Models\Bank\Account;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Repositories\EloquentRepository;

/**
 * @EloquentModel(target="App\Models\Bank\Account")
 */
class Accounts extends EloquentRepository
{
    /**
     * Will create and associate a client to an account.
     *
     * @param Account $account
     *
     * @return void
     */
    public function associateAClientToAccount(Account $account): void
    {
        $account->client()->create([
            'name'                   => "$account->name GrantClient",
            'secret'                 => Str::random(40),
            'redirect'               => null,
            'personal_access_client' => false,
            'password_client'        => false,
            'revoked'                => false
        ]);
    }
}
