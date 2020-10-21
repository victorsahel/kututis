@extends('layouts.main-base')
@php($nav = $nav ?? '')

@section('navbar')
    <li class="nav-item {{ $nav == 'Pacientes' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url("medico/pacientesxmedico/{$id_medico}") }}">
            <span class="nav-link-title">Pacientes</span>
        </a>
    </li>
    <li class="nav-item {{ $nav == 'Mis Datos' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url("medico/edit_contrasenia_medico/{$id_medico}") }}">
            <span class="nav-link-title text-nowrap">Editar Datos</span>
        </a>
    </li>
@stop
