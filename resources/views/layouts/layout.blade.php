<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Punto de venta | @yield('title')</title>
    <!-- Primary Meta Tags -->
    <link rel="icon" href="{{ asset('images/shorcut/pos_terminal_6R0_icon.ico') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/plugins/notifIt.css') }}">
    @stack('css')
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav id="header" class="bg-white fixed w-full z-50 top-0 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-4">
            <div class="w-1/2 pl-2 md:pl-0">
                <a class="text-gray-800 text-base xl:text-xl no-underline hover:no-underline font-bold" href="{{ route('dashboard') }}">
                    <!-- <i class="fas fa-sun fa-spin text-blue-600"></i> -->
                    <span>&#128151;</span>
                    <span class="ml-1">Punto de venta</span>
                </a>
            </div>
            <div class="w-1/2 pr-0">
                <div class="flex relative inline-block float-right">
                    <div class="relative text-sm">
                        <button id="userButton" class="flex items-center focus:outline-none mr-3">
                            <img class="w-8 h-8 rounded-full mr-4" src="{{ asset('/images/users/'.auth()->user()->photo) }}" alt="{{ auth()->user()->name }}">
                            <span class="hidden md:inline-block text-gray-800">{{ auth()->user()->name }}</span>
                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                <g>
                                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                </g>
                            </svg>
                        </button>
                        <div id="userMenu" class="bg-white rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                            <ul class="list-reset">
                                <li><a href="{{ route('user.profile') }}" class="px-4 py-2 block text-gray-800 hover:bg-gray-200 no-underline hover:no-underline">Mi perfil</a></li>
                                <li><a href="#" class="px-4 py-2 block text-gray-800 hover:bg-gray-200 no-underline hover:no-underline">Notificaciones</a></li>
                                <li>
                                    <hr class="border-t mx-2 border-gray-200">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="px-4 py-2 block text-gray-800 hover:bg-gray-200 no-underline hover:no-underline">Cerrar sesión</a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--Container-->
    <div class="container w-full mx-auto pt-20 md:pt-12 min-h-screen">
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
            @yield('content')
        </div>
    </div>
    <!--/container-->
    @stack('modals')

    <footer class="bg-white border-t border-gray-300 shadow">
        <div class="container max-w-md mx-auto flex py-4">
            <div class="w-full mx-auto flex flex-wrap">
                <div class="flex justify-center w-full">
                    <p class="text-gray-500 text-sm">
                        <span>&copy; {{ date('Y') }} Todos los derechos reservados. Plataforma PDbien.</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @stack('livewire')
    <script src="https://kit.fontawesome.com/0220325a0e.js" crossorigin="anonymous"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ asset('/js/plugins/notifIt.min.js') }}"></script>
    @stack('scripts')
</body>

</html>