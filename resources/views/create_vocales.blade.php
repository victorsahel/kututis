{{-- SIN USO --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">


        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Kututis</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item ">
                <a class="nav-link" href="{{ url('/admin/pacientes') }}">Pacientes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin/medicos') }}">Medicos</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="{{ url('/admin/praxias') }}">Praxias</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="{{ url('/admin/consonantes') }}">Consonantes</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="{{ url('/admin/vocabulario') }}" >Vocabulario</a>
              </li>
            </ul>
          </div>
        </nav>
     <body>
	     <form action="{{ route('save_vocales') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
	     	{!! csrf_field() !!}
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
	        <div class="form-group">
	            <label for="nombre">Nombre</label>
	            <input type="text" class="form-control" id="Nombre" name="Nombre" value="{{ old('Nombre') }}">
	        </div>
	        <div class="form-group">
	            <label for="tipo">Tipo</label>
	            <input type="text" class="form-control" id="Tipo" name="Tipo" value="{{ old('Tipo') }}">
	        </div>
	        <div class="form-group">
	            <label for="descri">Descripción</label>
	            <input type="text" class="form-control" id="Descripcion" name="Descripcion" value="{{ old('Descripcion') }}">
	        </div>
	        <div class="form-group">
	            <label for="imagen">Imagen de Ejemplo</label>
	            <input type="file" class="form-control" id="imagen" name="imagen" value="{{ old('imagen') }}">
	        </div>
	        <button type="submit" class="btn btn-success">Crear Vocales</button>
	     </form>
     </body>
