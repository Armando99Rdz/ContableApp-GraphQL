<?php

namespace App;

use App\Http\Middleware\TrustHosts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'account_id', 'category_id', 'description', 'amount', 'type'
    ];

    /**
     * Castar los valores de un o varios campos
     *
     * @var array
     */
    protected $casts = [
        'id' => 'Int', # genera errores en los test
        'account_id' => 'Int',
        'category_id' => 'Int',
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


    public function category() : BelongsTo {
        return $this->belongsTo(Category::class);
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
        if( !request()->user() ){ # si no hay un usuario autenticado
            return $query;
        }
        # Obtener las transacciones de una cuenta del usuario
        # autenticado.
        return $query->whereHas('account', function ($query){
            $query->where('user_id', request()->user()->id);
        });
    }

}
