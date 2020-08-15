<?php

namespace App\Observers;

use App\Transaction;

class TransactionObserver
{
    /**
     * Ejcuta cuando se cree un Transaction
     *
     * @param Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction){
        $account = $transaction->account;
        if($transaction->type === 'INCOME'){
            $account->balance = $transaction->balance + $transaction->amount;
            return $account->save();
        }else{
            $account->balance = $transaction->balance - $transaction->amount;
            return $account->save();
        }
    }
}
