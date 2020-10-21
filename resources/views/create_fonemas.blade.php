@extends('layouts.main-admin')
@section('title','Crear Fonema')
@php($nav = 'Fonemas')
@php($parent_dir = url('/admin/consonantes'))

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
            <form action="{{ route('save_fonemas') }}" method="post" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">@yield('title')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input name="Nombre" required>Nombre</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input name="Tipo" required>Tipo</x-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input name="Descripcion" required>Descripción</x-input>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-file-input name="imagen" required accept="image/png"
                                          preview="imagen_preview">Imagen de Ejemplo
                            </x-file-input>
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

            @include('shared.media-preview', ['input' => ['', 'imagen_preview' => 'imagen']])
        </div>
    </div>
@stop

@include('shared.response')
