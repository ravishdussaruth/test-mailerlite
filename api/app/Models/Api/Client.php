<?php

namespace App\Models\Api;

use App\Models\Bank\Account;
use Laravel\Passport\Client as Model;

class Client extends Model
{
    /**
     * The account for this client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'client_id', 'id');
    }
}
