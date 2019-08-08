@extends('layouts.app')

@section('content')
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=dashboard">
                        <i class="nav-icon icon-speedometer"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=profile">
                        <i class="nav-icon icon-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=projects">
                        <i class="nav-icon icon-doc"></i> Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=tasks">
                        <i class="nav-icon icon-event"></i> Tasks
                    </a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-puzzle"></i> Issues
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=issues-all">
                                <i class="nav-icon icon-grid"></i> All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=issues-request">
                                <i class="nav-icon icon-tag"></i> Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=issues-req">
                                <i class="nav-icon icon-layers"></i> Requirements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=issues-tc">
                                <i class="nav-icon icon-target"></i> Test Cases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=issues-te">
                                <i class="nav-icon icon-social-steam"></i> Test Executions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=issues-bugs">
                                <i class="nav-icon icon-ghost"></i> Bugs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=release">
                                <i class="nav-icon icon-rocket"></i> Releases
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('dashboard') }}/?page=filters">
                        <i class="nav-icon icon-drop"></i> Filters
                    </a>
                </li>
                <li class="nav-item right-nav">
                    <a class="nav-link" href="{{ route('dashboard') }}/?page=setting">
                        <i class="nav-icon icon-wrench"></i> Setting
                    </a>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <div class="container-fluid">
            <div id="pageContainer" class="animated fadeIn">
            </div>
        </div>
    </main>
</div>
@endsection

@section('hidden-subpage')
<div id="profile-detail" class="card">
    <div class="brand-card">
        <div class="brand-card-header bg-facebook">
        <i class="fa fa-facebook"></i>
        <div class="chart-wrapper">
            <canvas id="social-box-chart-1" height="90"></canvas>
        </div>
        </div>
        <div class="brand-card-body">
        <div>
            <div class="text-value">89k</div>
            <div class="text-uppercase text-muted small">friends</div>
        </div>
        <div>
            <div class="text-value">459</div>
            <div class="text-uppercase text-muted small">feeds</div>
        </div>
        </div>
    </div>
</div>
<!-- /.col-->
<div class="col-sm-6 col-lg-3">
    <div class="brand-card">
        <div class="brand-card-header bg-twitter">
        <i class="fa fa-twitter"></i>
        <div class="chart-wrapper">
            <canvas id="social-box-chart-2" height="90"></canvas>
        </div>
        </div>
        <div class="brand-card-body">
        <div>
            <div class="text-value">973k</div>
            <div class="text-uppercase text-muted small">followers</div>
        </div>
        <div>
            <div class="text-value">1.792</div>
            <div class="text-uppercase text-muted small">tweets</div>
        </div>
        </div>
    </div>
</div>
<!-- /.col-->
<div class="col-sm-6 col-lg-3">
    <div class="brand-card">
        <div class="brand-card-header bg-linkedin">
        <i class="fa fa-linkedin"></i>
        <div class="chart-wrapper">
            <canvas id="social-box-chart-3" height="90"></canvas>
        </div>
        </div>
        <div class="brand-card-body">
        <div>
            <div class="text-value">500+</div>
            <div class="text-uppercase text-muted small">contacts</div>
        </div>
        <div>
            <div class="text-value">292</div>
            <div class="text-uppercase text-muted small">feeds</div>
        </div>
        </div>
    </div>
</div>
    <!-- /.col-->
<div id="profile-coba" class="col-sm-6 col-lg-3">
    <div class="brand-card">
        <div class="brand-card-header bg-google-plus">
        <i class="fa fa-google-plus"></i>
        <div class="chart-wrapper">
            <canvas id="social-box-chart-4" height="90"></canvas>
        </div>
        </div>
        <div class="brand-card-body">
        <div>
            <div class="text-value">894</div>
            <div class="text-uppercase text-muted small">followers</div>
        </div>
        <div>
            <div class="text-value">92</div>
            <div class="text-uppercase text-muted small">circles</div>
        </div>
        </div>
    </div>
</div>
@endsection
