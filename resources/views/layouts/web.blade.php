<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
    <script src="{{ asset('js/script.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    @vite('resources/css/app.css')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>GymFit</title>
</head>
<body class="bg-gray text-black">
    <header class="bg-gray p-4 text-dark-blue">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold">
                <img src="https://www.loopple.com/img/loopple-logo.png" alt="Logo Gimnasio" class="h-4">
            </a>
            <nav>
                @guest
                    <a href="{{ route('login') }}" class="btn secondaryBtn">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn secondaryBtn">
                        Registrarse
                    </a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn secondaryBtn">
                            Cerrar sesión
                        </button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <div id="app">
        @yield('content')
    </div>
</body>
</html>
