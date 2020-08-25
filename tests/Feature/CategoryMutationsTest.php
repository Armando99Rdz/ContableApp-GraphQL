<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryMutationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Crear categorias de transacciones
     */
    function test_it_can_create_a_category(){
        //prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        //execute
        $response = $this->graphQL('
            mutation {
                createCategory(input: {
                    name: "Category 1"
                }){
                    name
                    user {
                        id
                    }
                }
            }
        ');

        //assert
        $response->assertJson([
           'data' => [
               'createCategory' => [
                   'name' => 'Category 1',
                   'user' => [
                       'id' => $user->id
                   ]
               ]
           ]
        ]);
    }


    function test_it_can_update_a_category(){
        //prepare
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create([
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);

        //execute
        $response = $this->graphQL('
            mutation {
                updateCategory(id: "'.$category->id.'", input: {
                    name: "Category 1"
                }) {
                    name
                    user {
                        id
                    }
                }
            }
        ');

        //assert
        $response->assertJson([
            'data' => [
                'updateCategory' => [
                    'name' => 'Category 1',
                    'user' => [
                        'id' => $user->id
                    ]
                ]
            ]
        ]);
    }


    /**
     * Verificar que no se pueda actualizar una categoria
     * por otro usuario distinto al dueño.
     *
     * @return void
     */
    function test_it_cant_update_a_category_when_not_owner(){

        // Preparación
        $user =  factory(User::class)->create();
        $user2 =  factory(User::class)->create();
        $category = factory(Category::class)->create([
            'user_id' => $user->id
        ]);
        # hacer el request con otro usuario.
        Passport::actingAs($user2);

        // execute
        $response = $this->graphQL('
            mutation {
                updateCategory(id:'.$category->id.', input: {
                    name: "Savings"
                }){
                    id
                    name
                }
            }
        ');

        // assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access updateCategory'
                ]
            ]
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'name' => 'Savings',
            'user_id' => $user->id,
        ]);
    }


    /**
     * Eliminar una categoria
     */
    function test_it_cant_delete_a_category(){

        // Preparación
        $user =  factory(User::class)->create();
        $category = factory(Category::class)->create([
            'user_id' => $user->id
        ]);
        # hacer el request con otro usuario.
        Passport::actingAs($user);

        // execute
        $response = $this->graphQL('
            mutation {
                deleteCategory(id: '.$category->id.'){
                    id
                    name
                }
            }
        ');

        // assert
        $response->assertJson([
            'data' => [
                'deleteCategory' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ]
        ]);

        $this->assertNotNull($category->fresh()->deleted_at);
    }



    /**
     * Eliminar una categoria
     */
    function test_it_cant_delete_a_category_when_not_owner(){

        // Preparación
        $user =  factory(User::class)->create();
        $user2 =  factory(User::class)->create();
        $category = factory(Category::class)->create([
            'user_id' => $user->id
        ]);
        # hacer el request con otro usuario.
        Passport::actingAs($user2);

        // execute
        $response = $this->graphQL('
            mutation {
                deleteCategory(id: '.$category->id.'){
                    id
                    name
                }
            }
        ');

        // assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access deleteCategory'
                ]
            ]
        ]);
        $this->assertNull($category->fresh()->deleted_at);
    }
}
