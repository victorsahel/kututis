@extends('layouts.minimal')

@section('header')
    <header class="navbar navbar-expand-md navbar-dark bg-secondary">
        <div class="container-xl">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- LOGO -->
            <a class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3"
               href="{{ url()->current().'#' }}">
                <img class="navbar-brand-image" src="{{asset('img/logo.png')}}" alt="logo">
            </a>

            <!-- NAVBAR -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="w-100"></div>
                <ul class="navbar-nav">
                    @section('navbar')
                    @show
                </ul>
            </div>

            <div class="navbar-nav flex-row order-md-last">
                <a class="nav-link" href="{{url('/logout')}}">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </header>
@stop

@section('user_info')
    {{--                <div class="nav-item dropdown d-none d-md-flex mr-3">--}}
    {{--                    <a href="#" class="nav-link px-0" data-toggle="dropdown" tabindex="-1">--}}
    {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>--}}
    {{--                        <span class="badge bg-red"></span>--}}
    {{--                    </a>--}}
    {{--                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-card">--}}
    {{--                        <div class="card">--}}
    {{--                            <div class="card-body">--}}
    {{--                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}


    {{--                <div class="nav-item dropdown">--}}
    {{--                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">--}}
    {{--                        --}}{{--                        <span class="avatar" style="background-image: url(./static/avatars/000m.jpg)"></span>--}}
    {{--                        <div class="d-none d-xl-block pl-2">--}}
    {{--                            <div>ID: {{Jwt::getUserId()}}</div>--}}
    {{--                            <div class="mt-1 small text-muted">{{ Jwt::getMainRole() }}</div>--}}
    {{--                        </div>--}}
    {{--                    </a>--}}
    {{--                    <div class="dropdown-menu dropdown-menu-right">--}}
    {{--                        <a class="dropdown-item" href="{{url('/logout')}}">--}}
    {{--                            Cerrar Sesión</a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
@stop
