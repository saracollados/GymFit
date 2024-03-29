@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<x-guest-layout>
    <x-slot name="logo">
        <x-authentication-card-logo />
    </x-slot>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex justify-center">
        <div class="mx-auto mb-6 flex inline-flex space-x-8 justify-center rounded-lg bg-slate-200 p-1">
            <button id="tab-usuarios" onclick="changeTab('usuarios')" type="button" class="py-2.5 text-sm my-0 px-4 rounded-lg tab tab-active">
                <span class="opacity-100">Usuarios</span>
            </button>
            <button id="tab-personal" onclick="changeTab('personal')" type="button" class="py-2.5 text-sm my-0 px-4 rounded-lg tab tab-inactive">
                <span class="opacity-100">Personal</span>
            </button>
        </div>
    </div>
    <x-authentication-card>       
        <div class="mt-3">
            <div id="form-usuarios" class="tab-content">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="user_type" value="usuarios">

                    <div class="mt-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico</label>
                        <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                    </div>
                    <div class="mt-4">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                        <input name="password" type="password" id="password" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                    </div>

                    <div class="flex items-center justify-end mt-4">
       
                        <button type="submit" class="ms-4 btn primaryBtn">
                            ENTRAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="form-personal" class="tab-content" style="display:none;">
            <form method="POST" action="{{ route('login.show') }}">
                @csrf
                <input type="hidden" name="user_type" value="personal">

                <div class="mt-4">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo electrónico</label>
                    <input name="email" type="email" id="email" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                </div>
                <div class="mt-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                    <input name="password" type="password" id="password" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="ms-4 btn primaryBtn">
                        ENTRAR
                    </button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
@endsection

@section('script')
    <script>
        function changeTab(selectedTab) {
            // Ocultar ambos contenedores de formularios
            document.getElementById('form-usuarios').style.display = 'none';
            document.getElementById('form-personal').style.display = 'none';

            // Quitar la clase 'tab-active' de todas las pestañas y añadir 'tab-inactive'
            document.querySelectorAll('.tab').forEach(function(tabElement) {
                tabElement.classList.remove('tab-active');
                tabElement.classList.add('tab-inactive');
            });

            // Mostrar el contenedor del formulario seleccionado
            document.getElementById('form-' + selectedTab).style.display = 'block';

            // Actualizar las clases del botón de la pestaña seleccionada
            document.getElementById('tab-' + selectedTab).classList.remove('tab-inactive');
            document.getElementById('tab-' + selectedTab).classList.add('tab-active');
        }
    </script>
@endsection

