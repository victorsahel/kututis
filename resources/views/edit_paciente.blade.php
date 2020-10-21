@extends('layouts.main-admin')
@section('title','Asignar Médico')
@php($nav = 'Pacientes')
@php($parent_dir = url('/admin/pacientes'))

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
            <?php $id = $paciente[0]['id'] ?>
            <form action="{{ route('asign_medico',$id) }}" method="post" enctype="multipart/form-data" class="card"
                  autocomplete="off">
                @csrf

                <div class="card-header">
                    <h4 class="card-title">@yield('title')</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input type="text" required name="Nombre" readonly
                                     value="{{ $paciente[0]['Nombre'] }}">Nombre</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input type="text" required name="Apellido" readonly
                                     value="{{ $paciente[0]['Apellido'] }}">Apellido</x-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input type="email" required name="Correo" readonly
                                     value="{{ $paciente[0]['Correo'] }}">Correo</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input type="password" required name="Contrasenia" readonly
                                     value="{{ $paciente[0]['Contrasenia'] }}">Contraseña</x-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input type="text" required name="Celular" readonly
                                     value="{{ $paciente[0]['Celular'] }}">Celular</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-label required">Médico</div>
                            <div>
                                @forelse($medicos as $medico)
                                    <label class="form-check">
                                        <input class="form-check-input @error('medico_id') is-invalid @enderror" type="radio"
                                               {{ $paciente[0]['medico_id'] == $medico['id'] ? 'checked' : '' }} name="medico_id"
                                               value="{{ $medico['id'] }}">
                                        <span class="form-check-label">{{ $medico['Nombre'] }}</span>

                                        @if($loop->last)
                                            @error('medico_id')
                                            <span class="invalid-feedback is-invalid">{{$message}}</span>
                                            @enderror
                                        @endif
                                    </label>
                                @empty
                                    <span class="text-danger">Aún no hay médicos disponibles</span>
                                @endforelse
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
