@extends('layouts.main-medico')
@section('title', 'Avance de Palabras')
@php($nav = 'Pacientes')
@php($parent_dir = url('/medico/pacientesxmedico/'.$id_medico))

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ $parent_dir }}"
                   class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    Mis Pacientes
                </a>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <a href="{{ url('medico/create_sesion_vocabuario/'.$id_medico.'/'.$id_user) }}"
                   class="btn btn-primary ml-3 d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Agregar Sesión de Palabra
                </a>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Sesión de Vocabulario de "{{$paciente['Nombre'].' '.$paciente['Apellido']}}"
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Palabra</th>
                        <th scope="col">Intentos Buenos</th>
                        <th scope="col">Intentos Malos</th>
                        <th scope="col">Intentos por Revisar</th>
                        <th scope="col">Repeticiones Asignadas</th>
                        <th scope="col">Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sesion_vocabularios as $sesion_vocabulario)
                        <tr>
                            <td>{{ $sesion_vocabulario['vocabulario']['Palabra'] }}</td>
                            <td>{{ $sesion_vocabulario['Intentos_Buenos'] }}</td>
                            <td>{{ $sesion_vocabulario['Intentos_Malos'] }}</td>
                            <td>{{ $sesion_vocabulario['Intentos_x_Revisar'] }}</td>
                            <td>{{ $sesion_vocabulario['Repeticiones'] }}</td>
                            <td>
                                <label class="form-check">
                                    <?php $params = ['id_sesion_vocabulario' => $sesion_vocabulario['id'], 'id_medico' => $id_medico, 'id_user' => $id_user, 'completado' => $sesion_vocabulario['completado']] ?>
                                    @if($sesion_vocabulario['completado'] === 1)
                                        <input class="form-check-input" type="checkbox"
                                               checked
                                               onclick="checkElement(this, '{{ route("medico.pacientes.vocabulario.estado", $params) }}', 'marcar como no completado')">
                                        <span class="form-check-label">Completado</span>
                                    @else
                                        <input class="form-check-input" type="checkbox"
                                               onclick="checkElement(this, '{{ route("medico.pacientes.vocabulario.estado", $params) }}', 'marcar como completado')">
                                        <span class="form-check-label">No completado</span>
                                    @endif
                                </label>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>No existen registros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

<?php
$modal['title'] = 'Cambiar Estado';
$modal['info'] = '';
$modal['show'] = 'check';
?>
@include('shared.confirm')
