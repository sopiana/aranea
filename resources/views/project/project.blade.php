@extends('layouts.app')

@section('content')
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <div class="row project-sidebar-title">
                <div class="col project-logo pr-2">
                    <img class="img-avatar" src="{{URL::asset($selectedProject->avatar)}}" alt="{{$selectedProject->name}}">
                </div>
                <div class="col-md project-name">
                    <h5>{{$selectedProject->name}}</h5>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=backlog">
                        <i class="nav-icon icon-menu"></i> Backlog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=tasks">
                        <i class="nav-icon icon-event"></i> Tasks
                    </a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-puzzle"></i> Issues
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=issues-all">
                                <i class="nav-icon icon-grid"></i> All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=issues-request">
                                <i class="nav-icon icon-tag"></i> Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=issues-req">
                                <i class="nav-icon icon-layers"></i> Requirements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=issues-tc">
                                <i class="nav-icon icon-target"></i> Test Cases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=issues-te">
                                <i class="nav-icon icon-social-steam"></i> Test Executions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=issues-bugs">
                                <i class="nav-icon icon-ghost"></i> Bugs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link right-nav" href="{{ route('project',$selectedProject->project_code) }}/?page=release">
                                <i class="nav-icon icon-rocket"></i> Releases
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item right-nav">
                    <a class="nav-link" href="{{ route('project',$selectedProject->project_code) }}/?page=components">
                        <i class="nav-icon icon-support"></i> Components
                    </a>
                </li>
                <li class="nav-item right-nav">
                    <a class="nav-link" href="{{ route('project',$selectedProject->project_code) }}/?page=roadmap">
                        <i class="nav-icon icon-flag"></i> Roadmap
                    </a>
                </li>
                <li class="nav-item right-nav">
                    <a class="nav-link" href="{{ route('project',$selectedProject->project_code) }}/?page=board">
                        <i class="nav-icon icon-map"></i> Kanban board
                    </a>
                </li>
                <li class="nav-item right-nav">
                    <a class="nav-link" href="{{ route('project',$selectedProject->project_code) }}/?page=reports">
                        <i class="nav-icon icon-graph"></i> Reports
                    </a>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <div id="pageContainer" class="animated fadeIn">
        </div>
    </main>
</div>
@endsection

@section('hidden-subpage')
<!-- /.col-->
<div id="requestList-detail">
    <div class="card-body">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="icon-tag icon-gradient bg-arielle-smile">
                </i>
            </div> Requests
            <div class="pl-3 page-navbar">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Switch Filter <i class="fa fa-caret-down pl-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-left filter-view-dropdown">
                    <a class="dropdown-item" href="#" filter="my-open" default="true">My open issues</a>
                    <a class="dropdown-item" href="#" filter="reported">Reported by me</a>
                    <a class="dropdown-item" href="#" filter="all">All issues</a>
                    <a class="dropdown-item" href="#" filter="open">Open issues</a>
                    <a class="dropdown-item" href="#" filter="done">Done issues</a>
                    <a class="dropdown-item" href="#" filter="viewed">Viewed recently</a>
                    <a class="dropdown-item" href="#" filter="created">Created recently</a>
                    <a class="dropdown-item" href="#" filter="resolved">Resolved recently</a>
                    <a class="dropdown-item" href="#" filter="updated">Updated recently</a>
                </div>
            </div>

            <div class="col-sm text-right page-navbar">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Switch View <i class="fa fa-caret-down pl-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right filter-view-dropdown">
                    <a class="dropdown-item" href="#" view="detail" default="true">Detail View</a>
                    <a class="dropdown-item" href="#" view="folder">Folder View</a>
                    <a class="dropdown-item" href="#" view="list">List View</a>
                </div>
            </div>

        </div>

        <div id="request-list-container" class="div">
            <table id="request-list-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Summary</th>
                        <th>Status</th>
                        <th>Submitter</th>
                        <th>Creation Date</th>
                        <th>Priority</th>
                        <th>Assignee</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
