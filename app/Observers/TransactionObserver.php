<?php

namespace App\Observers;

use App\Account;
use App\CalculateAccountBalance;
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
        $calculator = app(CalculateAccountBalance::class);
        return $calculator->calculateNewAccountBalance($transaction);
    }


    /**
     * Cuando se esté acutalizando una transacción.
     * Guardar la transaccion en el request para acceder.
     *
     * El objeto Transaction que se recibe aquí es nuevo (contiene
     * los nuevos datos), NO es el objeto actualizado.
     *
     * @return void
     */
    public function updating(Transaction $transaction){
        $calculator = app(CalculateAccountBalance::class);
        $calculator->setOldTransaction(Transaction::find($transaction->id));
    }

    /**
     * Una vez se actualice la transaccion
     *
     * El objeto Transaction que se recibe aquí es el objeto Actualizado.
     * Aquí ya no se conocen los valores anteriores de la Transacción
     * por ello en updating() se guarda la Transacción Anterior; para restar o
     * sumar según el caso al balance de la Cuenta.
     *
     * @return void
     */
    public function updated(Transaction $transaction){
        $calculator = app(CalculateAccountBalance::class);
        $calculator->setAccountBalanceFromOldTransaction($transaction);
        return $calculator->calculateNewAccountBalance($transaction);
    }


    /**
     * Cuando se ha eliminado una transacción.
     *
     * @return void
     */
    public function deleted(Transaction $transaction){
        $account = $transaction->account;
        if($transaction->type === 'INCOME'){ # si era una entrada
            $account->balance = $account->balance - $transaction->amount;
            return $account->save();
        } # si era un gasto:
        $account->balance = $account->balance + $transaction->amount;
        return $account->save();
    }


}
