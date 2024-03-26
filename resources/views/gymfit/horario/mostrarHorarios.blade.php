@extends('app')

@section('title', 'Listado Horarios')

@section('header')
  <div class="flex justify-between items-center">
    <h6 class="text-base font-bold text-gray-900">Horarios</h6>
  </div>
@endsection

@section('content')
    <div class="mb-14">
        <a class="btn primaryBtn crear-horario" data-object="horario">
            Crear Horario
        </a>
    </div>

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

    @if (empty($horarios))
        <div class="text-center">
            <p>No hay horarios registrados</p>
        </div>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded">
            <table id="horario" class="w-full text-sm text-center text-gray-500 border-collapse">
                <thead class="text-xs text-dark-blue uppercase bg-slate-300">
                    <tr>
                        <th class="hidden">ID</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Validez</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @each('componentes/tableHorarios', $horarios, 'item')
                </tbody>
            </table>
        </div>
        <div id="horario-modal-content"></div>
    @endif
@endsection