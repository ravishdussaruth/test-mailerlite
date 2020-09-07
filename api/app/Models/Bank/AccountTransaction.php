<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Relations\Pivot;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountTransaction extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account_transaction';

    /**
     * The account it belongs to.
     *
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * The account transaction.
     *
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
