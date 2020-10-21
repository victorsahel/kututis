@extends('layouts.main-medico')
@section('title','Mis Pacientes')
@php($nav = 'Pacientes')
@php($parent_dir = url()->current())

@section('content')
    <!-- Page Title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="page-pretitle">
                    Bienvenido {{$medico['Nombre'] }}
                </div>
                <h1>
                    Lista de Pacientes
                </h1>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Celular</th>
                        <th scope="col" class="w-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <?php $aux = $paciente['id'] ?>
                            <td>{{ $paciente['id'] }}</td>
                            <td>{{ $paciente['Nombre'] }}</td>
                            <td>{{ $paciente['Apellido'] }}</td>
                            <td>{{ $paciente['Correo'] }}</td>
                            <td>{{ $paciente['Celular'] }}</td>
                            <td class="text-center">
                                <div class="btn-list flex-nowrap">
                                    <div class="dropdown position-static">
                                        <button class="btn btn-ghost-primary btn-sm dropdown-toggle align-text-top"
                                                data-boundary="viewport" data-toggle="dropdown" aria-expanded="false">
                                            Ver
                                            Avances
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                               href="{{ url('/medico/veravance_praxias/'.$id_medico.'/'.$aux) }}">
                                                Praxias
                                            </a>
                                            <a class="dropdown-item"
                                               href="{{ url('/medico/veravance_fonema/'.$id_medico.'/'.$aux) }}">
                                                Fonemas
                                            </a>
                                            <a class="dropdown-item"
                                               href="{{ url('/medico/veravance_vocabulario/'.$id_medico.'/'.$aux) }}">
                                                Vocabularios
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay pacientes asignados</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
