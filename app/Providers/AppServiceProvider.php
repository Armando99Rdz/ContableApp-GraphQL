<?php

namespace App\Providers;

use App\CalculateAccountBalance;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * El método singleton mantiene la misma instancia de una clase
         * cada vez que se llama durante un ciclo de vida de un request.
         * En este caso se mantendrá la misma instancia de la clase
         * CalculateNewAccountBalance.
         */
        $this->app->singleton(CalculateAccountBalance::class, function ($app){
            return new CalculateAccountBalance();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
