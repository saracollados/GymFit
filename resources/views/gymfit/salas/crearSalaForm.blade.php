@extends('app')

@section('title', 'Crear Sala')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Crear Sala</h6>
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
    <form action="{{route('crearSala')}}" method="POST" autocomplete='off'>
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-2/3">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
            <div class="w-1/4">
                <label for="aforo" class="block mb-2 text-sm font-medium text-gray-900">Aforo:</label>
                <input name="aforo" type="number" id="aforo" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
            </div>
        </div>

        <div class="mt-10 text-center">
            <button type="submit" class="btn secondaryBtn">
                Añadir sala
            </button>
        </div>
    </form>
@endsection