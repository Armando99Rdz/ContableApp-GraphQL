<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateDefaultCategories
{
    # Cuando se creee un usuario se crearán categorias por default.
    # Para esto se hace uso del método create().
    # Salario, Prestamo, Renta, Arriendo, Alimentacion, Transporte, Otros
    public $categories = [
        'Salario',
        'Préstamo',
        'Renta',
        'Arriendo',
        'Alimentacion',
        'Transporte',
        'Otros'
    ];


    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;
        collect($this->categories)->each(function($category) use ($user) {
            $user->categories()->create([
                'name' => $category
            ]);
        });
    }
}
