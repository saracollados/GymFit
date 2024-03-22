@extends('app')

@section('title', 'Horario Servicios')

@section('header')
    <div class="flex justify-between items-center">
        <h6 class="text-base font-bold text-gray-900">Añadir Servicio</h6>
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

    <form action="{{route('crearServicioHorario')}}" method="POST" autocomplete='off' class="mb-16">
        @csrf
        
        <div class="flex justify-between mb-6">
            <div class="w-3/12">
                <label for="profesional_id" class="block mb-2 text-sm font-medium text-gray-900">Profesional:</label>
                <select name="profesional_id" id="profesional_id" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" required>
                    <option value="" selected disabled>Seleccione un profesional</option>
                    @foreach ($profesionales as $profesional)
                        <option value="{{$profesional->id}}">{{$profesional->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-3/12">
                <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900">Fecha:</label>
                <input type="date" name="fecha" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50" min="<?php echo date('Y-m-d'); ?>" required>
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
        </div>
        <input type="hidden" name="fechaInicioSemana" value="{{ $fechasSemanaActual[0][0] }}">

        <div class="mt-10 text-center">
            <button type="submit" class="btn secondaryBtn">
                Añadir Servicio
            </button>
        </div>
    </form>


    <div class="flex justify-between">
        <p class="mb-4 text-sm">Para eliminar un servicio, pulsa sobre él.</p>

        <div class="flex items-center py-2.5 text-sm mb-2.5 px-4 rounded-lg bg-white custom-box-shadow-xl font-semibold text-slate-700">
            <?php 
                $fechaDesde = $fechasSemanaActual[0][0];
                $fechaHasta = end($fechasSemanaActual)[0];
                $fechaInicioSemanaSiguiente = $fechasSemanaSiguiente[0][0];
                $fechaInicioSemanaAnterior = $fechasSemanaAnterior[0][0];
            ?>             
            <a class="py-1" href="{{ route('mostrarHorariosServicios', ['inicioSemana' => $fechaInicioSemanaAnterior]) }}">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <span class="py-1 px-4">{{$fechaDesde}} - {{$fechaHasta}}</span>
            <a class="py-1" href="{{ route('mostrarHorariosServicios', ['inicioSemana' => $fechaInicioSemanaSiguiente]) }}">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
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
                        @foreach ($diasSemana as $diaSemana)
                            <td class="py-2.5">
                                @if(isset($serviciosSemanaActual[$diaSemana->id][$hora->id]))
                                    @foreach($serviciosSemanaActual[$diaSemana->id][$hora->id] as $servicio)
                                        <div class="rounded mx-1 p-1 @if($servicio->role_id == '3') bg-emerald-300 @elseif($servicio->role_id == '4') bg-cyan-300 @endif" style="background-color: {{$servicio->pasada ? '#d4d4d4' : '' }}">
                                            @if (!empty($servicio->role_nombre))
                                                <a class="{{$servicio->pasada ? 'text-gray-500' : 'link-btn eliminar-itemHorario'}}" data-id="{{$servicio->id}}" data-type="servicio" data-fecha="{{$fechasSemanaActual[0][0]}}">
                                                    <p class="text-sm font-semibold">
                                                        {{$servicio->role_nombre}}
                                                    </p>
                                                    <p class="font-size13">{{$servicio->profesional_nombre ?? ''}}</p>
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
@endsection