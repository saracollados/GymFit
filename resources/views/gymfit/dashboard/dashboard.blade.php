@extends('app')

@section('title', 'Dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <h6 class="text-base font-bold text-gray-900">Dashboard</h6>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-6 grid-flow-row gap-1 mb-12">
        <div class="pt-2.5 px-4 my-0 mx-1.5 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Cientes activos</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$datos['n_usuarios']}}</p>   
        </div>
        <div class="pt-2.5 px-4 my-0 mx-1.5 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center">Personal activo</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$datos['n_personal']}}</p>   
        </div>
        <div class="pt-2.5 pb-4 px-4 my-0 mx-1.5 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl mes-anterior">
            <p class="text-sm font-semibold text-slate-700 text-center">Reservas clases<br>este mes</p>
            <p class="text-6xl font-semibold pt-2.5 ">{{$datos['n_reservasClasesMes']}}</p> 
            <div class="text-center leyenda">
                <p class="text-xs text-slate-300 text-center texto">vs. mes<br>anterior</p>
                <p class="text-sm numero porcentaje-signo">{{$datos['dif_reservasClases']}}%</p>
            </div>
        </div>
        <div class="pt-2.5 px-4 my-0 mx-1.5 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl mes-anterior">
            <p class="text-sm font-semibold text-slate-700 text-center">Reservas servicios<br>este mes</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4">{{$datos['n_reservasServiciosMes']}}</p>   
            <div class="text-center leyenda">
                <p class="text-xs text-slate-300 text-center texto">vs. mes<br>anterior</p>
                <p class="text-sm numero porcentaje-signo">{{$datos['dif_reservasServicios']}}%</p>
            </div>
        </div>
        <div class="pt-2.5 px-4 my-0 mx-1.5 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl mes-anterior">
            <p class="text-sm font-semibold text-slate-700 text-center">% Ocupación clases este mes</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4 porcentaje-item">{{$datos['ocupacionTotalClases']}}<span class="text-4xl">%</span></p> 
            <div class="text-center leyenda">
                <p class="text-xs text-slate-300 text-center texto">vs. mes<br>anterior</p>
                <p class="text-sm numero porcentaje-signo">{{$datos['dif_reservasClases']}}%</p>
            </div>  
        </div>
        <div class="pt-2.5 px-4 my-0 mx-1.5 flex flex-column justify-between items-center rounded-lg bg-white custom-box-shadow-xl mes-anterior">
            <p class="text-sm font-semibold text-slate-700 text-center">% Ocupación servicios este mes</p>
            <p class="text-6xl font-semibold pt-2.5 pb-4 porcentaje-item">{{$datos['ocupacionTotalServicios']}}<span class="text-4xl">%</span></p>
            <div class="text-center leyenda">
                <p class="text-xs text-slate-300 text-center texto">vs. mes<br>anterior</p>
                <p class="text-sm numero porcentaje-signo">{{$datos['dif_reservasServicios']}}%</p>
            </div>  
        </div>
    </div>
    <h3 class="text-center font-bold mb-3 uppercase">Ocupación de clases</h3>
    <div class="grid grid-cols-5 gap-12 mb-12">
        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por clase</p>
            @foreach ($datos['ocupacionClases'] as $ocupacion)
                <div class="flex justify-between">
                    <p class="text-left">{{$ocupacion[0]}}</p>
                    <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                </div>
            @endforeach
        </div>

        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por monitor</p>
            @foreach ($datos['ocupacionClasesMonitores'] as $ocupacion)
                <div class="flex justify-between">
                    <p class="text-left">{{$ocupacion[0]}}</p>
                    <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                </div>
            @endforeach
        </div>

        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por <br> día de la semana</p>
            @foreach ($datos['ocupacionClasesDiasSemana'] as $ocupacion)
                <div class="flex justify-between">
                    <p class="text-left">{{$ocupacion[0]}}</p>
                    <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                </div>
            @endforeach
        </div>

        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl col-span-2">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por franjas horarias</p>

            <div class="grid grid-cols-2 grid-rows-1 gap-12">
                @php
                    $halfCount = count($datos['ocupacionClasesFranjasHorarias']) / 2;
                    $firstHalf = array_slice($datos['ocupacionClasesFranjasHorarias'], 0, $halfCount);
                    $secondHalf = array_slice($datos['ocupacionClasesFranjasHorarias'], $halfCount);
                @endphp

                <div class="px-16">
                    @foreach ($firstHalf as $ocupacion)
                        <div class="flex justify-between">
                            <p class="text-left">{{$ocupacion[0]}}</p>
                            <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="px-16">
                    @foreach ($secondHalf as $ocupacion)
                        <div class="flex justify-between">
                            <p class="text-left">{{$ocupacion[0]}}</p>
                            <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center font-bold mb-3 uppercase">Ocupación de servicios</h3>
    <div class="grid grid-cols-5 gap-12">
        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por servicio</p>
            @foreach ($datos['ocupacionServicios'] as $ocupacion)
                <div class="flex justify-between">
                    <p class="text-left">{{$ocupacion[0]}}</p>
                    <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                </div>
            @endforeach
        </div>

        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por profesional</p>
            @foreach ($datos['ocupacionServiciosProfesionales'] as $ocupacion)
                <div class="flex justify-between">
                    <p class="text-left">{{$ocupacion[0]}}</p>
                    <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                </div>
            @endforeach
        </div>

        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por <br> día de la semana</p>
            @foreach ($datos['ocupacionServiciosDiasSemana'] as $ocupacion)
                <div class="flex justify-between">
                    <p class="text-left">{{$ocupacion[0]}}</p>
                    <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                </div>
            @endforeach
        </div>

        <div class="py-2.5 px-4 m-0 rounded-lg bg-white custom-box-shadow-xl col-span-2">
            <p class="text-sm font-semibold text-slate-700 text-center mb-4">% Ocupación por franjas horarias</p>

            <div class="grid grid-cols-2 grid-rows-1 gap-12">
                @php
                    $halfCount = count($datos['ocupacionServiciosFranjasHorarias']) / 2;
                    $firstHalf = array_slice($datos['ocupacionServiciosFranjasHorarias'], 0, $halfCount);
                    $secondHalf = array_slice($datos['ocupacionServiciosFranjasHorarias'], $halfCount);
                @endphp

                <div class="px-16">
                    @foreach ($firstHalf as $ocupacion)
                        <div class="flex justify-between">
                            <p class="text-left">{{$ocupacion[0]}}</p>
                            <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="px-16">
                    @foreach ($secondHalf as $ocupacion)
                        <div class="flex justify-between">
                            <p class="text-left">{{$ocupacion[0]}}</p>
                            <p class="text-right porcentaje-item">{{$ocupacion[1]}}%</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection