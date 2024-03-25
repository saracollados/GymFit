<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
    <script src="{{ asset('js/script.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="/images/GymFit-Icon.png">
    
    @vite('resources/css/app.css')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title')</title>
</head>
<body>
    <div class="min-h-full bg-slate-100 overflow-auto">
        
        <div class="flex h-screen">
            <!-- Sidebar -->
            <?php $routeName = Request::path();?>
            <nav class="text-gray-800 w-64 p-2">
                <ul class="flex flex-col pl-0 mb-0">

                    <div id="logo"></div>
                    
                    <?php $userInfo = session('userInfo'); ?>

                    <li class="mt-0.5 w-full">
                        <p class="py-2.5 text-sm my-0 mx-4">Hola, {{$userInfo['nombre']}}</p>
                    </li>

                    @if(session('userType') == 'personal')
                        @if(session('isAdmin'))
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === '/') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === '/') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === '/') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Dashboard</span>
                                </a>
                            </li>
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === '') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === '') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === '') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Estadísticas</span>
                                </a>
                            </li>
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarUsuarios') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarUsuarios">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarUsuarios') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarUsuarios') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Usuarios</span>
                                </a>
                            </li>
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarPersonal') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarPersonal">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarPersonal') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarPersonal') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Personal</span>
                                </a>
                            </li>
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarSalas') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarSalas">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarSalas') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarSalas') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Salas</span>
                                </a>
                            </li>
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarClases') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarClases">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarClases') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarClases') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Clases</span>
                                </a>
                            </li>
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarHorarios') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarHorarios">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarHorarios') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarHorarios') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Horarios</span>
                                </a>
                            </li>
                        @endif
                        @if(session('isClases') )
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarHorarioPersonalClases') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarHorarioPersonalClases">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarHorarioPersonalClases') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarHorarioPersonalClases') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Mi horario</span>
                                </a>
                            </li>
                        @endif
                        @if(session('isAdmin') || session('isServicios'))
                            <li class="mt-0.5 w-full">
                                <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarHorariosServicios') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarHorariosServicios">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarHorariosServicios') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                        <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarHorariosServicios') #ffffff @else  #070d49 @endif;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">@if(session('isAdmin')) Servicios @else  Mi horario @endif</span>
                                </a>
                            </li>
                        @endif
                    @endif

                    <li class="mt-0.5 w-full">
                        <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4 rounded-lg @if($routeName === 'mostrarReservasClases') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarReservasClases">
                            <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 @if($routeName === 'mostrarReservasClases') bg-gradient-to-tl from-purple-700 to-pink-500 @endif">
                                <i class="fa-solid fa-house" style="color: @if($routeName === 'mostrarReservasClases') #ffffff @else  #070d49 @endif;"></i>
                            </div>
                            
                            @if(session('userType') == 'personal')
                                <span class="ml-1 opacity-100">Reservas</span>
                            @endif

                            @if(session('userType') == 'usuario') 
                                <span class="ml-1 opacity-100">Mis reservas</span>
                            @endif
                        </a>
                    </li>

                    <li class="w-full mt-4">
                      <h6 class="pl-6 mb-0.5 ml-2 font-bold uppercase text-xs opacity-60">CUENTA</h6>
                    </li>

                    @authany
                        {{-- Contenido visible para cualquier usuario autenticado --}}
                        <li class="mt-0.5 w-full"> 
                            <form action="{{session('userType') == 'personal' ? route('miPerfilPersonal') : route('miPerfilUsuario')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{session('userInfo')['id']}}">
                                <button type="submit" class="py-2.5 text-sm my-0 mx-4 flex items-center px-4">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                                        <i class="fa-solid fa-house" style="color: #070d49;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Mi perfil</span>
                                </button>
                            </form>                                                                                                                    
                        </li>
                        
                        <li class="mt-0.5 w-full">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="py-2.5 text-sm my-0 mx-4 flex items-center px-4">
                                    <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                                        <i class="fa-solid fa-house" style="color: #070d49;"></i>
                                    </div>
                                    <span class="ml-1 opacity-100">Cerrar sesión</span>
                                </button>
                                </a>
                            </form>
                        </li>
                    @else
                        <li class="mt-0.5 w-full">
                            <a class="py-2.5 text-sm my-0 mx-4 flex items-center px-4"  href="/login">
                                <div class="custom-box-shadow-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                                    <i class="fa-solid fa-house" style="color: #070d49;"></i>
                                </div>
                                <span class="ml-1 opacity-100">Iniciar sesión</span>
                            </a>
                        </li>
                    @endauthany                 
                  </ul>
                </nav>
    
            <!-- Contenido principal -->
            <div class="flex-1 p-4">
                <header class="">
                    <div class="mx-auto py-6 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
                <main>
                    <div class="mx-auto py-6 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
    @yield('script')
</body>
</html>