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
@endif
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{URL::asset('assets/images/logo.png')}}" width="140" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="{{URL::asset('assets/images/logo-min.png')}}" width="30" height="30" alt="CoreUI Logo">
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Dashboard</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Projects</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Issues</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Filters</a>
        </li>
        <li class="nav-item px-3">
            <div class="input-group input-search">
                <span class="input-group-prepend">
                <button class="btn btn-primary" type="button">
                <i class="fa fa-search"></i></button>
                </span>
                <input class="form-control" id="input1-group2" type="text" name="input1-group2" placeholder="Username" autocomplete="username">
            </div>
        </li>
        </ul>
        <ul class="nav navbar-nav ml-auto" style="margin-right: 20px">
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
            <i class="icon-bell"></i>
            <span class="badge badge-pill badge-danger">5</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img class="img-avatar" src="{{URL::asset('assets/images/avatars/6.jpg')}}" alt="admin@bootstrapmaster.com">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-file"></i> Projects
                    <span class="badge badge-info">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-calendar-o"></i> Tasks
                    <span class="badge badge-success">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-tasks"></i> Issues
                    <span class="badge badge-warning">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-filter"></i> Filters
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-wrench"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
        </ul>
    </header>
    @yield('content')
    <!-- Scripts -->
    <script src="{{ URL::asset('/assets/js/main.js') }}" defer></script>
</body>
</html>
