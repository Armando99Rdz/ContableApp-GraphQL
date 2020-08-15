<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

# Paquete para hacer pruebas unitarias con mi api graphql
# https://lighthouse-php.com/4.16/testing/phpunit.html#setup
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests; # usar el paquete 
}
