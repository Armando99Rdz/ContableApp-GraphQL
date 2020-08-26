<?php

namespace Tests\Feature;

use App\Account;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AccountQueriesTest extends TestCase
{
    use RefreshDatabase;

    function test_it_queries_accounts(){
        $user = factory(User::class)->create();
        factory(Account::class, 3)->create([
           'user_id' => $user->id
        ]); # crea 3 cuentas para el usuario
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                accounts(first: 20){
                    data {
                        id
                        name
                    }
                    paginatorInfo {
                        total
                    }
                }
            }

        ');

        $response->assertJson([
           'data' => [
               'accounts' => [
                   'data' => [],
                   'paginatorInfo' => [
                       'total' => 3
                   ]
               ]
           ]
        ]);

    }

    /**
     * Validar obtener una cuenta en específico.
     */
    function test_it_queries_an_account(){
        $user = factory(User::class)->create();
        $accounts = factory(Account::class, 3)->create([
            'user_id' => $user->id
        ]); # crea 3 cuentas para el usuario
        Passport::actingAs($user);
        $account = $accounts->shuffle()->first(); # obtener una cuenta random

        # execute
        $response = $this->graphQL('
            query {
                account(id: '.$account->id.'){
                    id
                    name
                }
            }

        ');

        # assert
        $response->assertJson([
            'data' => [
                'account' => [
                    'id' => $account->id,
                    'name' => $account->name
                ]
            ]
        ]);

    }


    /**
     * Validar que no se pueda obtener una cuenta de la cual no
     * se sea el dueño.
     */
    function test_it_cant_query_an_account_not_owner(){
        $user = factory(User::class)->create();
        factory(Account::class, 3)->create([
            'user_id' => $user->id
        ]); # crea 3 cuentas para el usuario
        $account = factory(Account::class)->create();
        Passport::actingAs($user);

        # execute
        $response = $this->graphQL('
            query {
                account(id: '.$account->id.'){
                    id
                    name
                }
            }

        ');

        # assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access account'
                ]
            ]
        ]);

    }
}
