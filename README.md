<h2 align="center">WebApp control de gastos e ingresos | Laravel | GraphQL</h2>

Uso de **Lighthouse PHP** para crear GraphQL API's en Laravel.
Artículo crear un servidor de Autenticacion con Passport y Lighthouse para API GraphQL; https://dev.to/joselfonseca/graphql-auth-with-passport-and-lighthouse-php-14g5.

La instalación y configuracion de Laravel Passport desde la documentación oficial de laravel: https://laravel.com/docs/7.x/passport. 

Crear servidor de autenticacion para la API GraphQL:
- `composer require nuwave/lighthouse laravel/passport joselfonseca/lighthouse-graphql-passport-auth`. Instala lighthouse, laravel passport y el paquete de Jose Fonseca.
- `php artisan migrate`
- `php artisan passport:install`. Crear dos clientes para utilizar con Laravel Passport.
- Agregar `use HasApiTokens;` del paquete use `Laravel\Passport\HasApiTokens` en el modelo User.
- Registrar las rutas de Passport en el AuthServiceProvider (dentro de app/providers/) agregando `Passport::routes();` en el método `boot()`.
- Cambiar el driver `api` a `passport` (por defecto está en `tokens`) dentro de config/app.php
- `php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=schema` para publicar el schema del API.

<small>1. 16:09</small>
