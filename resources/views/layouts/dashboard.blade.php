<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    {{--<link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="h-screen antialiased leading-none bg-indigo-100">
    <div id="app">
        <div class="font-sans bg-indigo-100 flex flex-col h-screen justify-between w-full">

            <!-- top and nav bar -->
            <div class="mb-8">
               <div>
                <div class="bg-indigo-800">
                    <div class="container mx-auto px-4">
                        <div class="flex items-center md:justify-between py-4">
                            <div class="w-1/4 md:hidden">
                                <svg class="fill-current text-white h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16.4 9H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1zm0 4H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1zM3.6 7h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1z"/></svg>
                                </div>
                                <a href="{{ url('/') }}" class="w-1/2 md:w-auto text-center text-white text-2xl font-medium hover:text-gray-200">
                                    Expenses & Incomes
                                </a>
                                <div class="w-3/4 md:w-64 md:flex text-right">
                                    @guest
                                        <a class="w-full no-underline hover:text-gray-300 text-gray-100 text-md p-3" href="{{ route('login') }}">Iniciar Sesión</a>
                                        @if (Route::has('register'))
                                            <a class="no-underline hover:text-gray-300 text-gray-100 text-md p-3" href="{{ route('register') }}">Registrarme</a>
                                        @endif
                                    @else
                                        <a onclick="showOrHideTopDropduwnMenu();" class="md:flex cursor-pointer w-full">
                                            <div class="md:flex-1">
                                                <img class="inline-block h-8 w-8 rounded-full" src="https://avatars0.githubusercontent.com/u/4323180?s=460&v=4" alt="">
                                            </div>
                                            <div class="md:flex-1 hidden md:block md:flex md:items-center ml-2">
                                                <span class="text-white text-sm mr-1">{{ Auth::user()->name }}</span>
                                                <div>
                                                    <svg class="fill-current text-white h-4 w-4 block opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                        <div id="topDropdownMenu" class="absolute right-0 mt-2 md:mt-9 mr-3 md:mr-9 lg:mr-28 xl:mr-60  py-2 w-40 bg-white rounded-md text-left shadow-lg invisible">
                                            <a href="{{ route('logout') }}"
                                                class="block px-4 text-gray-600 hover:text-indigo-700 py-1"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">Salir
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                    @auth
                    <div class="hidden bg-white md:block md:border-b">
                        <div class="container mx-auto px-4">
                            <div class="md:flex">
                                <div class="flex -mb-px mr-8">
                                    <router-link to="/dashboard" active-class="text-indigo-700 border-indigo-700" class="no-underline text-gray-500 flex items-center py-4 border-b">
                                        <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M3.889 3h6.222a.9.9 0 0 1 .889.91v8.18a.9.9 0 0 1-.889.91H3.89A.9.9 0 0 1 3 12.09V3.91A.9.9 0 0 1 3.889 3zM3.889 15h6.222c.491 0 .889.384.889.857v4.286c0 .473-.398.857-.889.857H3.89C3.398 21 3 20.616 3 20.143v-4.286c0-.473.398-.857.889-.857zM13.889 11h6.222a.9.9 0 0 1 .889.91v8.18a.9.9 0 0 1-.889.91H13.89a.9.9 0 0 1-.889-.91v-8.18a.9.9 0 0 1 .889-.91zM13.889 3h6.222c.491 0 .889.384.889.857v4.286c0 .473-.398.857-.889.857H13.89C13.398 9 13 8.616 13 8.143V3.857c0-.473.398-.857.889-.857z"/>
                                        </svg>Dashboard
                                    </router-link>
                                </div>
                                <div class="flex -mb-px mr-8">
                                    <router-link to="/transactions" active-class="text-indigo-700 border-indigo-700" class="no-underline text-gray-500 opacity-50 md:opacity-100 flex items-center py-4 border-b border-transparent hover:opacity-100 md:hover:border-gray-800">
                                        <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 7h10V5l4 3.5-4 3.5v-2H8V7zm-6 8.5L6 12v2h10v3H6v2l-4-3.5z" fill-rule="nonzero"/></svg> Transacciones
                                    </router-link>
                                </div>
                                <div class="flex -mb-px mr-8">
                                    <router-link to="/accounts" active-class="text-indigo-700 border-indigo-700" class="no-underline text-gray-500 opacity-50 md:opacity-100 flex items-center py-4 border-b border-transparent hover:opacity-100 md:hover:border-gray-800">
                                        <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18 8H5.5v-.5l11-.88v.88H18V6c0-1.1-.891-1.872-1.979-1.717L5.98 5.717C4.891 5.873 4 6.9 4 8v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zm-1.5 7.006a1.5 1.5 0 1 1 .001-3.001 1.5 1.5 0 0 1-.001 3.001z" fill-rule="nonzero"/></svg>Cuentas
                                    </router-link>
                                </div>
                                <div class="flex -mb-px mr-8">
                                    <router-link to="/categories" active-class="text-indigo-700 border-indigo-700" class="no-underline text-gray-500 opacity-50 md:opacity-100 flex items-center py-4 border-b border-transparent hover:opacity-100 md:hover:border-gray-800">
                                        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 24 24">
                                            <path d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3v2z"></path>
                                        </svg>Categorías
                                    </router-link>
                                </div>
                                <div class="flex -mb-px">
                                    <router-link to="/settings" active-class="text-indigo-700 border-indigo-700" class="no-underline text-gray-500 opacity-50 md:opacity-100 flex items-center py-4 border-b border-transparent hover:opacity-100 md:hover:border-gray-800">
                                        <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M18.783 12c0-1.049.646-1.875 1.617-2.443a8.932 8.932 0 0 0-.692-1.672c-1.089.285-1.97-.141-2.711-.883-.741-.74-.968-1.621-.683-2.711a8.732 8.732 0 0 0-1.672-.691c-.568.97-1.595 1.615-2.642 1.615-1.048 0-2.074-.645-2.643-1.615-.58.172-1.14.403-1.671.691.285 1.09.059 1.971-.684 2.711-.74.742-1.621 1.168-2.711.883A8.797 8.797 0 0 0 3.6 9.557c.97.568 1.615 1.394 1.615 2.443 0 1.047-.645 2.074-1.615 2.643.173.58.404 1.14.691 1.672 1.09-.285 1.971-.059 2.711.682.741.742.969 1.623.684 2.711.532.288 1.092.52 1.672.693.568-.973 1.595-1.617 2.643-1.617 1.047 0 2.074.645 2.643 1.617a8.963 8.963 0 0 0 1.672-.693c-.285-1.088-.059-1.969.683-2.711.741-.74 1.622-1.166 2.711-.883.287-.532.52-1.092.692-1.672-.973-.569-1.619-1.395-1.619-2.442zM12 15.652a3.653 3.653 0 1 1 0-7.306 3.653 3.653 0 0 1 0 7.306z" fill-rule="nonzero"/>
                                        </svg>Ajustes
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
            <!-- end nav and top bar -->

            @yield('content')
            
            <!-- footer -->
            <div class="bg-white border-t">
                <div class="container mx-auto px-4">
                    <div class="md:flex justify-between items-center text-sm">
                        <div class="text-center md:text-left py-3 md:py-4 border-b md:border-b-0">
                            <a href="#" class="no-underline text-grey-dark mr-4">Website</a>
                            <a href="#" class="no-underline text-grey-dark mr-4">GitHub</a>
                            <a href="#" class="no-underline text-grey-dark mr-4">Linkedin</a>
                        </div>
                        <div class="md:flex md:flex-row-reverse items-center py-4">
                            <div class="text-gray-600 text-center md:ml-2">&copy; 2020 Armando Rodríguez</div>
                            <div class="text-gray-600 text-center">built with <a href="#" class="text-indigo-600 hover:text-indigo-800">Tailwindcss</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end footer -->

        </div>
   
    </div>
    <script>
        var isOpenTopDropdownMenu = false;
        function showOrHideTopDropduwnMenu(){
            if (isOpenTopDropdownMenu){
                document.getElementById('topDropdownMenu').classList.add('invisible');
                document.getElementById('topDropdownMenu').classList.remove('visible');
                isOpenTopDropdownMenu = false;
            }else {
                document.getElementById('topDropdownMenu').classList.add('visible');
                document.getElementById('topDropdownMenu').classList.remove('invisible');
                isOpenTopDropdownMenu = true;
            }
        }
    </script>
</body>
</html>