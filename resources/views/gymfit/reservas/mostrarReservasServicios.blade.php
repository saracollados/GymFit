@extends('layouts.reservas')

@section('reservasButton')
    <div class="mb-14">
        <a class="btn primaryBtn" href="/crearReservaServicioForm">
            Crear Reserva
        </a>
    </div>
@endsection

@section('reservasContent')
    <?php $routeName = Request::path();?>

    @if ($reservasServicios->isEmpty())
        <div class="text-center">
            <p >No hay servicios reservados</p>
        </div>
    @else
        <div class="relative overflow-x-auto">
            <table id="personal-table" class="datatable w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-dark-blue uppercase bg-slate-300">
                    <tr>
                        <th class="hidden">ID</th>
                        <th scope="col" class="px-6 py-3">DNI</th>
                        <th scope="col" class="px-6 py-3">Usuario</th>
                        {{-- <th scope="col" class="px-6 py-3">Clase</th> --}}
                        {{-- <th scope="col" class="px-6 py-3">Fecha</th> --}}
                        {{-- <th scope="col" class="px-6 py-3">Hora</th> --}}
                        {{-- <th scope="col" class="px-6 py-3">Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @each('componentes/tableReservasServicios', $reservasServicios, 'item')
                </tbody>
            </table>
        </div>
    @endif
@endsection