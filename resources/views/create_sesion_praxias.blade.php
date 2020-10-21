@extends('layouts.main-medico')
@php($nav = 'Pacientes')
@section('title','Asignar Sesión de Praxia')
@php($parent_dir = url("/medico/veravance_praxias/{$id_medico}/{$id_user}"))

@section('content')
    <!-- Page Title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ $parent_dir }}" class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    Regresar
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('crear_sesion_praxias',$id_medico) }}" method="post" enctype="multipart/form-data"
                  class="card">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">@yield('title')</h4>
                </div>

                <div class="card-body">
                    <input type="hidden" class="form-control" id="paciente_id" name="paciente_id" value="{{$id_user}}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-label">Praxias</div>
                            <div>
                                @forelse($praxias as $praxia)
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="praxia"
                                               value="{{ $praxia['id'] }}">
                                        <span class="form-check-label">{{ $praxia['Nombre'] }}</span>
                                    </label>
                                @empty
                                    <span class="text-muted">No hay registros</span>
                                @endforelse
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <x-input type="number" required name="Repeticiones">Repeticiones</x-input>
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
