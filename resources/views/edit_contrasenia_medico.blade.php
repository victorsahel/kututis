@extends('layouts.main-medico')
@section('title','Cambiar Contraseña')
@php($nav = 'Mis Datos')
@php($parent_dir = url('/medico/pacientesxmedico/'.$id_medico))

@section('container', 'container-tight')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12">
            <?php  $id = $medico[0]['id'] ?>
            <form action="{{ route('update_contrasenia_medico',$id) }}" method="post" enctype="multipart/form-data"
                  class="card">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">@yield('title')</h4>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <x-input type="text" required name="Correo"
                                 value="{{ $medico[0]['Correo'] }}">Correo
                        </x-input>
                    </div>
                    <div class="mb-3">
                        <x-input type="password" required name="Contraseña" value="">Nueva contraseña</x-input>
                    </div>


                    <div class="mb-3">
                        <x-input type="password" required
                                 name="Contraseña_confirmation" value="">Confirmar contraseña
                        </x-input>
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
