<?php

namespace Tests\Feature;

use App\User;
use App\Account;
use GraphQL\GraphQL;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
    # para refrescar la BD cada vez que corra mi prueba.
    use RefreshDatabase; 


    # Probar que mi API puede crear una cuenta.
    # Dividir el test en 3 puntos: Preparation, Execution y Assertions/Verfications.
    function test_it_creates_an_account(){

        // Preparación
        $user =  factory(User::class)->create();
        Passport::actingAs($user); # actingAs para establecer este usuario como autenticado.

        // Ejecución
        $response = $this->graphQL('mutation{
            createAccount(input: {
                name: "Diversión",
                balance: 500,
                description: "Mis fondos libres"
              }) {
                name
                balance
                description
                color
                user {
                  id
                  name
                }
              }
        }'); # graphQL() recibe el query que se quiere ejecutar, 
        # en este caso un mutation para crear un Account.

        // Assertions - Verificación
        $response->assertJson([
            'data' => [ # graphql devuelve un objeto llamado "data" si no hay ningún problema.
                'createAccount' => [
                    'name' => 'Diversión',
                    'balance' => 500.00,
                    'description' => 'Mis fondos libres',
                    'color' => '#457b9d',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name
                    ]
                ]
            ]
        ]); # verificar que el JSON respuesta sea el esperado, se define su estructura.

        # validar que exista este registro en la BD.
        $this->assertDatabaseHas('accounts', [
            'name' => 'Diversión',
            'balance' => '500.00',
            'description' => 'Mis fondos libres',
            'color' => '#457b9d',
            'user_id' => $user->id
        ]); 
    }


    # Validar input (distintos campos que recibe) para crear 
    # un Account si se mandan datos erróneos como un string 
    # en lugar de un valor numérico.
    function test_it_validates_input(){

        // Preparación
        $user =  factory(User::class)->create();
        Passport::actingAs($user); # actingAs para establecer este usuario como autenticado.

        // Ejecución
        $response = $this->graphQL('mutation{
            createAccount(input: {
                name: "Cuenta Error",
                balance: "string de prueba",
                description: "Mis fondos libres"
              }) {
                name
                balance
                description
                color
                user {
                  id
                  name
                }
              }
        }'); # se manda un string en el campo "balance" 

        // Assertions - Verificación
        $response->assertJson([
            'errors' => [ # graphql devuelve un objeto llamado "errors" si hay un problema.
                [ # graphql devería devolver este mensaje porque se está mandando un string en lugar de un float. 
                    "message" => "Field \"createAccount\" argument \"input\" requires type Float, found \"string de prueba\"."
                ]
            ]
        ]); # verificar que el JSON respuesta sea el esperado, se define su estructura.

        # validar que NO exista este registro en la BD.
        $this->assertDatabaseMissing('accounts', [
            'name' => 'Cuenta Error',
            'user_id' => $user->id
        ]);
    }



    /**
     * Validar que el balance no sea menor a 0 al crear 
     * un nuevo Account.
     *
     * @return void
     */
    function test_it_validates_balance_no_less_than_0(){

        // Preparación
        $user =  factory(User::class)->create();
        Passport::actingAs($user); # actingAs para establecer este usuario como autenticado.

        // Ejecución
        $response = $this->graphQL('mutation{
            createAccount(input: {
                name: "Cuenta Error",
                balance: -100,
                description: "Mis fondos libres"
              }) {
                name
                balance
                description
                color
                user {
                  id
                  name
                }
              }
        }'); # se manda un string en el campo "balance" 

        // Assertions - Verificación
        $response->assertJson([
            'errors' => [ # graphql devuelve un objeto llamado "errors" si hay un problema.
                [
                    'message' => 'Validation failed for the field [createAccount].',
                    'extensions' => [
                        'validation' => [
                            'input.balance' => [
                                'The input.balance must be greater than or equal 0.'
                            ]
                        ]
                    ]
                ]
            ]
        ]); # verificar que el JSON respuesta sea el esperado, se define su estructura.

        # validar que NO exista este registro en la BD.
        $this->assertDatabaseMissing('accounts', [
            'name' => 'Cuenta Error',
            'user_id' => $user->id
        ]);
    }



    /**
     * Validar que se pueda actualizar una cuenta
     *
     * @return void
     */
    function test_it_can_update_an_account(){

        // Preparación
        $user =  factory(User::class)->create();
        $account = factory(Account::class)->create([
            'name' => 'Wallet',
            'color' => '#fff',
            'description' => 'Principal',
            'user_id' => $user->id,
            'balance' => 100,
        ]); # crea un Account en 0 para el usuario de prueba
        Passport::actingAs($user); # actingAs para establecer este usuario como autenticado.

        // execute
        $response = $this->graphQL('
            mutation {
                updateAccount(id:'.$account->id.', input: {
                    name: "Savings"
                    color: "white"
                    description: "Ahorros"
                }){
                    id
                    name
                    color
                    description
                    balance
                }
            }
        ');

        // assert
        $response->assertJson([
            'data' => [
                'updateAccount' => [
                    'id' => $account->id,
                    'name' => 'Savings',
                    'color' => 'white',
                    'description' => 'Ahorros',
                    'balance' => $account->balance
                ]
            ]
        ]);
                
        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'name' => 'Savings',
            'color' => 'white',
            'description' => 'Ahorros',
            'user_id' => $user->id,
        ]);
    }


    /**
     * Verificar que no se pueda actualizar una cuenta
     * por otro usuario distinto al dueño.
     *
     * @return void
     */
    function test_it_cant_update_an_account_when_not_owner(){

        // Preparación
        $user =  factory(User::class)->create();
        $user2 =  factory(User::class)->create();
        $account = factory(Account::class)->create([
            'name' => 'Wallet',
            'color' => '#fff',
            'description' => 'Principal',
            'user_id' => $user->id,
            'balance' => 100,
        ]); # crea un Account en 0 para el usuario de prueba

        # hacer el request con otro usuario.
        Passport::actingAs($user2); 

        // execute
        $response = $this->graphQL('
            mutation {
                updateAccount(id:'.$account->id.', input: {
                    name: "Savings"
                    color: "white"
                    description: "Ahorros"
                }){
                    id
                    name
                    color
                    description
                    balance
                }
            }
        ');

        // assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access updateAccount'
                ]
            ]
        ]);
                
        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
            'name' => 'Savings',
            'color' => 'white',
            'description' => 'Ahorros',
            'user_id' => $user2->id,
        ]);
    }
}
