@extends('app')

@section('title')
    @if(isset($sala))
        Editar Sala
    @else
        Crear Sala
    @endif
@endsection

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">
        @if(isset($sala))
            Editar Sala: {{$sala->nombre}}
        @else
            Crear Sala
        @endif
    </h6>
  </div>
@endsection

@section('content')
    <form action="{{ isset($sala) ? route('editarSala') : route('crearSala') }}" method="POST" autocomplete='off'>
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-2/3">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(isset($sala)) value="{{$sala->nombre}}" @endif required>
            </div>
            <div class="w-1/4">
                <label for="aforo" class="block mb-2 text-sm font-medium text-gray-900">Aforo:</label>
                <input name="aforo" type="number" id="aforo" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(isset($sala)) value="{{$sala->aforo}}" @endif required>
            </div>
        </div>

        <div class="mt-10 text-center">
            @if(isset($sala))
                <input type="hidden" name="sala_id" value="{{$sala->id}}">
                <button type="submit" class="btn secondaryBtn">
                    Actualizar Sala
                </button>
            @else
                <button type="submit" class="btn secondaryBtn">
                    Añadir Sala
                </button>
            @endif
        </div>
    </form>
@endsection