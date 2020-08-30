<h2 align="center">WebApp control de gastos e ingresos | Laravel | GraphQL</h2>


## Backend

Uso de **Lighthouse PHP** para crear servidor GraphQL (API). <br>
Artículo crear un servidor de Autenticacion con Passport y Lighthouse para API GraphQL; https://dev.to/joselfonseca/graphql-auth-with-passport-and-lighthouse-php-14g5.

https://github.com/joselfonseca/lighthouse-graphql-passport-auth

La instalación y configuracion de Laravel Passport desde la documentación oficial de laravel: https://laravel.com/docs/7.x/passport. 

Crear servidor de autenticacion para la API GraphQL:
- `composer require nuwave/lighthouse laravel/passport joselfonseca/lighthouse-graphql-passport-auth`. Instala lighthouse, laravel passport y el paquete de Jose Fonseca.
- `php artisan migrate`
- `php artisan passport:install`. Crear dos clientes para utilizar con Laravel Passport.
- Agregar `use HasApiTokens;` del paquete use `Laravel\Passport\HasApiTokens` en el modelo User.
- Registrar las rutas de Passport en el AuthServiceProvider (dentro de app/providers/) agregando `Passport::routes();` en el método `boot()`.
- Cambiar el driver `api` a `passport` (por defecto está en `tokens`) dentro de config/app.php
- `php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=schema` para publicar el schema del API.

#### Passport client - authorization error
`Incorrect username or password`
Configurar el passport client para el API dentro de las variables de entorno
- `PASSPORT_CLIENT_ID=2`
- `PASSPORT_CLIENT_SECRET=`

Susttituir `PASSPORT_CLIENT_SECRET=...` por el secret password client generado en la BD tabla `oatuh_clients`, normalmente es el id 2.
Si no aparece ejecutar nuevamente el comando `php artisan passport:install` para generar los passport clients.
    

#### Test unitarios
Correr un test en específico `vendor/bin/phpunit --filter [test_name]`
###### Account Tests
- `test_it_creates_an_account`
- `test_it_validates_input`
- `test_it_validates_balance_no_less_than_0`
###### Transactions Tests
- `test_it_creates_transaction_and_updates_balance`.
- `test_it_creates_transaction_and_updates_balance_with_expense`
- `test_it_can_update_a_transaction`
- `test_it_can_update_a_transaction_case_2`
- `test_it_can_update_a_transaction_when_not_owner`

#### Factory Generator
https://github.com/mpociot/laravel-test-factory-helper

#### Mis observers (app/observers/)
create a new observer: `php artisan make:observer [name]`.
- `TransactionObserver`.

#### Mis policies (app/plicies/)
- `AccountPolicy`
- `TransactionPolicy`

#### Mis listeners 
crear un listener: `php artisan make:listener CreateDefaultCategories --event [evento]`. 

Ej; `php artisan make:listener CreateDefaultCategories --event Illuminate\Auth\Events\Registered`
- `CreateDefaultCategories`

#### Herramienta Telescope
Inpeccionar en desarrollo los requests, consultas a BD, etc. 
- `composer require laravel/telescope`
- `php artisan telescope:install`
- `php artisan migrate`

#### filtrar datos - graphql php scalars
Directiva de Lighthouse para filtrar los datos en base a una columna pro ejemplo.
Complex Where Conditions - Lighthouse PHP Documentation.
- `composer require mll-lab/graphql-php-scalars`.
- `\Nuwave\Lighthouse\WhereConditions\WhereConditionsServiceProvider::class,`. Registrar el Service Provider (config/app.php).
- hasta este punto puede usar la directiva @whereConditions en graphql queries, ejemplo:  
    - `transactions(where: _ @whereConditions(columns: ["type","created_at"]))`

#### crear resolver con lighthouse 
- `php artisan lighthouse:query [resolver_name]`. Los resolvers/queries se crean en `app/GraphQL/Queries/`. 
- Se creó resolver de ejemplo `DateResolver` para el campo `date` del type `ExchangeRates`.


### Integrando una API de divisas
https://exchangeratesapi.io/ posee un wrapper para laravel: 
https://github.com/ash-jc-allen/laravel-exchange-rates
- `composer require ashallendesign/laravel-exchange-rates`  

## Frontend

#### tailwindcss
Tailwindcss Laravel Preset: https://github.com/laravel-frontend-presets/tailwindcss.
- `composer require laravel-frontend-presets/tailwindcss --dev`
- `php artisan ui tailwindcss --auth` en caso de usar autenticación de laravel.
- `npm i`

#### Installation & Setup: Vue Vue-Router Vue-Apollo 
- `npm i vue vue-router vue-apollo graphql apollo-boost --save` 

#### Error archivos .graphql en Laravel Mix
Por defecto laravel mix no compila archivos .graphql, solución: https://github.com/pp-spaces/laravel-mix-graphql. 
Con este paquete ya se podrá importar archivos .graphql desde js (ej: `import ACCOUNTS from '../../graphql/accounts.graphql';`) 

#### loading spinners
https://github.com/Saeris/vue-spinners
- `npm install --save @saeris/vue-spinners`

## Deploy
#### Laravel forge


<p align="right">1. 16:09</p>
