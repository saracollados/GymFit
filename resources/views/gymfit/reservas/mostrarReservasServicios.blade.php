@extends('layouts.reservas')

@section('reservasButton')
    <div class="mb-14">
        @if(session('userType') == 'usuario')
            <form action="{{route('crearReservaServicioForm')}}" method="POST" autocomplete='off'>
                @csrf
                <input name="dni" type="hidden" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" value={{session('userInfo')['dni']}}>
                <button type="submit" class="btn primaryBtn">
                    Crear Reserva
                </button>
            </form>
        @else
            <a class="btn primaryBtn reservaUsuario" data-object="reserva" data-userinfo="{{json_encode(session('userInfo'))}}" data-usertype="{{session('userType')}}" data-type="servicio">
                Crear Reserva
            </a>
        @endif
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
@endsection