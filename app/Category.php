<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'user_id'];

    /**
     * Castar los valores de un o varios campos
     *
     * @var array
     */
    protected $casts = [
        'id' => 'Int',
        'user_id' => 'Int'
    ];

    /**
     * Relacion al usuario que la creó
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para validar que se obtengan las categorias
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
