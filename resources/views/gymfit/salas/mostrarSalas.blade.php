@extends('app')

@section('title', 'Listado Salas')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Salas</h6>
  </div>
@endsection

@section('content')
    <div class="mb-14">
        <a class="btn primaryBtn" href="/crearSalaForm">
            Crear Sala
        </a>
    </div>

    {{-- @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">Ese libro no está disponible</span>
        </div>
    @endif --}}

    @if ($salas->isEmpty())
        <div class="text-center">
            <p >No hay salas registrados</p>
        </div>
    @else
        <div class="relative overflow-x-auto">
            <table id="salas-table" class="datatable w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-dark-blue uppercase bg-slate-300">
                    <tr>
                        <th class="hidden">ID</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Aforo</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @each('componentes/tableSalas', $salas, 'item')
                </tbody>
            </table>
        </div>
    @endif
@endsection
