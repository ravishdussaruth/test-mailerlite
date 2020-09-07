<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['details', 'amount'];

    /**
     * All transactions related to this account.
     *
     * @return BelongsToMany
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'account_transaction', 'transaction_id', 'account_id')
                    ->using(AccountTransaction::class)
                    ->withPivot('from_or_to')
                    ->withTimestamps();
    }

    /**
     * Will tell us the author of this transaction.
     *
     * @return Account|null
     */
    public function from(): ?Account
    {
        return $this->hasOneThrough(Account::class, AccountTransaction::class, 'account_id', 'id')
                ->where('from_or_to', \App\Enums\Account::FROM)
                ->first();
    }

    /**
     * Will tell us the receiver of this transaction.
     *
     * @return Account|null
     */
    public function to(): ?Account
    {
        return $this->hasOneThrough(Account::class, AccountTransaction::class, 'account_id', 'id')
                    ->where('from_or_to', \App\Enums\Account::TO)
                    ->first();
    }
}
