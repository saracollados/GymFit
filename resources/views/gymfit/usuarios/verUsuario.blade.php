@extends('app')

@section('title', 'Mi Perfil')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Mi perfil</h6>
  </div>
@endsection

@section('content')
    @if (isset($error) && $error != '')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @elseif (isset($success) && $success != '')        
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$success}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="flex justify-between mb-6">
        <div class="w-1/2">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
            <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$usuario->nombre}}">
        </div>
        <div class="w-1/6">
            <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI:</label>
            <input name="dni" type="text" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$usuario->dni}}">
        </div>
        <div class="w-1/6">
            <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900">Fecha nacimiento:</label>
            <input name="fecha_nacimiento" type="date" id="fecha_nacimiento" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$usuario->fecha_nacimiento}}">
        </div>
    </div>
    <div class="flex justify-between mb-6">
        <div class="w-1/3">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico:</label>
            <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$usuario->email}}">
        </div>
        <div class="w-1/6">
            <label for="genero_id" class="block mb-2 text-sm font-medium text-gray-900">Género:</label>
            <input name="genero_id" type="text" id="genero_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$usuario->genero_nombre}}">
        </div>
    </div>

    <div class="mt-10 text-center">
        <form action="{{route('editarPerfilUsuario')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{session('userInfo')['id']}}">
            
            <button type="submit" class="btn secondaryBtn">Editar perfil</button>
        </form>
    </div>
@endsection