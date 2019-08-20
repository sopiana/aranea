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
    <div class="card-body">
        <div class="row brand-card-body">
            <div class="pl-3 pr-3">
                <div class="text-left">
                    <h4 class="card-title mb-0">Profile Data</h4>
                </div>
                <div class="btn-group float-right" role="group" aria-label="Button group">
                    <a class="btn" href="#" title="Change password">
                        <i class="icon-lock"></i>
                    </a>
                    <a class="btn" href="#" title="Edit profile">
                        <i class="icon-note"></i></a>
                </div>
                <table class="table table-responsive-sm text-left profile-info">
                    <tbody>
                        <tr>
                            <td rowspan="7" width="50px" class="text-center">
                                <img class="img-avatar"  src="{{URL::asset($userData->avatar)}}">
                                <br/>
                                @if($userData->is_active)
                                <span class="badge badge-success mr-0">Active</span>
                                @else
                                <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <th><i class="fa fa-user-o pr-2"></i>Username</th>
                            <td>{{$userData->username}}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-envelope-o pr-2"></i>Email</th>
                            <td>{{$userData->email}}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-vcard-o pr-2"></i>Full Name</th>
                            <td>{{$userData->fullname}}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-building-o pr-2"></i>Company</th>
                            <td>{{$userData->company}}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-phone pr-2"></i>Phone</th>
                            <td>{{$userData->phone}}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-mobile pr-2"></i>Mobile</th>
                            <td>{{$userData->mobile}}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-sitemap pr-2"></i>Role</th>
                            <td>{{$userData->role}}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><i class="fa fa-commenting-o pr-2"></i>{{$userData->comment}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-left pt-3">
                    <h4 class="card-title mb-0">Group</h4>
                    <div class="text-value">bla-bla</div>
                </div>
            </div>
            <div>
                <div class="pl-3 pb-3 text-left">
                    <h4 class="card-title mb-0">Activity Log</h4>
                </div>
                <div class="pr-3 pl-3">
                        <div class="list-group list-group-accent">
                                <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Today</div>
                                <div class="list-group-item list-group-item-accent-warning list-group-item-divider">
                                  <div>Meeting with
                                    <strong>Lucas</strong>
                                  </div>
                                  <small class="text-muted mr-3">
                                    <i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                                  <small class="text-muted">
                                    <i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                                </div>
                                <div class="list-group-item list-group-item-accent-info">

                                  <div>Skype with
                                    <strong>Megan</strong>
                                  </div>
                                  <small class="text-muted mr-3">
                                    <i class="icon-calendar"></i>&nbsp; 4 - 5pm</small>
                                  <small class="text-muted">
                                    <i class="icon-social-skype"></i>&nbsp; On-line</small>
                                </div>
                                <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Tomorrow</div>
                                <div class="list-group-item list-group-item-accent-danger list-group-item-divider">
                                  <div>New UI Project -
                                    <strong>deadline</strong>
                                  </div>
                                  <small class="text-muted mr-3">
                                    <i class="icon-calendar"></i>&nbsp; 10 - 11pm</small>
                                  <small class="text-muted">
                                    <i class="icon-home"></i>&nbsp; creativeLabs HQ</small>

                                </div>
                                <div class="list-group-item list-group-item-accent-success list-group-item-divider">
                                  <div>
                                    <strong>#10 Startups.Garden</strong> Meetup</div>
                                  <small class="text-muted mr-3">
                                    <i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                                  <small class="text-muted">
                                    <i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                                </div>
                                <div class="list-group-item list-group-item-accent-primary list-group-item-divider">
                                  <div>
                                    <strong>Team meeting</strong>
                                  </div>
                                  <small class="text-muted mr-3">
                                    <i class="icon-calendar"></i>&nbsp; 4 - 6pm</small>
                                  <small class="text-muted">
                                    <i class="icon-home"></i>&nbsp; creativeLabs HQ</small>
                                  </div>
                              </div>
                </div>
                <div class="col-4 pt-3">
                    <button class="btn btn-block btn-primary" type="button">Load more logs</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.col-->
<div id="projectList-detail" class="card">
    <div class="card-body">
        <div class="text-left pb-3">
            <h4 class="card-title mb-0">My Projects</h4>
        </div>

        <div id="project-list-container" class="div">
            <table id="project-list-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Project Code</th>
                        <th>Owner</th>
                        <th>Project Type</th>
                        <th>Creation Date</th>
                        <th>Active</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- /.col-->
<div id="requestList-detail" class="card">
    <div class="card-body">
        <div class="text-left pb-3">
            <h4 class="card-title mb-0">My Requests</h4>
        </div>

        <div id="request-list-container" class="div">
            <table id="request-list-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Summary</th>
                        <th>Status</th>
                        <th>Submitter</th>
                        <th>Submitted At</th>
                        <th>Priority</th>
                        <th>Assignee</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- /.col-->
<div id="requirementList-detail" class="card">
    <div class="card-body">
        <div class="text-left pb-3">
            <h4 class="card-title mb-0">My Requirements</h4>
        </div>

        <div id="requirement-list-container" class="div">
            <table id="requirement-list-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Req. ID</th>
                        <th>Summary</th>
                        <th>Status</th>
                        <th>Submitter</th>
                        <th>Submitted At</th>
                        <th>Priority</th>
                        <th>Assignee</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
