<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = [
        'name', 
        'balance',
        'color',
        'description',
        'user_id'
    ];

    /**
     * Relacion a usuario.
     * 
     * Es importante especificar que retorna un BelongsTo porque 
     * la librería Lighthouse (la librería que construye nuestro 
     * GraphQL server) usa los return para Optimizar las 
     * Consultas que hace a la Base de Datos.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
