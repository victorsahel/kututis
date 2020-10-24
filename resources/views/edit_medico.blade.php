@extends('layouts.main-admin')
@section('title','Editar Médico')
@php($nav = 'Médicos')
@php($parent_dir = url('/admin/medicos'))

@section('content')
    <!-- Page Title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ $parent_dir }}" class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    {{ $nav  }}
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <?php  $id = $medico['id'] ?>
            <form action="{{ route('update_medico',$id) }}" method="post" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">@yield('title')</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input name="Nombre" required value="{{ $medico['Nombre'] }}">Nombre</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input name="Apellido" required value="{{ $medico['Apellido'] }}">Apellido</x-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input type="email" name="Correo" required value="{{ $medico['Correo'] }}">Correo
                            </x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input type="password" name="Contrasenia" required value="{{ $medico['Contrasenia'] }}">
                                Contraseña
                            </x-input>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <x-input name="Celular" required value="{{ $medico['Celular'] }}">Celular</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-label">Habilitado</div>
                            <div>
                                @php($habilitado = $medico['Habilitado'] == 1)
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Habilitado"
                                           value="1" {{ $habilitado ? 'checked' : '' }}>
                                    <span class="form-check-label">Sí</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Habilitado"
                                           value="0" {{ $habilitado ? '' : 'checked' }}>
                                    <span class="form-check-label">No</span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer d-flex justify-content-center">
                        <div class="btn-list flex-nowrap">
                            <button type="submit" class="btn btn-secondary ml-auto">
                                @yield('title')
                            </button>
                            <a class="btn btn-primary" href="{{ $parent_dir }}">
                                Cancelar
                            </a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@stop

@include('shared.response')
