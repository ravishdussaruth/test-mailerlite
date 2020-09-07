<?php

namespace App\Http\Controllers\Bank;

use App\Models\Bank\Account;
use App\Contracts\Bank\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\CreateNewTransaction;
use App\Http\Resources\Bank\TransactionCollection;

class TransactionController extends Controller
{
    /**
     * Get all transactions for this account.
     *
     * @param Account $account
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account)
    {
        return TransactionCollection::make($account->load(['transactions', 'transactions.accounts'])->transactions);
    }

    /**
     * Create new transaction.
     *
     * @param Account              $account
     * @param CreateNewTransaction $request
     * @param Transaction          $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Account $account, CreateNewTransaction $request, Transaction $transaction)
    {
        if (!$transaction->canPerformTransaction($account, $request->amount)) {
            return response()->json([
                'title' => 'Transfer cannot be performed.',
                'error' => 'Daily limit has been exceeded.'
            ], 422);
        }

        $transaction->startTransaction($account, ...$request->data());
    }
}
