<?php

namespace App\Contracts\Bank;

use App\Models\Bank\Account;

interface Transaction
{
    /**
     * Will tell us if this transaction will be able to perform.
     *
     * @param Account $from
     * @param float   $amount
     *
     * @return bool
     */
    public function canPerformTransaction(Account $from, float $amount): bool;

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
    public function startTransaction(Account $from, Account $to, float $amount, string $details);
}
