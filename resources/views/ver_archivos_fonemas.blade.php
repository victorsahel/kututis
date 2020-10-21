@extends('layouts.main-medico')
@section('title', 'Ver audio de fonema enviado')
@php($nav = 'Pacientes')
@php($parent_dir =  url("medico/lista_archivos_fonemas/{$id_medico}/{$id_user}/{$id_sesion_fonema}"))

@section('container','container-narrow')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{$parent_dir}}"
                   class="page-title d-flex align-items-center">
                    <span class="material-icons text-primary">navigate_before</span>
                    Regresar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header justify-content-between">
                    @switch($archivos_sesion_fonemas[0]['Aprobado'])
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
                    @if($archivos_sesion_fonemas[0]['Pendiente_x_Revisar'] == 1)
                        <div class="btn-list flex-nowrap">
                            <a class="btn btn-secondary btn-block" href="javascript:void(0)"
                               onclick="openConfirm('{{ url("/medico/evaluar_archivo_sesion_fonema/".$archivos_sesion_fonemas[0]["id"]."/".$archivos_sesion_fonemas[0]["sesion_fonema_id"]."/2/".$id_medico) }}', 'aprobar')">
                                Aprobar
                            </a>
                            <a class="btn btn-primary btn-block" href="javascript:void(0)"
                               onclick="openConfirm('{{ url("/medico/evaluar_archivo_sesion_fonema/".$archivos_sesion_fonemas[0]["id"]."/".$archivos_sesion_fonemas[0]["sesion_fonema_id"]."/1/".$id_medico) }}', 'desaprobar')">
                                Desaprobar
                            </a>
                        </div>
                    @endif
                </div>

                <div class="card-body">

                </div>
                <div class="media-player">
                    <audio id="player" controls>
                        <source src="{{ 'data:image/mp3;base64,'.$archivos_sesion_fonemas[0]['archivo'] }} " type="audio/mp3">
                    </audio>
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
