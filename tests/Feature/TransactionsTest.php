<?php

namespace Tests\Feature;

use App\User;
use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Validar cuando se crea una transacción en una cuenta,
     * actualice el balance de la cuenta a la que pertenece
     * cuando se registra una entrada de ingreso (type == 'INCOME').
     *
     * @return void
     */
    function test_it_creates_transaction_and_updates_balance(){
        
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 0,
        ]); # crea un Account en 0 para el usuario de prueba
        Passport::actingAs($user);

        // execute
        $response = $this->graphQL('
            mutation {
                createTransaction(input: {
                    account_id: '.$account->id.',
                    type: INCOME,
                    amount: 100,
                    description: "Me dio mi papa para poner Gas"
                }) {
                    type
                    amount
                    description
                    account {
                        id
                        name
                        balance
                    }
                }
            }
        ');

        // assert
        $response->assertJson([
            'data' => [
                'createTransaction' => [
                    'type' => 'INCOME',
                    'amount' => 100.00,
                    'description' => 'Me dio mi papa para poner Gas',
                    'account' => [
                        'id' => $account->id,
                        'name' => $account->name,
                        'balance' => 100.00
                    ]
                ]
            ]
        ]);
    }



    /**
     * Validar cuando se crea una transacción en una cuenta,
     * actualice el balance de la cuenta a la que pertenece
     * cuando se registra un gasto de ingreso (type == 'EXPENSE').
     *
     * @return void
     */
    function test_it_creates_transaction_and_updates_balance_with_expense(){
        
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 100,
        ]); # crea un Account en 0 para el usuario de prueba
        Passport::actingAs($user);

        // execute
        $response = $this->graphQL('
            mutation {
                createTransaction(input: {
                    account_id: '.$account->id.',
                    type: EXPENSE,
                    amount: 50,
                    description: "Compre boneless"
                }) {
                    type
                    amount
                    description
                    account {
                        id
                        name
                        balance
                    }
                }
            }
        ');

        // assert
        $response->assertJson([
            'data' => [
                'createTransaction' => [
                    'type' => 'EXPENSE',
                    'amount' => 50.00,
                    'description' => 'Compre boneless',
                    'account' => [
                        'id' => $account->id,
                        'name' => $account->name,
                        'balance' => 50.00
                    ]
                ]
            ]
        ]);
    }

}
