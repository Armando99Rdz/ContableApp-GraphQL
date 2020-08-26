<?php

namespace Tests\Feature;

use App\Account;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryQueriesTest extends TestCase
{
    use RefreshDatabase;

    function test_it_queries_categories(){
        $user = factory(User::class)->create();
        factory(Category::class, 3)->create([
            'user_id' => $user->id
        ]); # crea 3 cuentas para el usuario
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                categories(first: 20){
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
                'categories' => [
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
    function test_it_queries_a_category(){
        $user = factory(User::class)->create();
        $categories = factory(Category::class, 3)->create([
            'user_id' => $user->id
        ]); # crea 3 cuentas para el usuario
        Passport::actingAs($user);
        $category = $categories->shuffle()->first(); # obtener una categoria random

        # execute
        $response = $this->graphQL('
            query {
                category(id: '.$category->id.'){
                    id
                    name
                }
            }

        ');

        # assert
        $response->assertJson([
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ]
        ]);

    }


    /**
     * Validar que no se pueda obtener una cuenta de la cual no
     * se sea el dueño.
     */
    function test_it_cant_query_a_category_not_owner(){
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        Passport::actingAs($user);

        # execute
        $response = $this->graphQL('
            query {
                category(id: '.$category->id.'){
                    id
                    name
                }
            }

        ');

        # assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access category'
                ]
            ]
        ]);

    }
}
