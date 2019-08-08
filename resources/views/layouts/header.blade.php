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
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Projects</a>
        <div class="dropdown-menu dropdown-menu-left">
            @if(isset($currentProject))
            <div class="dropdown-header text-center">
                <strong>Current Project</strong>
            </div>
            <a class="dropdown-item" href="#">
            <i class="fa fa-user"></i> {{$currentProject->name}}</a>
            @endif
            @if(isset($recentProjects))
            <div class="dropdown-header text-center">
                <strong>Recent Projects</strong>
            </div>
            @foreach ($recentProjects as $recentProject)
                <a class="dropdown-item" href="#">
                    <i class="fa fa-calendar-o"></i> {{$recentProject->name}}
                </a>
            @endforeach
            @endif
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
                View All Projects</a>
        </div>
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
        <img class="img-avatar" src="{{URL::asset($userData->avatar)}}" alt="{{$userData->email}}">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('dashboard') }}/?page=profile">
                <i class="fa fa-user"></i> Profile</a>
            <a class="dropdown-item" href="{{ route('dashboard') }}/?page=projects">
                <i class="fa fa-file"></i> Projects
                <span class="badge badge-info">42</span>
            </a>
            <a class="dropdown-item" href="{{ route('dashboard') }}/?page=tasks">
                <i class="fa fa-calendar-o"></i> Tasks
                <span class="badge badge-success">42</span>
            </a>
            <a class="dropdown-item" href="{{ route('dashboard') }}/?page=issues-all">
                <i class="fa fa-tasks"></i> Issues
                <span class="badge badge-warning">42</span>
            </a>
            <a class="dropdown-item" href="{{ route('dashboard') }}/?page=filters">
                <i class="fa fa-filter"></i> Filters
            </a>
            <a class="dropdown-item" href="{{ route('dashboard') }}/?page=setting">
                <i class="fa fa-wrench"></i> Setting</a>
            <div class="dropdown-divider"></div>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                <i class="fa fa-lock"></i> Logout</a>
        </div>
    </li>
    </ul>
</header>
