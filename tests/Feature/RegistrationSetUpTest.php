<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationSetUpTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Validar que se creen las categorias por defecto
     * al registrarse un usuario.
     */
    function test_it_creates_default_categories_on_user_creation(){

        // categorias por defecto:
        // Salario, Prestamo, Renta, Arriendo, Alimentacion, Transporte, Otros
        $this->createPassportClient();
        $response = $this->graphQL('
            mutation {
                register(input: {
                    name: "Example",
                    email: "example@example.com",
                    password: "exampleexample",
                    password_confirmation: "exampleexample"
                  }) {
                    status
                  }
            }
        ');
        $user = User::first();
        $this->assertEquals(7, $user->categories->count());
    }
}
