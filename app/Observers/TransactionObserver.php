<?php

namespace App\Observers;

use App\Account;
use App\CalculateAccountBalance;
use App\Transaction;

class TransactionObserver
{

    public $calculator;

    public function __construct(CalculateAccountBalance $calculateAccountBalance) {
        $this->calculator = $calculateAccountBalance;
    }

    /**
     * Ejcuta cuando se cree un Transaction
     *
     * @param Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction){
        return $this->calculator->calculateNewAccountBalance($transaction);
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
        $this->calculator->setOldTransaction(Transaction::find($transaction->id));
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
        $this->calculator->setAccountBalanceFromOldTransaction($transaction);
        return $this->calculator->calculateNewAccountBalance($transaction);
    }


    /**
     * Cuando se ha eliminado una transacción.
     *
     * @return void
     */
    public function deleted(Transaction $transaction){
        $this->calculator->setOldTransaction($transaction);
        $account = $this->calculator->setAccountBalanceFromOldTransaction($transaction);
        return $account->save();
    }


}
