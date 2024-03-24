@extends('app')

@section('title')
    @if(isset($clase))
        Editar Clase
    @else
        Crear Clase
    @endif
@endsection

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">
        @if(isset($clase))
            Editar Clase: {{$clase->nombre}}
        @else
            Crear Clase
        @endif
    </h6>
  </div>
@endsection

@section('content')
    <form action="{{ isset($clase) ? route('editarClase') : route('crearClase') }}" method="POST" autocomplete='off'>
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-4/5">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" @if(isset($clase)) value="{{$clase->nombre}}" @endif required >
            </div>
            <div class="w-1/6">
                <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Color:</label>
                <input name="color" type="color" id="color" @if(isset($clase)) value="{{$clase->color}}" @else value="#ffffff"  @endif  oninput="colorhex.value=value"  required>
            </div>
        </div>
        <div class="flex justify-between mb-6">
            <div class="w-full">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900">Descripcion:</label>
                <textarea name="descripcion" id="descripcion" rows="4" cols="50" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50">@if(isset($clase)) {{$clase->descripcion}} @endif</textarea>
            </div>
        </div>

        <div class="mt-10 text-center">
            @if(isset($clase))
                <input type="hidden" name="clase_id" value="{{$clase->id}}">
                <button type="submit" class="btn secondaryBtn">
                    Actualizar Clase
                </button>
            @else
                <button type="submit" class="btn secondaryBtn">
                    Añadir Clase
                </button>
            @endif
        </div>
    </form>
@endsection