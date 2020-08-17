<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'account_id', 'description', 'amount', 'type'
    ];

    /**
     * Castar los valores de un o varios campos
     *
     * @var array
     */
    protected $casts = [
        'account_id' => 'Int',
        'amount' => 'Float'
    ];


    /**
     * Relación a Account
     * 
     * Es importante especificar que retorna un BelongsTo porque 
     * la librería Lighthouse (la librería que construye nuestro 
     * GraphQL server) usa los return para Optimizar las 
     * Consultas que hace a la Base de Datos.
     * 
     * @return BelongsTo
     */
    public function account() : BelongsTo {
        return $this->belongsTo(Account::class);
    }

}
