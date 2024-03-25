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

    <link rel="icon" type="image/png" href="/images/GymFit-Icon.png">
    
    @vite('resources/css/app.css')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>GymFit</title>
</head>
<body class="bg-gray text-black">
    <header class="bg-gray p-4 text-dark-blue">
        <div class="container mx-auto flex justify-between items-center">
            <div id="logo-header"></div>
            <nav>
                <ul class="flex flex-row">
                    @authany
                        @if(session('userType') == 'personal')
                            <li>
                                <a class="py-2.5 text-sm my-0 flex items-center px-4" href="/">
                                    <span class="ml-1 opacity-100">Dashboard</span>
                                </a>
                            </li>
                        @elseif ((session('userType') == 'usuario')) 
                            <li>
                                <a class="py-2.5 text-sm my-0 flex items-center pr-4" href="/mostrarReservasClases">
                                    <span class="ml-1 opacity-100">Mis reservas</span>
                                </a>
                            </li>
                        @endif
                        {{-- Contenido visible para cualquier usuario autenticado --}}
                        <li>
                            <form action="{{session('userType') == 'personal' ? route('miPerfilPersonal') : route('miPerfilUsuario')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{session('userInfo')['id']}}">
                                <button type="submit" class="py-2.5 text-sm my-0 mr-4 flex items-center px-4">
                                    <span class="ml-1 opacity-100">Mi perfil</span>
                                </button>
                            </form> 
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn secondaryBtn">
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    @else
                        <a href="{{ route('login.show') }}" class="btn secondaryBtn">
                            Iniciar sesión
                        </a>
                    @endauthany    
                </ul>  
            </nav>
        </div>
    </header>

    <div id="app">
        @yield('content')
    </div>
</body>
</html>
