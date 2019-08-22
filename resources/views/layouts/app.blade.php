<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Aranea">
    <meta name="author" content="Yang Sopiana">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME', 'Aranea') }}</title>

    <!-- Styles -->
    <link href="{{ URL::asset('/assets/css/main.css') }}" rel="stylesheet">
</head>
@if(Route::currentRouteName()=='login')
<body class="app flex-row align-items-center">
@else
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.header')
@endif
    @yield('content')
    <!-- Scripts -->
    <script src="{{ URL::asset('/assets/js/main.js') }}" defer></script>
    <div id="hidden-div">
        @yield('hidden-subpage')
        <div class="load-spinner"></div>
    </div>
</body>
@yield('modal')
</html>
