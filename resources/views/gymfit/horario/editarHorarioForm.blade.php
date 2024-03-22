@extends('app')

@section('title', 'Editar Horario')

@section('header')
    <div class="flex justify-between items-center">
        <h6 class="text-base font-bold text-gray-900">Editar <?= $horario->nombre ?></h6>
        <button type="submit" class="btn secondaryBtn">
            Guardar Horario
        </button>
    </div>
@endsection

@section('content')
    <?php 
        $error = session('error');
        $success = session('success');
    ?>

    @if ($error != '')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$error}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @elseif ($success != '')        
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-10" role="alert">
            <span class="block sm:inline">{{$success}}</span>
            <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <form action="{{route('crearClaseHorario')}}" method="POST" autocomplete='off' class="mb-16">
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-3/12">
                <label for="clase_id" class="block mb-2 text-sm font-medium text-gray-900">Clase:</label>
                <select name="clase_id" id="clase_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected disabled>Seleccione clase</option>
                    @foreach ($clases as $clase)
                        <option value="{{$clase->id}}">{{$clase->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-3/12">
                <label for="monitor_id" class="block mb-2 text-sm font-medium text-gray-900">Monitor:</label>
                <select name="monitor_id" id="monitor_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected disabled>Seleccione un monitor</option>
                    @foreach ($monitores as $monitor)
                        <option value="{{$monitor->id}}">{{$monitor->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-between mb-6">
            <div class="w-3/12">
                <label for="dia_semana_id" class="block mb-2 text-sm font-medium text-gray-900">Día de la semana:</label>
                <select name="dia_semana_id" id="dia_semana_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected disabled>Seleccione día de la semana</option>
                    @foreach ($diasSemana as $diaSemana)
                        <option value="{{$diaSemana->id}}">{{$diaSemana->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-3/12">
                <label for="franja_horaria_id" class="block mb-2 text-sm font-medium text-gray-900">Hora:</label>
                <select name="franja_horaria_id" id="franja_horaria_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected disabled>Seleccione hora</option>
                    @foreach ($franjasHorarias as $franjaHoraria)
                        <option value="{{$franjaHoraria->id}}">{{$franjaHoraria->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-3/12">
                <label for="sala_id" class="block mb-2 text-sm font-medium text-gray-900">Sala:</label>
                <select name="sala_id" id="sala_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected disabled>Seleccione sala</option>
                    @foreach ($salas as $sala)
                        <option value="{{$sala->id}}">{{$sala->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <input type="hidden" name="horario_id" value="{{$horario->id}}">

        <div class="mt-10 text-center">
            <button type="submit" class="btn secondaryBtn">
                Añadir Clase
            </button>
        </div>
    </form>

    @if (empty($clasesHorarioOrganizado))
        <div class="text-center">
            <p>No hay clases registradas</p>
        </div>
    @else
        <p class="mb-4 text-sm">Para eliminar una clase, pulsa sobre ella.</p>
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
                                                    <a class="link-btn eliminar-itemHorario" data-id="{{$clase->id}}" data-type="clase">
                                                        <p class="text-sm font-semibold">
                                                            {{$clase->clase_nombre}}
                                                        </p>
                                                        <p class="font-size13">{{$clase->monitor_nombre ?? ''}} | {{$clase->sala_nombre ?? ''}}</p>
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
        <div id="horario-modal-content"></div>
    @endif
@endsection