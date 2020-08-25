<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

# Paquete para hacer pruebas unitarias con mi api graphql
# https://lighthouse-php.com/4.16/testing/phpunit.html#setup
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests; # usar el paquete

    /**
     * Create a passport client for testing
     */
    public function createPassportClient(){
        $client = app(ClientRepository::class)->createPasswordGrantClient(null, 'test', 'http://localhost');
        config()->set('lighthouse-graphql-passport.client_id', $client->id);
        config()->set('lighthouse-graphql-passport.client_secret', $client->secret);
    }
}
