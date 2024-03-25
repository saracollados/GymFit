@extends('app')

@section('title', 'Ver Horarios')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">{{$horario->nombre}}</h6>
  </div>
@endsection

@section('content')
    @if (empty($clasesHorarioOrganizado))
        <div class="text-center">
            <p>No hay clases registradas</p>
        </div>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded">
            <table id="horario" class="w-full text-sm text-center text-gray-500 border-collapse">
                <thead class="text-xs text-black uppercase bg-slate-300">
                    <tr>
                        <th class="px-6 py-3"></th>
                        @foreach ($diasSemana as $diaSemana)
                            <th class="px-6 py-3">{{$diaSemana->nombre}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($franjasHorarias as $hora)
                        <tr class="bg-white text-black">
                            <td>{{$hora->nombre}}</td>
                            @foreach ($diasSemana as $diaSemana)
                                <td class="py-2.5">
                                    @if(isset($clasesHorarioOrganizado[$diaSemana->id][$hora->id]))
                                        @foreach($clasesHorarioOrganizado[$diaSemana->id][$hora->id] as $clase)
                                            <div class="rounded mx-1 p-1" style="background-color: {{$clase->color ?? ''}}">
                                                @if (!empty($clase->clase_nombre))
                                                    <p class="text-sm font-semibold">
                                                        {{$clase->clase_nombre}}
                                                    </p>
                                                    <p class="font-size13">{{$clase->monitor_nombre ?? ''}} | {{$clase->sala_nombre ?? ''}}</p>
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