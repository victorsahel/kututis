@extends('layouts.main-medico')
@section('title', 'Envios de praxias ')
@php($nav = 'Pacientes')
@php($parent_dir = url("medico/veravance_praxias/{$id_medico}/{$id_user}"))

@section('content')
    <!-- Page Title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ $parent_dir }}" class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    Sesiones de Praxias
                </a>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Sesión de Praxia "{{$praxia['Nombre']}}" de "{{$paciente['Nombre'].' '.$paciente['Apellido']}}"
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Evaluación</th>
                        <th scope="col" width="150px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($archivos_sesion_praxias as $archivos_sesion_praxia)
                        <tr>
                            <td>{{ $archivos_sesion_praxia['id'] }}</td>
                            <td>{{ $archivos_sesion_praxia['Fecha'] }}</td>
                            @if($archivos_sesion_praxia['Aprobado'] == 0)
                                <td>No revisado</td>
                            @endif
                            @if($archivos_sesion_praxia['Aprobado'] == 1)
                                <td>Desaprobado</td>
                            @endif
                            @if($archivos_sesion_praxia['Aprobado'] == 2)
                                <td>Aprobado</td>
                            @endif
                            <td>
                                <div class="btn-list flex-nowrap justify-content-end">
                                    <a type="button"
                                       href="{{ url("medico/ver_archivos_praxias/{$id_medico}/{$id_user}/{$praxia['id']}/{$id_sesion_praxia}/{$archivos_sesion_praxia['id']}")  }}"
                                       class="btn btn-icon btn-link btn-lg" title="Revisar Envio">
                                        <i class="fas fa-file-signature"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No existen envios</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
