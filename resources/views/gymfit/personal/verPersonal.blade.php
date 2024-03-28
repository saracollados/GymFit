@extends('app')

@section('title', 'Mi Perfil')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Mi perfil</h6>
  </div>
@endsection

@section('content')
    @if (isset($error) && $error != '')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10 flex justify-between" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @elseif (isset($success) && $success != '')        
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-10 flex justify-between" role="alert">
            <span class="block sm:inline">{{$success}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif
        
    <div class="flex justify-between mb-6">
        <div class="w-2/3">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
            <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$personal->nombre}}">
        </div>
        <div class="w-1/4">
            <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI:</label>
            <input name="dni" type="text" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$personal->dni}}">
        </div>
    </div>
    <div class="flex justify-between mb-6">
        <div class="w-2/3">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico:</label>
            <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$personal->email}}">
        </div>
        <div class="w-1/4">
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Puesto:</label>
            <input name="role" type="text" id="role" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-200" disabled value="{{$personal->role}}">
        </div>
    </div>

    <div class="mt-10 text-center">
        <form action="{{route('editarPerfilPersonal')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{session('userInfo')['id']}}">
            <input type="hidden" name="page" value="perfil">
            
            <button type="submit" class="btn secondaryBtn">Editar perfil</button>
        </form>
    </div>
@endsection