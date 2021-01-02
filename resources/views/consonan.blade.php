@extends('layouts.main-admin')
@section('title','Fonemas')
@php($nav = 'Fonemas')
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
                <a href="{{ url('/admin/crear_fonemas') }}" class="btn btn-primary ml-3 d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Agregar Fonema
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
                        <th scope="col">Tipo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Imagen</th>
                        <th scope="col" width="150px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($fonemas as $fonema)
                        <tr>
                            <?php $aux = $fonema['id'] ?>
                            <td>{{ $fonema['id'] }}</td>
                            <td>{{ $fonema['Nombre'] }}</td>
                            <td>{{ $fonema['Tipo'] }}</td>
                            <td>{{ $fonema['Descripcion'] }}</td>
                            <td><img
                                    src="{{ asset('storage/'.$fonema['img_path']) }}">
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap justify-content-end">
                                    <a href="{{ url('/admin/editar_fonemas/'.$aux) }}"
                                       class="btn btn-icon btn-link row-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a class="btn btn-icon btn-link row-remove" title="Eliminar"
                                       href="javascript:void(0)"
                                       onclick="openConfirm('{{url('/admin/destroy_fonema/'.$aux)}}')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
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

@include('shared.confirm')
