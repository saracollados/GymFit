@extends('app')

@section('title', 'Crear Usuario')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Crear Usuario</h6>
  </div>
@endsection

@section('content')
    {{-- <div class="mb-14">
        <a href="/mostrarUsuarios" class="w-1/4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>Atrás
            </button>
        </a>
    </div> --}}
    <form action="{{route('crearUsuario')}}" method="POST" autocomplete='off'>
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-2/4">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
            <div class="w-1/6">
                <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI:</label>
                <input name="dni" type="text" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
            <div class="w-1/6">
                <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900">Fecha nacimiento:</label>
                <input name="fecha_nacimiento" type="date" id="fecha_nacimiento" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
        </div>
        <div class="flex justify-between mb-6">
            <div class="w-1/3">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico:</label>
                <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
            <div class="w-1/3">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Contraseña:</label>
                <input name="password" type="text" id="password" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
            <div class="w-1/6">
                <label for="genero_id" class="block mb-2 text-sm font-medium text-gray-900">Género:</label>
                <select name="genero_id" id="genero_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected>Seleccione un género</option>
                    @foreach ($generos as $genero)
                        <option value="{{$genero->id}}">{{$genero->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-10 text-center">
            <button type="submit" class="btn secondaryBtn">
                Alta usuario
            </button>
        </div>
    </form>
@endsection