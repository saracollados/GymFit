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



    {{-- @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">Ese libro no está disponible</span>
        </div>
    @endif --}}

    @yield('reservasContent')

@endsection