@extends('app')

@section('title')
    @if(isset($usuario))
        Editar Usuario
    @else
        Crear Usuario
    @endif
@endsection

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">
        @if(isset($usuario))
            Editar usuario {{$usuario->nombre}}
        @else
            Crear usuario
        @endif
    </h6>
  </div>
@endsection

@section('content')
    @if (isset($error) && $error != '')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif
    <form action="{{ isset($usuario) ? route('editarUsuario') : route('crearUsuario') }}" method="POST" autocomplete='off'>
        
        @csrf
        <div class="flex justify-between mb-6">
            <div class="w-1/2">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded" @if(isset($usuario)) value="{{$usuario->nombre}}" @endif required>
            </div>
            <div class="w-1/6">
                <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI:</label>
                <input name="dni" type="text" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded  @if(isset($usuario)) bg-gray-200 @else bg-gray-50 @endif" @if(isset($usuario)) value="{{$usuario->dni}}" disabled @else required @endif>
            </div>
            <div class="w-1/6">
                <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900">Fecha nacimiento:</label>
                <input name="fecha_nacimiento" type="date" id="fecha_nacimiento" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50"  @if(isset($usuario)) value="{{$usuario->fecha_nacimiento}}" @endif required>
            </div>
        </div>
        <div class="flex justify-between mb-6">
            <div class="w-1/2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico:</label>
                <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(isset($usuario)) value="{{$usuario->email}}" @endif required>
            </div>
            <div class="w-1/6">
                <label for="genero_id" class="block mb-2 text-sm font-medium text-gray-900">Género:</label>
                <select name="genero_id" id="genero_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected>Seleccione un género</option>
                    @foreach ($generos as $genero)
                        <option value="{{$genero->id}}" {{isset($usuario) && $usuario->genero_id == $genero->id ? 'selected' : '' }}>
                            {{$genero->nombre}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(!isset($usuario)) 
            <p class="mt-4 mb-2 text-sm">La contraseña será el DNI del usuario.</p>
        @endif

        @if(isset($usuario) && session('userType') == 'usuario')
            <div id="cambiar-contraseña" class="flex justify-between mb-6">
                <div  @if(!isset($usuario)) style="display: none;" @endif>
                    <button id="btn-cambiar-contraseña" class="btn primaryBtn">Cambiar contraseña</button>
                </div>
            </div>
        @endif
        <div id="cambiar-contraseña-form" class="flex gap-x-8 mb-6"></div>

        <div class="mt-10 text-center">
            @if(isset($usuario))
                <input type="hidden" name="usuario_id" value="{{$usuario->id}}">
                <button type="submit" class="btn secondaryBtn">
                    Actualizar usuario
                </button>
            @else
                <button type="submit" class="btn secondaryBtn">
                    Alta usuario
                </button>
            @endif
        </div>
    </form>
    @if(isset($usuario) && session('isAdmin'))
        <form action="{{route('restablecerContraseñaUsuario')}}" method="POST" autocomplete='off'>
            @csrf
            <input type="hidden" name="usuario_id" value="{{$usuario->id}}">
            <p class="mt-4 mb-2 text-sm">Al restablecer la contraseña, esta pasará a ser el DNI del usuario.</p>
            <div id="restablecer-contraseña" class="flex justify-between mb-6">
                <div  @if(!isset($usuario)) style="display: none;" @endif>
                    <button class="btn primaryBtn" data-id={{$usuario->id}}>Restablecer contraseña</button>
                </div>
            </div>
        </form>
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function mostrarCamposContraseña(event) {
                event.preventDefault();
                // Genera el HTML de los campos de contraseña
                var camposHTML = `
                    <div class="w-1/3">
                        <label for="password_actual" class="block mb-2 text-sm font-medium text-gray-900">Contraseña actual:</label>
                        <input name="password_actual" type="password" id="password_actual" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50">
                    </div>
                    <div class="w-1/3">
                        <label for="password_nueva" class="block mb-2 text-sm font-medium text-gray-900">Nueva Contraseña:</label>
                        <input name="password_nueva" type="password" id="password_nueva" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50">
                    </div>
                `;

                // Inserta los campos de contraseña en el div contenedor
                $('#cambiar-contraseña-form').html(camposHTML);

                // Muestra el div contenedor
                $('#cambiar-contraseña-form').show();
            }
            $('#btn-cambiar-contraseña').on('click', mostrarCamposContraseña);
        });
    </script>
@endsection