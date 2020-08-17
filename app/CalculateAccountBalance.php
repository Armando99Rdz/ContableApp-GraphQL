<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalculateAccountBalance {

    public $old_transaction;

    public function setOldTransaction(Transaction $transaction){
        $this->old_transaction = $transaction;
    }

    /**
     * Calcular el nuevo balance de la cuenta.
     *
     * @param [type] $transaction
     * @return void
     */
    public function calculateNewAccountBalance($transaction){
        $account = $transaction->account;
        if($transaction->type === 'INCOME'){ # si era una entrada
            $account->balance = $account->balance + $transaction->amount;
            return $account->save();
        } # si era un gasto:
        $account->balance = $account->balance - $transaction->amount;
        return $account->save();

    }


    /**
     * Restablecer el balance de la cuenta a como estaba antes
     * de la transaccion, es decir;
     *  - Si entró dinero a la cuenta, restalo.
     *  - Si salió dinero de la cuenta, súmalo.
     *
     * @param [type] $account
     * @return void
     */
    public function setAccountBalanceFromOldTransaction(Transaction $transaction) : Account {
        $account = $transaction->account;
        if($this->old_transaction->type === 'INCOME'){ # si era una entrada
            $account->balance = $account->balance - $this->old_transaction->amount; # resta la entrada anterior
            return $account;
        }
        # si era un gasto
        $account->balance = $account->balance + $this->old_transaction->amount; # suma el gasto anterior
        return $account;
    }

}
