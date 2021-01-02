@extends('layouts.main-base')
@php($nav = $nav ?? '')

@section('navbar')
    <li class="nav-item {{ $nav == 'Pacientes' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/pacientes') }}">
            <span class="nav-link-title">Pacientes</span>
        </a>
    </li>
    <li class="nav-item {{ $nav == 'Médicos' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/medicos') }}">
            <span class="nav-link-title">Médicos</span>
        </a>
    </li>
    <li class="nav-item {{ $nav == 'Praxias' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/praxias') }}">
            <span class="nav-link-title">Praxias</span>
        </a>
    </li>
    <li class="nav-item {{ $nav == 'Fonemas' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/consonantes') }}">
            <span class="nav-link-title">Fonemas</span>
        </a>
    </li>
    <li class="nav-item {{ $nav == 'Vocabulario' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/vocabulario') }}">
            <span class="nav-link-title">Vocabulario</span>
        </a>
    </li>
@stop
