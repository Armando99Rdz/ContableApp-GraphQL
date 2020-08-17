<?php

namespace Tests\Feature;

use App\User;
use App\Account;
use App\Transaction;
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


    /**
     * Verificar update cuando se modifique el type de la transaccion
     * de INCOME a EXPENSE.
     *
     * @return void
     */
    function test_it_can_update_a_transaction(){

        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 100,
        ]); 
        $transaction = factory(Transaction::class)->state('income')->create([
            'account_id' => $account->id,
            'amount' => 50 # entran 50 a la cuenta 
        ]);
        # verificar que la cuanta ahora tenga 150 en balance.
        $this->assertEquals(150, $account->fresh()->balance);
        Passport::actingAs($user);

        // Execute
        $response = $this->graphQL('
            mutation {
                updateTransaction(id: '.$transaction->id.', input: {
                    amount: 20
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

        $response->assertJson([
            'data' => [
                'updateTransaction' => [
                    'type' => 'INCOME',
                    'amount' => 20.00,
                    'description' => $transaction->description,
                    'account' => [
                        'balance' => 120.00
                    ]
                ]
            ]
        ]);

    }


    /**
     * Verificar update cuando se modifique el type de la transaccion
     * de EXPENSE a INCOME.
     *
     * @return void
     */
    function test_it_can_update_a_transaction_case_2(){

        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 100,
        ]); 
        $transaction = factory(Transaction::class)->state('expense')->create([
            'account_id' => $account->id,
            'amount' => 50 # entran 50 a la cuenta 
        ]);
        # verificar que la cuanta ahora tenga 150 en balance.
        $this->assertEquals(50, $account->fresh()->balance);
        Passport::actingAs($user);

        // Execute
        $response = $this->graphQL('
            mutation {
                updateTransaction(id: '.$transaction->id.', input: {
                    amount: 20
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

        $response->assertJson([
            'data' => [
                'updateTransaction' => [
                    'type' => 'EXPENSE',
                    'amount' => 20.00,
                    'description' => $transaction->description,
                    'account' => [
                        'balance' => 80.00
                    ]
                ]
            ]
        ]);

    }


    /**
     * Verificar update de Transaction cuando NO sea dueño de la cuenta.
     *
     * @return void
     */
    function test_it_can_update_a_transaction_when_not_owner(){

        $user = factory(User::class)->create();
        $user2 =  factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 100,
        ]); 
        $transaction = factory(Transaction::class)->state('expense')->create([
            'account_id' => $account->id,
            'amount' => 50 # entran 50 a la cuenta 
        ]);
        # verificar que la cuanta ahora tenga 150 en balance.
        $this->assertEquals(50, $account->fresh()->balance);
        Passport::actingAs($user2);

        // Execute
        $response = $this->graphQL('
            mutation {
                updateTransaction(id: '.$transaction->id.', input: {
                    amount: 20
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

        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access updateTransaction'
                ]
            ]
        ]);

    }


    /**
     * Verificar delete a un transacción.
     *
     * @return void
     */
    function test_it_can_delete_a_transaction(){

        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 100,
        ]); 
        $transaction = factory(Transaction::class)->state('expense')->create([
            'account_id' => $account->id,
            'amount' => 50 # entran 50 a la cuenta 
        ]);
        $this->assertEquals(50, $account->fresh()->balance);
        Passport::actingAs($user);

        // Execute
        $response = $this->graphQL('
            mutation {
                deleteTransaction(id: '.$transaction->id.') {
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

        $response->assertJson([
            'data' => [
                'deleteTransaction' => [
                    'account' => [
                        'balance' => 100.00
                    ]
                ]
            ]
        ]);

    }


    /**
     * Verificar delete a un transacción de tipo income.
     *
     * @return void
     */
    function test_it_can_delete_a_transaction_case_2(){

        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 100,
        ]); 
        $transaction = factory(Transaction::class)->state('income')->create([
            'account_id' => $account->id,
            'amount' => 50 # entran 50 a la cuenta 
        ]);
        $this->assertEquals(150, $account->fresh()->balance);
        Passport::actingAs($user);

        // Execute
        $response = $this->graphQL('
            mutation {
                deleteTransaction(id: '.$transaction->id.') {
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

        $response->assertJson([
            'data' => [
                'deleteTransaction' => [
                    'account' => [
                        'balance' => 100.00
                    ]
                ]
            ]
        ]);

    }

}
