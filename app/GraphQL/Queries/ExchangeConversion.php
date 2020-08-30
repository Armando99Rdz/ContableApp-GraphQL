<?php

namespace App\GraphQL\Queries;

use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Illuminate\Support\Carbon;
use function MongoDB\BSON\toJSON;

class ExchangeConversion
{
    /**
     * Resolver para el conversor de divisas de mi GraphQL API.
     * Los resolver son clases PHP con un sólo método (__invoke) que
     * retornan un array con los datos.
     *
     * @param  null  $_
     * @param  array<string, mixed>  $args Los datos que llegan a través del query
     */
    public function __invoke($_, array $args)
    {
        $exchangeRates = new ExchangeRate();
        return [
            'from' => $args['from'],
            'to' => $args['to'],
            'value' => $args['value'],
            'result' => $exchangeRates->convert($args['value'], $args['from'], $args['to'], Carbon::now())
        ];
    }
}
