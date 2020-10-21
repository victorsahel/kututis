@extends('layouts.main-admin')
@section('title', 'Vocabulario')
@php($nav = 'Vocabulario')
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
                <a href="{{ url('/admin/crear_vocabulario') }}" class="btn btn-primary ml-3 d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Agregar Palabra
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
                        <th scope="col">Palabra</th>
                        <th scope="col">Fonema</th>
                        <th scope="col">Imagen</th>
                        <th scope="col" width="150px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($vocabulario as $vocabular)
                        <tr>
                            <?php $aux = $vocabular['id'] ?>
                            <td>{{ $vocabular['id'] }}</td>
                            <td>{{ $vocabular['Palabra'] }}</td>
                            <td>{{ $vocabular['fonema']['Nombre'] }}</td>
                            <td><img
                                    src="{{ asset('storage/'.$vocabular['img_path']) }}">
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap justify-content-end">
                                    <a href="{{ url('/admin/editar_vocabulario/'.$aux) }}"
                                       class="btn btn-icon btn-link row-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a class="btn btn-icon btn-link row-remove" href="javascript:void(0)" title="Eliminar"
                                       onclick="openConfirm('{{ url("/admin/destroy_vocabulario/".$aux) }}')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No existen registros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@include('shared.confirm')
