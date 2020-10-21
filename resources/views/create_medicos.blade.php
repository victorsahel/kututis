@extends('layouts.main-admin')
@section('title','Crear Médico')
@php($nav = 'Médicos')
@php($parent_dir = url('/admin/medicos'))

@section('content')
    <!-- Page Title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ $parent_dir }}" class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    {{ $nav }}
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('save_medico') }}" method="post" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">@yield('title')</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input name="Nombre" required>Nombre</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input name="Apellido" required>Apellido</x-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input type="email" name="Correo" required>Correo</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input type="password" name="Contrasenia" required>Contraseña</x-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input name="Celular" required>Celular</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-label">Habilitado</div>
                            <div>
                                <x-radio-button name="Habilitado" value="1" selected="{{ old('Habilitado') }}">Sí
                                </x-radio-button>
                                <x-radio-button name="Habilitado" value="0" selected="{{ old('Habilitado') }}">No
                                </x-radio-button>
                                @error('Habilitado')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-footer d-flex justify-content-center">
                    <div class="btn-list flex-nowrap">
                        <a class="btn btn-primary" href="{{ $parent_dir }}">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-secondary ml-auto">
                            @yield('title')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@include('shared.response')
