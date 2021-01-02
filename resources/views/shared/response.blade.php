@if(Session::has('error') || Session::has('success') || $errors->any())
{{--Modal Variables--}}
<?php
$modal['id'] = 'response-dialog';
$modal['size'] = '';
$modal['show'] = 'load';

if ($errors->any() || Session::has('error')) {
    $modal['title'] = 'Error';
    $modal['confirm'] = false;
    $modal['cancel_txt'] = 'Aceptar';
    $modal['cancel_class'] = 'btn-danger';
} else {
    $modal['title'] = 'Éxito';
    $modal['cancel'] = false;
    $modal['confirm_class'] = 'btn-success';
    if (isset($parent_dir)) {
        $modal['confirm_url'] = $parent_dir;
    }
}
?>


{{--Modal HTML Body--}}
@if($errors->any())
@section('modal-body')
    <div class="alert alert-danger">
        <h3 class="alert-heading">No ha sido posible realizar la operación</h3>
        <p>Se han encontrado los siguientes errores:</p>
        <ul class="ml-2">
            @foreach($errors->all() as $error)
                <li>{{ Str::ucfirst($error) }}</li>
            @endforeach
        </ul>
    </div>
@overwrite
@endif

@if($message = Session::get('error'))
@section('modal-body')
    <div class="alert alert-danger" role="alert">
        <h3 class="alert-heading">Error al procesar la solicitud</h3>
        <p>{{ $message }}</p>
    </div>
@overwrite
@endif


@if($message = Session::get('success'))
@section('modal-body')
    <div class="alert alert-success" role="alert">
        <h3 class="alert-heading">Guardado con éxito</h3>
        <p>{{ $message }}</p>
    </div>
@overwrite
@endif

@include('shared.confirm', [ 'modal' => $modal ])
@endif
