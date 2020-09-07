<?php

namespace App\Services\Bank;

use App\Models\Bank\Account;
use App\Models\Bank\Transaction;
use App\Repositories\Bank\Accounts;
use App\Repositories\Bank\Transactions;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Bank\Transaction as BaseTransaction;

class Transfer implements BaseTransaction
{
    /**
     * Will tell us if this transaction will be able to perform.
     *
     * @param Account $from
     * @param float   $amount
     *
     * @return bool
     */
    public function canPerformTransaction(Account $from, float $amount): bool
    {
        return ($from->spendOnDay() < $from->limit_per_day) && $from->hasEnoughMoney($amount);
    }

    /**
     * Will perform new transaction.
     *
     * @param Account $from
     * @param Account $to
     * @param float   $amount
     * @param string  $details
     *
     * @return mixed
     */
    public function startTransaction(Account $from, Account $to, float $amount, string $details)
    {
        $transaction = resolve(Transactions::class)->create([
            'details' => $details,
            'amount'  => $amount
        ]);

        $from->decrease($amount);
        $to->increase($amount);

        $from->transactions()->attach($transaction->id, ['from_or_to' => \App\Enums\Account::FROM]);
        $to->transactions()->attach($transaction->id, ['from_or_to' => \App\Enums\Account::TO]);
    }
}
