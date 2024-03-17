@extends('app')

@section('content')
@section('title', 'Listado Reservas')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Reservas</h6>
  </div>
@endsection



@section('content')
    <?php $routeName = Request::path();?>
    <div class="flex justify-center">
        <div class="mx-auto mb-14 flex inline-flex space-x-8 justify-center rounded-lg bg-slate-200 p-1">
            <a class="py-2.5 text-sm my-0 px-4 rounded-lg @if($routeName === 'mostrarReservasClases') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarReservasClases">
                <span class="ml-1 opacity-100">Clases</span>
            </a>
            <a class="py-2.5 text-sm my-0 px-4 rounded-lg @if($routeName === 'mostrarReservasServicios') bg-white custom-box-shadow-xl font-semibold text-slate-700 @endif" href="/mostrarReservasServicios">
                <span class="ml-1 opacity-100">Servicios</span>
            </a>
        </div>
    </div>

    @yield('reservasButton')

    @yield('reservasContent')

@endsection