<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de venta | Acceso</title>

    <!-- Tailwind -->
    <link rel="icon" href="{{ asset('images/shorcut/pos_terminal_6R0_icon.ico') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }
    </style>
</head>

<body class="bg-white font-family-karla h-screen bg-gray-100">
    <div class="w-full flex flex-wrap">
        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col">
            <!-- <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
                <a href="#" class="bg-black text-white font-bold text-xl p-4">Logo</a>
            </div> -->
            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl font-black">Bienvenido</p>
                <form class="flex flex-col pt-3 md:pt-8" method="POST" action="{{ route('login') }}" id="frmLogin">
                    @csrf
                    <div class="pt-4 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="username">
                            Usuario
                        </label>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="username" id="username" class="p-2.5 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                        </div>
                    </div>
                    <div class="pt-4 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="password">
                            Contraseña
                        </label>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3">
                                <i class="fas fa-unlock-alt"></i>
                            </span>
                            <input type="password" name="password" id="password" class="p-2.5 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" autocomplete="current-password" />
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white font-bold text-lg hover:bg-blue-400 rounded p-2 mt-8">Ingresar</button>
                </form>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <div class="text-center pt-12 pb-12">
                    <p>Punto de venta desarrollado con &#128151;</p>
                </div>
            </div>
        </div>
        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl">
            <img class="object-cover w-full h-screen hidden md:block" src="https://source.unsplash.com/IXUM4cJynP0">
        </div>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ mix('/js/login.js') }}"></script>
</body>

</html>