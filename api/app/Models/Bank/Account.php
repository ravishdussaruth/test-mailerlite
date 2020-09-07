<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bank\Concerns\HasBalance;
use App\Models\Bank\Concerns\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Account extends Model
{
    use HasBalance, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'balance', 'limit_per_day'];

    /**
     * All transactions related to this account.
     *
     * @return BelongsToMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'account_transaction', 'account_id', 'transaction_id')
                    ->using(AccountTransaction::class)
                    ->withPivot('from_or_to')
                    ->withTimestamps();
    }
}
