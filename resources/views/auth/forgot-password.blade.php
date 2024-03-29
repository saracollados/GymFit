@extends('layouts.auth')

@section('title', '')

@section('content')
<x-guest-layout>
    <x-authentication-card>
        <div class="mb-4 text-sm text-gray-600">
            ¿Has olvidado tu contraseña? No te preocupes, indícanos tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña, lo que te permitirá elegir una nueva.
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="Correo electrónico" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="ms-4 btn primaryBtn">
                    Enviar link
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
@endsection