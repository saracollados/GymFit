@extends('app')

@section('title')
    @if(isset($miPerfil) && $miPerfil)
        Editar Perfil
    @elseif (isset($personal))
        Editar Trabajador
    @else                                                                                          
        Crear Trabajador
    @endif
@endsection

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">
        @if(isset($miPerfil) && $miPerfil)
            Editar mi perfil
        @elseif (isset($personal))
            Editar Trabajador {{$personal->nombre}}
        @else                                                                                          
            Crear Trabajador
        @endif
    </h6>
  </div>
@endsection

@section('content')
    <form action="{{isset($personal) ? route('editarPersonal') : route('crearPersonal') }}" method="POST" autocomplete='off'>
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-2/3">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(isset($personal)) value="{{$personal->nombre}}" @endif required>
            </div>
            <div class="w-1/4">
                <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI:</label>
                <input name="dni" type="text" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded @if(isset($personal)) bg-gray-200 @else bg-gray-50 @endif" @if(isset($personal)) value="{{$personal->dni}}" disabled @else required @endif>
            </div>
        </div>
        <div class="flex justify-between mb-6">
            <div class="w-2/3">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico:</label>
                <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(isset($personal)) value="{{$personal->email}}" @endif required>
            </div>
            <div class="w-1/4">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Puesto:</label>
                @if (isset($personal))
                    <input name="role" type="text" id="role" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" @if(isset($personal)) value="{{$personal->role}}" @endif disabled>
                @else 
                    <select name="role" id="role" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(!isset($personal)) required @endif>
                        <option value="" selected disabled>Seleccione un puesto</option>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}" {{isset($personal) && $personal->role_id == $role->id ? 'selected' : '' }}>
                                {{$role->nombre}}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        @if(!isset($personal)) 
            <p class="mt-4 mb-2 text-sm">La contraseña será el DNI del usuario.</p>
        @endif

        @if(isset($personal) && isset($miPerfil) && $miPerfil)
            <div id="cambiar-contraseña" class="flex justify-between mb-6">
                <div  @if(!isset($personal)) style="display: none;" @endif>
                    <button id="btn-cambiar-contraseña" class="btn primaryBtn">Cambiar contraseña</button>
                </div>
            </div>
        @endif
        <div id="cambiar-contraseña-form" class="flex gap-x-8 mb-6"></div>

        <div class="mt-10 text-center">
            @if(isset($miPerfil) && $miPerfil)
                <input type="hidden" name="personal_id" value="{{$personal->id}}">
                <input type="hidden" name="page" value="{{$page}}">
                <button type="submit" class="btn secondaryBtn">
                    Actualizar perfil
                </button>
            @elseif (isset($personal))
                <input type="hidden" name="personal_id" value="{{$personal->id}}">
                <input type="hidden" name="page" value="{{$page}}">
                <button type="submit" class="btn secondaryBtn">
                    Actualizar trabajador
                </button>
            @else                                                                                          
                <button type="submit" class="btn secondaryBtn">
                    Alta trabajador
                </button>
            @endif
        </div>
    </form>

    @if(isset($personal) && session('isAdmin') && isset($miPerfil) && !$miPerfil)
        <form action="{{route('restablecerContraseñaPersonal')}}" method="POST" autocomplete='off'>
            @csrf
            <input type="hidden" name="personal_id" value="{{$personal->id}}">
            <p class="mt-4 mb-2 text-sm">Al restablecer la contraseña, esta pasará a ser el DNI del usuario.</p>
            <div id="restablecer-contraseña" class="flex justify-between mb-6">
                <div  @if(!isset($personal)) style="display: none;" @endif>
                    <button class="btn primaryBtn" data-id={{$personal->id}}>Restablecer contraseña</button>
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