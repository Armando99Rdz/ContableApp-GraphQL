<?php


namespace App\GraphQL\Queries;


use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Illuminate\Support\Carbon;

class DateResolver {

    /**
     * Resolver de ejemplo para un campo, en este caso para
     * el campo "date" del type ExchangeRates.
     *
     * Los resolver deben retornar el valor que debe tener el campo en
     * cuestíon, para este ejemplo, este resolver retorna una fecha en string
     * para que GraphQL la asignará al campo "date".
     */
    public function __invoke($_, array $args)
    {
        return now()->toDateString();
    }
}
