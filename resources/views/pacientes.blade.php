@extends('layouts.main-admin')
@section('title','Pacientes')
@php($nav = 'Pacientes')
@php($parent_dir = url()->current())

@section('content')
    <!-- Page Title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2 class="page-title">
                    @yield('title')
                </h2>
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
                        <th scope="col" width="150px">Médico</th>
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
                            @if($paciente['medico']['Nombre'] == "Sin Médico")
                                <td>
                                    <div class="btn-list flex-nowrap ml-0 pl-0">
                                        <a class="btn btn-icon btn-link" title="Asignar Médico"
                                           href=" {{ url('/admin/asignar_medico/'.$aux) }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </td>
                                    </td>
                            @else
                                <td>{{ $paciente['medico']['Nombre'] }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No existen registros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
