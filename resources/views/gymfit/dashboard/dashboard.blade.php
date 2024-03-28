@extends('app')

@section('title', 'Dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <h6 class="text-base font-bold text-gray-900">Dashboard</h6>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-6 grid-flow-row gap-4">
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Usuarios activos</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$n_usuarios}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Personal activo</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$n_personal}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Reservas clases<br>este mes</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$n_reservasClasesMes}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Reservas servicios<br>este mes</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$n_reservasServiciosMes}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center"></p>
            <p class="text-6xl font-semibold pt-2.5 pb-4"></p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center"></p>
            <p class="text-6xl font-semibold pt-2.5 pb-4"></p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center"></p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$dif_reservasClases}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center"></p>
            <p class="text-6xl font-semibold pt-2.5 pb-4"></p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Reservas clases<br>mes pasado</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$n_reservasClasesMesAnterior}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Reservas servicios<br>mes pasado</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$n_reservasServiciosMesAnterior}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center"></p>
            <p class="text-6xl font-semibold pt-2.5 pb-4"></p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-4 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center"></p>
            <p class="text-6xl font-semibold pt-2.5 pb-4"></p>   
        </div>
    </div>
@endsection