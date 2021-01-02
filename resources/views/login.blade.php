@extends('layouts.minimal')
@section('title', 'Iniciar Sesión')

@section('body_class', 'bg-secondary')

@section('content')
    <div class="flex-fill d-flex flex-column justify-content-center">
        <div class="container-tight"style="max-width: 35rem">
            <div class="text-center">
            <span class="navbar-brand navbar-brand-autodark pr-0 no-select">
                <img class="navbar-brand-image" style="height: 6rem; z-index: 1; position: relative; top: 5rem;" src="{{asset('/img/logo.png')}}">
            </span>
            </div>
            <form action="{{ route('login_evaluate') }}" method="post" enctype="multipart/form-data"
                  class="card card-md px-4">
                @csrf
                <div class="card-body pt-6 pb-5">
                    <h2 class="my-3">Ingresa a tu cuenta</h2>
                    <div class="mb-3">
                        <x-input type="email" name="Correo" required>Correo</x-input>
                    </div>
                    <div class="mb-2">
                        <x-input type="password" name="Contrasenia" required>Contraseña</x-input>
                    </div>

{{--                    <div class="mb-2">--}}
{{--                        <label class="form-check">--}}
{{--                            <input type="checkbox" class="form-check-input"/>--}}
{{--                            <span class="form-check-label">Recuerdame</span>--}}
{{--                        </label>--}}
{{--                    </div>--}}

                    <div class="form-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-6">Iniciar Sesión</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@include('shared.response')
