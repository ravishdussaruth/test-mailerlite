<?php

namespace App\Http\Controllers\Bank;

use App\Models\Bank\Account;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bank\Account as AccountResource;

class AccountController extends Controller
{
    /**
     * Display the account details.
     *
     * @param Account $account
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return AccountResource::make($account);
    }
}
