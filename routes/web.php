<?php

use Illuminate\Support\Facades\Route;

/**
 * Las rutas que vienen por defecto en Laravel (/login, register, etc.) se dejaran
 * que el mismo Laravel las resuelva.
 * Para el resto de rutas de la aplicacion se manejarán con Vue Router intentando
 * mantener un SPA (single page application).
 */

Auth::routes();

Route::get('/dashboard', function(){
    return view('spa2');
});
Route::get('/{view}', 'SPAController@index')->where('view', '.*')->name('home');

