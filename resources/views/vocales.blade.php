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
              <li class="nav-item active">
                <a class="nav-link" href="{{ url('/admin/vocales') }}">Vocales</a>
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
        <a type="button" class=" mx-5 btn btn-primary" href="{{ url('/admin/crear_vocales') }}"  >Agregar Vocales</a>
    <body>
        <div class="mx-5 flex-center position-ref full-height">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Descripción</th>
                </tr>
              </thead>
              <tbody>
            @forelse($vocales as $vocal)
                <tr>
                  <?php $aux = $vocal['id'] ?>
                  <td>{{ $vocal['id'] }}</td>
                  <td>{{ $vocal['Nombre'] }}</td>
                  <td>{{ $vocal['Tipo'] }}</td>
                  <td>{{ $vocal['Descripcion'] }}</td>
                  <td><img width="100" height="80" src="{{ env('APP_URL').'/web-kututis/storage/app/public/vocal_'.$vocal['Nombre'].'.png'}} "></td>
                  <td><a href=" {{ url('/admin/editar_vocales/'.$aux) }} ">Editar</a></td>
                  <td><a href="{{ url('/admin/destroy_vocal/'.$aux) }}" style="color:red">Eliminar</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No existen registros</td>
                </tr>
            @endforelse
              </tbody>
            </table>
        </div>
    </body>
</html>
