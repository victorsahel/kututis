<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kututis - @yield('title')</title>

    @section('links')
    @show
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/kututis.css') }}">
</head>
<body class="antialiased @yield('body_class')" @yield('body_style')>
    @yield('header')

<div class="content " >
    <div class="@yield('container','container-xl')">
        @yield('content')
    </div>
</div>

<footer class="footer footer-transparent">
    <div class="container">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ml-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="" class="link-secondary"></a></li>
                    <li class="list-inline-item"><a href="" class="link-secondary"></a></li>
                    <li class="list-inline-item"><a href="" target="_blank" class="link-secondary"></a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <!-- Copyright © 2020
                <a href="{{ url()->current() }}" class="link-secondary">Kututis</a>.
                All rights reserved. -->
            </div>
        </div>
    </div>
</footer>

@yield('modals')
<script src="{{ asset('js/kututis.js') }}"></script>
@section('scripts')
@show

</body>
</html>
