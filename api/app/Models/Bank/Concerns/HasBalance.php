<?php

namespace App\Models\Bank\Concerns;

use Illuminate\Support\Carbon;
use App\Models\Bank\Transaction;

trait HasBalance
{
    /**
     * Increase Amount.
     *
     * @param float $amount
     *
     * @return void
     */
    public function increase(float $amount): void
    {
        $this->increment('balance', $amount);
    }

    /**
     * Decrease the amount.
     *
     * @param float $amount
     *
     * @return void
     */
    public function decrease(float $amount): void
    {
        $this->decrement('balance', $amount);
    }

    /**
     * Will tell us if account has enough money.
     *
     * @param float $amount
     *
     * @return bool
     */
    public function hasEnoughMoney(float $amount): bool
    {
        return $amount < $this->balance;
    }

    /**
     * Money spend on data.
     *
     * @param Carbon $date
     *
     * @return int
     */
    public function spendOnDay(Carbon $date = null): int
    {
        $date ??= Carbon::today();

        if (!$this->transactions()->exists()) {
            return 0;
        }

        return $this->transactions()
                    ->wherePivot('from_or_to', \App\Enums\Account::FROM)
                    ->wherePivot('created_at', '>=', $date)
                    ->get()
                    ->reduce(function ($carry, Transaction $transaction) {
                        return $carry + $transaction->amount;
                    });
    }
}
