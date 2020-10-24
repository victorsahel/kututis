@extends('layouts.main-medico')
@section('title', 'Ver video de praxia enviado')
@php($nav = 'Pacientes')
@php($parent_dir = url("medico/lista_archivos_praxias/{$id_medico}/{$id_user}/{$id_praxia}/{$id_sesion_praxia}"))

@section('container','container-narrow')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{$parent_dir}}"
                   class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    Envios de Praxias
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header justify-content-between">
                    @switch($archivos_sesion_praxias['Aprobado'])
                        @case(0)
                        <?php $archivo_estado = 'No revisado'?>
                        @break
                        @case(1)
                        <?php $archivo_estado = 'Desaprobado'?>
                        @break
                        @case(2)
                        <?php $archivo_estado = 'Aprobado'?>
                        @break
                    @endswitch
                    <h3 class="card-title text-nowrap" data-toggle="tooltip" title="{{$archivo_estado}}"
                        data-placement="right">
                        @yield('title')
                    </h3>
                    @if($archivos_sesion_praxias['Pendiente_x_Revisar'] == 1)
                        <div class="btn-list flex-nowrap">
                            <a class="btn btn-secondary btn-block" href="javascript:void(0)"
                               onclick="openConfirm('{{ url("/medico/evaluar_archivo_sesion_praxia/".$archivos_sesion_praxias["id"]."/".$archivos_sesion_praxias["sesion_praxia_id"]."/2/".$id_medico) }}', 'aprobar')">
                                Aprobar
                            </a>
                            <a class="btn btn-primary btn-block" href="javascript:void(0)"
                               onclick="openConfirm('{{ url("/medico/evaluar_archivo_sesion_praxia/".$archivos_sesion_praxias["id"]."/".$archivos_sesion_praxias["sesion_praxia_id"]."/1/".$id_medico) }}', 'desaprobar')">
                                Desaprobar
                            </a>
                        </div>

                    @endif
                </div>

                <div class="media-player">
                    <video id="player" playsinline controls width="100%">
                        <source src="{{ 'data:image/mp4;base64,' .$archivos_sesion_praxias['archivo'] }} " type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@stop

<?php
$modal['info'] = 'este envio';
?>
@include('shared.confirm')
@include('shared.plyr')
