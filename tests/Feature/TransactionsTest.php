<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Validar cuando se crea una transacción en una cuenta,
     * actualice el balance de la cuenta a la que pertenece.
     *
     * @return void
     */
    function test_it_creates_transaction_and_updates_balance(){
        
        // prepare
        $user = factory(User::class)->create();
        
        // execute

        // assert
    }

}
