@extends('layouts.main-admin')
@section('title','Médicos')
@php($nav = 'Médicos')
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
            <div class="col-auto ml-auto d-print-none">
                <a href="{{ url('/admin/crear_medicos') }}" class="btn btn-primary ml-3 d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Agregar Médico
                </a>
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
                        <th scope="col">Habilitado</th>
                        <th scope="col" width="150px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($medicos as $medico)
                        <?php $habilitado = $medico['Habilitado']==1 ?>
                        <tr>
                            <?php $aux = $medico['id'] ?>
                            <td>{{ $medico['id'] }}</td>
                            <td>{{ $medico['Nombre'] }}</td>
                            <td>{{ $medico['Apellido'] }}</td>
                            <td>{{ $medico['Correo'] }}</td>
                            <td>{{ $medico['Celular'] }}</td>
                            @if($medico['Habilitado']==1)
                                <td><a href="{{url()->current().'#'}}"
                                       onclick="openConfirm('{{ url("/admin/deshabilitar_medico/".$aux)}}', 'deshabilitar')">Deshabilitar</a>
                                </td>
                            @else
                                <td><a href="{{url()->current().'#'}}"
                                       onclick="openConfirm('{{ url("/admin/habilitar_medico/".$aux) }}', 'habilitar')">Habilitar</a>
                                </td>
                            @endif
                            <td>
                                <div class="btn-list flex-nowrap justify-content-end">
                                    <a href="{{ url('/admin/editar_medico/'.$aux) }}"
                                       class="btn btn-icon btn-link row-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No existen registros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@stop

<?php
$modal['title'] = 'Cambiar Estado';
$modal['info'] = 'a este médico';
?>
@include('shared.confirm', [ 'modal' => $modal ])
