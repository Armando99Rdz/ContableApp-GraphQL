<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'balance',
        'color',
        'description',
        'user_id'
    ];

    /**
     * Castear valores de uno o varios campos.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'Int', # genera errores en los test
        'user_id' => 'Int',
        'balance' => 'Float'
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


    /**
     * Relacion a Transactions.
     *
     * Es importante especificar que retorna un HasMany porque
     * la librería Lighthouse (la librería que construye nuestro
     * GraphQL server) usa los return para Optimizar las
     * Consultas que hace a la Base de Datos.
     *
     * @return HasMany
     */
    public function transactions() : HasMany {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope para validar que se obtengan las transacciones
     * de una cuenta en concreto y que el usuario dueño
     * esté autenticado.
     *
     * Este scope se llama omitiendo "scope" en el nombre;
     * es decir sólo byLoggedInUser.
     *
     */
    public function scopeByLoggedInUser($query){
        if(!request()->user()){
            return $query;
        }
        $query->where('user_id', request()->user()->id);
    }
}
