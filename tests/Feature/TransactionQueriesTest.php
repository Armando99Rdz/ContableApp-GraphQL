<?php

namespace Tests\Feature;

use App\Account;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TransactionQueriesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Probar obtener las transacciones
     *
     */
    function test_it_queries_transactions(){

        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
           'user_id' => $user->id
        ]);
        $transactions = factory(Transaction::class, 20)->create([
            'account_id' => $account->id
        ]);
        Passport::actingAs($user);

        // execute
        $response = $this->graphQL('
            query {
                transactions(first:20) {
                    data {
                        id
                        amount
                        account {
                            id
                        }
                        type
                    }
                    paginatorInfo{
                        currentPage
                    }
                }
            }
        ');

        // assertions
        $response->assertJson([
           'data' => [
               'transactions' => [
                   'data' => [],
                   'paginatorInfo' => []
               ]
           ]
        ]);
    }



    /**
     *
     */
    function test_it_queries_logged_in_user_transactions(){

        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        $transactions = factory(Transaction::class, 10)->create([
            'account_id' => $account->id
        ]);
        Passport::actingAs($user);

        // execute
        $response = $this->graphQL('
            query {
                transactions(first:10) {
                    data {
                        id
                        amount
                        account {
                            id
                        }
                        type
                    }
                    paginatorInfo{
                        currentPage
                        total
                    }
                }
            }
        ');

        // assertions
        $response->assertJson([
            'data' => [
                'transactions' => [
                    'data' => [],
                    'paginatorInfo' => [
                        'total' => 10
                    ]
                ]
            ]
        ]);
    }


    /**
     * FIXME: FALLA TEST DE MANERA RANDOM, Si ejecuto esta prueba únicamente (e.g. php artisan test --filter test_it_queries_a_transaction)
     * normalmente pasa correctamente, pero, al ejecutar todos los test (e.g. php artisan test), falla inesperadamente.
     * Inicialmente creí que era un problema con el cast de id (castear los id de los modelos Transaction y Account)
     * pero no estoy seguro.
     */
    function test_it_queries_a_transaction(){

        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        $transactions = factory(Transaction::class, 10)->create([
            'account_id' => $account->id
        ]);
        $transaction = $transactions->shuffle()->first(); # obtener una transaccion random

        // execute
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                transaction(id:'.$transaction->id.') {
                    id
                    amount
                    account {
                        id
                    }
                    type
                }
            }
        ');

        // assert
        $response->assertJson([
            'data' => [
                'transaction' => [
                    'id' => $transaction->id,
                    'amount' => round($transaction->amount, 2), # Solución error al recibir amount a dos decimales.
                    'account' => [
                        'id' => $account->id
                    ],
                    'type' => $transaction->type
                ]
            ]
        ]);
    }


    /**
     * Verificar que NO pueda obtener una transaccion
     * de una cuenta de la cual no sea el dueño.
     */
    function test_it_cant_query_a_transaction_where_not_owner(){

        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        factory(Transaction::class, 2)->create([
            'account_id' => $account->id
        ]);
        $transactions = factory(Transaction::class, 3)->create();
        $transaction = $transactions->shuffle()->first(); # obtener una transaccion random

        // execute
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                transaction(id:'.$transaction->id.') {
                    id
                    amount
                    account {
                        id
                    }
                    type
                }
            }
        ');

        // assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access transaction',
                ]
            ]
        ]);
    }
}
