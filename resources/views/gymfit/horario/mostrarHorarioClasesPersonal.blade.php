@extends('app')

@section('title', 'Mi horario')

@section('header')
    <div class="flex justify-between items-center">
        <h6 class="text-base font-bold text-gray-900">Mi horario</h6>
    </div>
@endsection

@section('content')
    @if (empty($clasesSemanaActual))
        <div class="text-center">
            <p>No tienes clases esta semana</p>
        </div>
    @else
        <div class="flex justify-end">
            <div class="flex items-center py-2.5 text-sm mb-2.5 px-4 rounded-lg bg-white custom-box-shadow-xl font-semibold text-slate-700">
                <?php 
                    $fechaDesde = $fechasSemanaActual[0][0];
                    $fechaHasta = end($fechasSemanaActual)[0];
                    $fechaInicioSemanaSiguiente = $fechasSemanaSiguiente[0][0];
                    $fechaInicioSemanaAnterior = $fechasSemanaAnterior[0][0];
                ?>
                <form action="{{route('mostrarHorarioPersonalClases')}}" method="POST" autocomplete='off'>
                    @csrf
                    
                    <input type="hidden" name="inicioSemana" value="{{$fechaInicioSemanaAnterior}}">
                    <button type="submit" class="py-1">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </form>
                <span class="py-1 px-4">{{$fechaDesde}} - {{$fechaHasta}}</span>
                <form action="{{route('mostrarHorarioPersonalClases')}}" method="POST" autocomplete='off'>
                    @csrf
                    
                    <input type="hidden" name="inicioSemana" value="{{$fechaInicioSemanaSiguiente}}">
                    <button type="submit" class="py-1">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </form>
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
                                            <div class="rounded mx-1 p-1" style="background-color: {{$clase->color}}">
                                                @if (!empty($clase->clase_nombre))
                                                    <a style="position: relative;">
                                                        <p class="text-sm font-semibold">
                                                            {{$clase->clase_nombre}}
                                                        </p>
                                                        <p class="">{{$clase->monitor_nombre ?? ''}} | {{$clase->sala_nombre ?? ''}}</p>
                                                        <p style="position: absolute; top:0px; right: 0px;" class="text-xs {{ $clase->plazas['libres'] == 0 ? 'text-red-500' : '' }}">{{$clase->plazas['libres']}}/{{$clase->plazas['total']}}</p>
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
    @endif
@endsection
