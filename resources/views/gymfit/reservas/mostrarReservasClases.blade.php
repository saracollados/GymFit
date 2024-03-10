@extends('layouts.reservas')

@section('reservasButton')
    <div class="mb-14">
        <a class="btn primaryBtn reservaUsuario" data-object="reserva">
            Crear Reserva
        </a>
    </div>
@endsection

@section('reservasContent')
    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if ($reservasClases->isEmpty())
        <div class="text-center">
            <p >No hay clases reservadas</p>
        </div>
    @else
        <div class="relative overflow-x-auto">
            <table id="personal-table" class="datatable w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-dark-blue uppercase bg-slate-300">
                    <tr>
                        <th class="hidden">ID</th>
                        <th scope="col" class="px-6 py-3">DNI</th>
                        <th scope="col" class="px-6 py-3">Usuario</th>
                        <th scope="col" class="px-6 py-3">Clase</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Hora</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @each('componentes/tableReservasClases', $reservasClases, 'item')
                </tbody>
            </table>
        </div>
        <div id="reserva-modal-content"></div>
    @endif
@endsection