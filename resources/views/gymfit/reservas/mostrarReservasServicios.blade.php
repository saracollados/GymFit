@extends('layouts.reservas')

@section('reservasButton')
    <div class="mb-14">
        @if(session('userType') == 'usuario')
            <form action="{{route('crearReservaServicioForm')}}" method="POST" autocomplete='off'>
                @csrf
                <input name="dni" type="hidden" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" value="{{session('userInfo')['dni']}}">
                <button type="submit" class="btn primaryBtn">
                    Crear Reserva
                </button>
            </form>
        @else
            <a class="btn primaryBtn reservaUsuario" data-object="reserva" data-type="servicio">
                Crear Reserva
            </a>
        @endif
    </div>
@endsection

@section('reservasContent')
    <?php $routeName = Request::path();?>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10 flex justify-between" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif (isset($success))        
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-10 flex justify-between" role="alert">
            <span class="block sm:inline">{{$success}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if ($reservasServicios->isEmpty())
        <div class="text-center">
            <p >No hay servicios reservados</p>
        </div>
    @else
        <div class="relative overflow-x-auto">
            <table id="reservasServicios-table" class="w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-dark-blue uppercase bg-slate-300">
                    <tr>
                        <th class="hidden">ID</th>
                        <th class="hidden">Hora_id</th>
                        <th scope="col" class="px-6 py-3">DNI</th>
                        <th scope="col" class="px-6 py-3">Usuario</th>
                        <th scope="col" class="px-6 py-3">Servicio</th>
                        <th scope="col" class="px-6 py-3">Profesional</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Hora</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @each('componentes/tableReservasServicios', $reservasServicios, 'item')
                </tbody>
            </table>
        </div>
        @endif
    <div id="reserva-modal-content"></div>
    <div id="reserva-item-modal-content"></div>
@endsection