@extends('app')

@section('title', 'Crear Reservas')

@section('header')
    <div class="flex justify-between items-center">
        <h6 class="text-base font-bold text-gray-900">Crear Reserva</h6>
    </div>
@endsection

@section('content')
    @if (empty($clasesSemanaActual))
        <div class="text-center">
            <p>No hay clases registradas</p>
        </div>
    @else
    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif (isset($success))        
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$success}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

        <div class="text-sm mb-4">
            <p class="mb-2">Usuario: <span class="font-bold">{{$usuario->nombre}}</span></p>
            <p>DNI: <span class="font-bold">{{$usuario->dni}}</span></p>
        </div>
        <div class="flex justify-end">
            <div class="flex items-center py-2.5 text-sm mb-2.5 px-4 rounded-lg bg-white custom-box-shadow-xl font-semibold text-slate-700">
                <?php 
                    $fechaDesde = $fechasSemanaActual[0][0];
                    $fechaHasta = end($fechasSemanaActual)[0];
                ?>
                <div class="py-1" style="cursor:pointer">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                
                <span class="py-1 px-4">{{$fechaDesde}} - {{$fechaHasta}}</span>
                <div class="py-1" style="cursor:pointer">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </span>
        </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded">
            <table id="horario" class="w-full text-sm text-center text-gray-500 border-collapse">
                <thead class="text-xs text-black uppercase bg-slate-300">
                    <tr>
                        <th class="px-6 py-3"></th>
                        @foreach ($fechasSemanaActual as $diaSemana)
                            <th class="px-6 pt-3 pb-2">{{$diaSemana[2]}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="px-6 py-3"></th>
                        @foreach ($fechasSemanaActual as $diaSemana)
                            <th class="px-6 pb-3 font-normal">{{substr($diaSemana[0], 0, 5)}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($franjasHorarias as $hora)
                        <tr class="bg-white text-black">
                            <td>{{$hora->nombre}}</td>
                            @foreach ($fechasSemanaActual as $diaSemana)
                                <td class="py-2.5">
                                    @if(isset($clasesSemanaActual[$diaSemana[1]][$hora->id]))
                                        @foreach($clasesSemanaActual[$diaSemana[1]][$hora->id] as $clase)
                                            <div class="rounded mx-1 p-1" style="background-color: {{ $clase->plazas['libres'] == 0 ? '#d4d4d4' : ($clase->color ?? '') }}">
                                                @if (!empty($clase->clase_nombre))
                                                    <a class="{{$clase->plazas['libres'] == 0 ? 'text-gray-500' : ''}} {{$clase->reserva_id || $clase->plazas['libres'] != 0 ? 'link-btn reserva-clase' : ''}}" style="position: relative;" data-clase="{{$clase}}" data-usuario="{{$usuario->id}}" data-reserva="{{$clase->reserva_id}}">
                                                        <p class="text-sm font-semibold">
                                                            {{$clase->clase_nombre}}
                                                        </p>
                                                        <p class="">{{$clase->monitor_nombre ?? ''}} | {{$clase->sala_nombre ?? ''}}</p>
                                                        <p style="position: absolute; top:0px; right: 0px;" class="text-xs {{ $clase->plazas['libres'] == 0 ? 'text-red-500' : '' }}">{{$clase->plazas['libres']}}/{{$clase->plazas['total']}}</p>
                                                        @if ($clase->reserva_id)
                                                            <p style="position: absolute; top:0px; left: -100%;" class="text-xs text-green-500 font-bold"><i class="fa-regular fa-circle-check"></i></p>
                                                        @endif
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="reserva-clase-modal-content"></div>
    @endif
@endsection