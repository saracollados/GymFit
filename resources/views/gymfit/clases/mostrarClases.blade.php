@extends('app')

@section('title', 'Listado Clases')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Clases</h6>
  </div>
@endsection

@section('content')
    <div class="mb-14">
        <a class="btn primaryBtn" href="/crearClaseForm">
            Crear Clase
        </a>
    </div>

    {{-- @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">Ese libro no está disponible</span>
        </div>
    @endif --}}

    @if ($clases->isEmpty())
        <div class="text-center">
            <p >No hay clases registrados</p>
        </div>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded">
            <table class="w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-dark-blue uppercase bg-slate-300">
                    <tr>
                        <th class="hidden">ID</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Descripción</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @each('componentes/tableClases', $clases, 'item')
                </tbody>
            </table>
        </div>
    @endif

@endsection