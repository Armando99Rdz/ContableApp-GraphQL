<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SPAController extends Controller
{

    /**
     * Recibe el resto de peticiones que laravel 
     * no resolvió (en rutas como login, register, etc.)
     * 
     */
    public function index(){
        return view('spa');
    }
}
