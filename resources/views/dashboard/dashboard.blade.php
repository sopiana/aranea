@extends('layouts.app')

@section('content')
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
            <a class="nav-link" href="#">Users</a>
          </li>
          <li class="nav-item px-3">
            <a class="nav-link" href="#">Settings</a>
          </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
          <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
              <i class="icon-bell"></i>
              <span class="badge badge-pill badge-danger">5</span>
            </a>
          </li>
          <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
              <i class="icon-list"></i>
            </a>
          </li>
          <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
              <i class="icon-location-pin"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img class="img-avatar" src="{{URL::asset('assets/images/avatars/6.jpg')}}" alt="admin@bootstrapmaster.com">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header text-center">
                <strong>Account</strong>
              </div>
              <a class="dropdown-item" href="#">
                <i class="fa fa-bell-o"></i> Updates
                <span class="badge badge-info">42</span>
              </a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-envelope-o"></i> Messages
                <span class="badge badge-success">42</span>
              </a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-tasks"></i> Tasks
                <span class="badge badge-danger">42</span>
              </a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-comments"></i> Comments
                <span class="badge badge-warning">42</span>
              </a>
              <div class="dropdown-header text-center">
                <strong>Settings</strong>
              </div>
              <a class="dropdown-item" href="#">
                <i class="fa fa-user"></i> Profile</a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-wrench"></i> Settings</a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-usd"></i> Payments
                <span class="badge badge-secondary">42</span>
              </a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-file"></i> Projects
                <span class="badge badge-primary">42</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="fa fa-shield"></i> Lock Account</a>
              <a class="dropdown-item" href="#">
                <i class="fa fa-lock"></i> Logout</a>
            </div>
          </li>
        </ul>
      </header>
      <div class="app-body">
        <div class="sidebar">
          <nav class="sidebar-nav">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="index.html">
                  <i class="nav-icon icon-speedometer"></i> Dashboard
                  <span class="badge badge-primary">NEW</span>
                </a>
              </li>
              <li class="nav-title">Theme</li>
              <li class="nav-item">
                <a class="nav-link" href="colors.html">
                  <i class="nav-icon icon-drop"></i> Colors</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="typography.html">
                  <i class="nav-icon icon-pencil"></i> Typography</a>
              </li>
              <li class="nav-title">Components</li>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-puzzle"></i> Base</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="base/breadcrumb.html">
                      <i class="nav-icon icon-puzzle"></i> Breadcrumb</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/cards.html">
                      <i class="nav-icon icon-puzzle"></i> Cards</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/carousel.html">
                      <i class="nav-icon icon-puzzle"></i> Carousel</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/collapse.html">
                      <i class="nav-icon icon-puzzle"></i> Collapse</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/forms.html">
                      <i class="nav-icon icon-puzzle"></i> Forms</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/jumbotron.html">
                      <i class="nav-icon icon-puzzle"></i> Jumbotron</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/list-group.html">
                      <i class="nav-icon icon-puzzle"></i> List group</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/navs.html">
                      <i class="nav-icon icon-puzzle"></i> Navs</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/pagination.html">
                      <i class="nav-icon icon-puzzle"></i> Pagination</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/popovers.html">
                      <i class="nav-icon icon-puzzle"></i> Popovers</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/progress.html">
                      <i class="nav-icon icon-puzzle"></i> Progress</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/scrollspy.html">
                      <i class="nav-icon icon-puzzle"></i> Scrollspy</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/switches.html">
                      <i class="nav-icon icon-puzzle"></i> Switches</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/tables.html">
                      <i class="nav-icon icon-puzzle"></i> Tables</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/tabs.html">
                      <i class="nav-icon icon-puzzle"></i> Tabs</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="base/tooltips.html">
                      <i class="nav-icon icon-puzzle"></i> Tooltips</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-cursor"></i> Buttons</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="buttons/buttons.html">
                      <i class="nav-icon icon-cursor"></i> Buttons</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="buttons/button-group.html">
                      <i class="nav-icon icon-cursor"></i> Buttons Group</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="buttons/dropdowns.html">
                      <i class="nav-icon icon-cursor"></i> Dropdowns</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="buttons/brand-buttons.html">
                      <i class="nav-icon icon-cursor"></i> Brand Buttons</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="charts.html">
                  <i class="nav-icon icon-pie-chart"></i> Charts</a>
              </li>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-star"></i> Icons</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="icons/coreui-icons.html">
                      <i class="nav-icon icon-star"></i> CoreUI Icons
                      <span class="badge badge-success">NEW</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="icons/flags.html">
                      <i class="nav-icon icon-star"></i> Flags</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="icons/font-awesome.html">
                      <i class="nav-icon icon-star"></i> Font Awesome
                      <span class="badge badge-secondary">4.7</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="icons/simple-line-icons.html">
                      <i class="nav-icon icon-star"></i> Simple Line Icons</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-bell"></i> Notifications</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="notifications/alerts.html">
                      <i class="nav-icon icon-bell"></i> Alerts</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="notifications/badge.html">
                      <i class="nav-icon icon-bell"></i> Badge</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="notifications/modals.html">
                      <i class="nav-icon icon-bell"></i> Modals</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="widgets.html">
                  <i class="nav-icon icon-calculator"></i> Widgets
                  <span class="badge badge-primary">NEW</span>
                </a>
              </li>
              <li class="divider"></li>
              <li class="nav-title">Extras</li>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-star"></i> Pages</a>
                <ul class="nav-dropdown-items">
                  <li class="nav-item">
                    <a class="nav-link" href="login.html" target="_top">
                      <i class="nav-icon icon-star"></i> Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="register.html" target="_top">
                      <i class="nav-icon icon-star"></i> Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="404.html" target="_top">
                      <i class="nav-icon icon-star"></i> Error 404</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="500.html" target="_top">
                      <i class="nav-icon icon-star"></i> Error 500</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item mt-auto">
                <a class="nav-link nav-link-success" href="https://coreui.io" target="_top">
                  <i class="nav-icon icon-cloud-download"></i> Download CoreUI</a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
                  <i class="nav-icon icon-layers"></i> Try CoreUI
                  <strong>PRO</strong>
                </a>
              </li>
            </ul>
          </nav>
          <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        <main class="main">
          <div class="container-fluid">
            <div class="animated fadeIn">
              <div class="row">
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-primary">
                    <div class="card-body pb-0">
                      <div class="btn-group float-right">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-settings"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </div>
                      <div class="text-value">9.823</div>
                      <div>Members online</div>
                    </div>
                    <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart1" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-info">
                    <div class="card-body pb-0">
                      <button class="btn btn-transparent p-0 float-right" type="button">
                        <i class="icon-location-pin"></i>
                      </button>
                      <div class="text-value">9.823</div>
                      <div>Members online</div>
                    </div>
                    <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart2" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-warning">
                    <div class="card-body pb-0">
                      <div class="btn-group float-right">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-settings"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </div>
                      <div class="text-value">9.823</div>
                      <div>Members online</div>
                    </div>
                    <div class="chart-wrapper mt-3" style="height:70px;">
                      <canvas class="chart" id="card-chart3" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-danger">
                    <div class="card-body pb-0">
                      <div class="btn-group float-right">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-settings"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </div>
                      <div class="text-value">9.823</div>
                      <div>Members online</div>
                    </div>
                    <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart4" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-5">
                      <h4 class="card-title mb-0">Traffic</h4>
                      <div class="small text-muted">November 2017</div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-7 d-none d-md-block">
                      <button class="btn btn-primary float-right" type="button">
                        <i class="icon-cloud-download"></i>
                      </button>
                      <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                        <label class="btn btn-outline-secondary">
                          <input id="option1" type="radio" name="options" autocomplete="off"> Day
                        </label>
                        <label class="btn btn-outline-secondary active">
                          <input id="option2" type="radio" name="options" autocomplete="off" checked=""> Month
                        </label>
                        <label class="btn btn-outline-secondary">
                          <input id="option3" type="radio" name="options" autocomplete="off"> Year
                        </label>
                      </div>
                    </div>
                    <!-- /.col-->
                  </div>
                  <!-- /.row-->
                  <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                    <canvas class="chart" id="main-chart" height="300"></canvas>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row text-center">
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Visits</div>
                      <strong>29.703 Users (40%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Unique</div>
                      <strong>24.093 Users (20%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Pageviews</div>
                      <strong>78.706 Views (60%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">New Users</div>
                      <strong>22.123 Users (80%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Bounce Rate</div>
                      <strong>40.15%</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-->
              <div class="row">
                <div class="col-sm-6 col-lg-3">
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
                <div class="col-sm-6 col-lg-3">
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
                <!-- /.col-->
              </div>
              <!-- /.row-->
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">Traffic & Sales</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="callout callout-info">
                                <small class="text-muted">New Clients</small>
                                <br>
                                <strong class="h4">9,123</strong>
                                <div class="chart-wrapper">
                                  <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                                </div>
                              </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-sm-6">
                              <div class="callout callout-danger">
                                <small class="text-muted">Recuring Clients</small>
                                <br>
                                <strong class="h4">22,643</strong>
                                <div class="chart-wrapper">
                                  <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                                </div>
                              </div>
                            </div>
                            <!-- /.col-->
                          </div>
                          <!-- /.row-->
                          <hr class="mt-0">
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Monday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Tuesday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 94%" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Wednesday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Thursday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 91%" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Friday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 73%" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Saturday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 53%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-4">
                            <div class="progress-group-prepend">
                              <span class="progress-group-text">Sunday</span>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 9%" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 69%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="callout callout-warning">
                                <small class="text-muted">Pageviews</small>
                                <br>
                                <strong class="h4">78,623</strong>
                                <div class="chart-wrapper">
                                  <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                                </div>
                              </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-sm-6">
                              <div class="callout callout-success">
                                <small class="text-muted">Organic</small>
                                <br>
                                <strong class="h4">49,123</strong>
                                <div class="chart-wrapper">
                                  <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                                </div>
                              </div>
                            </div>
                            <!-- /.col-->
                          </div>
                          <!-- /.row-->
                          <hr class="mt-0">
                          <div class="progress-group">
                            <div class="progress-group-header">
                              <i class="icon-user progress-group-icon"></i>
                              <div>Male</div>
                              <div class="ml-auto font-weight-bold">43%</div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group mb-5">
                            <div class="progress-group-header">
                              <i class="icon-user-female progress-group-icon"></i>
                              <div>Female</div>
                              <div class="ml-auto font-weight-bold">37%</div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <i class="icon-globe progress-group-icon"></i>
                              <div>Organic Search</div>
                              <div class="ml-auto font-weight-bold mr-2">191.235</div>
                              <div class="text-muted small">(56%)</div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <i class="icon-social-facebook progress-group-icon"></i>
                              <div>Facebook</div>
                              <div class="ml-auto font-weight-bold mr-2">51.223</div>
                              <div class="text-muted small">(15%)</div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <i class="icon-social-twitter progress-group-icon"></i>
                              <div>Twitter</div>
                              <div class="ml-auto font-weight-bold mr-2">37.564</div>
                              <div class="text-muted small">(11%)</div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 11%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <i class="icon-social-linkedin progress-group-icon"></i>
                              <div>LinkedIn</div>
                              <div class="ml-auto font-weight-bold mr-2">27.319</div>
                              <div class="text-muted small">(8%)</div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.col-->
                      </div>
                      <!-- /.row-->
                      <br>
                      <table class="table table-responsive-sm table-hover table-outline mb-0">
                        <thead class="thead-light">
                          <tr>
                            <th class="text-center">
                              <i class="icon-people"></i>
                            </th>
                            <th>User</th>
                            <th class="text-center">Country</th>
                            <th>Usage</th>
                            <th class="text-center">Payment Method</th>
                            <th>Activity</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center">
                              <div class="avatar">
                                <img class="img-avatar" src="{{URL::asset('assets/images/avatars/1.jpg')}}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-success"></span>
                              </div>
                            </td>
                            <td>
                              <div>Yiorgos Avraamu</div>
                              <div class="small text-muted">
                                <span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <i class="flag-icon flag-icon-us h4 mb-0" id="us" title="us"></i>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left">
                                  <strong>50%</strong>
                                </div>
                                <div class="float-right">
                                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                </div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <i class="fa fa-cc-mastercard" style="font-size:24px"></i>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div>
                              <strong>10 sec ago</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="avatar">
                                <img class="img-avatar" src="{{URL::asset('assets/images/avatars/2.jpg')}}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-danger"></span>
                              </div>
                            </td>
                            <td>
                              <div>Avram Tarasios</div>
                              <div class="small text-muted">
                                <span>Recurring</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <i class="flag-icon flag-icon-br h4 mb-0" id="br" title="br"></i>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left">
                                  <strong>10%</strong>
                                </div>
                                <div class="float-right">
                                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                </div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <i class="fa fa-cc-visa" style="font-size:24px"></i>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div>
                              <strong>5 minutes ago</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="avatar">
                                <img class="img-avatar" src="{{URL::asset('assets/images/avatars/3.jpg')}}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-warning"></span>
                              </div>
                            </td>
                            <td>
                              <div>Quintin Ed</div>
                              <div class="small text-muted">
                                <span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <i class="flag-icon flag-icon-in h4 mb-0" id="in" title="in"></i>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left">
                                  <strong>74%</strong>
                                </div>
                                <div class="float-right">
                                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                </div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <i class="fa fa-cc-stripe" style="font-size:24px"></i>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div>
                              <strong>1 hour ago</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="avatar">
                                <img class="img-avatar" src="{{URL::asset('assets/images/avatars/4.jpg')}}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-secondary"></span>
                              </div>
                            </td>
                            <td>
                              <div>Enéas Kwadwo</div>
                              <div class="small text-muted">
                                <span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <i class="flag-icon flag-icon-fr h4 mb-0" id="fr" title="fr"></i>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left">
                                  <strong>98%</strong>
                                </div>
                                <div class="float-right">
                                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                </div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 98%" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <i class="fa fa-paypal" style="font-size:24px"></i>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div>
                              <strong>Last month</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="avatar">
                                <img class="img-avatar" src="{{URL::asset('assets/images/avatars/5.jpg')}}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-success"></span>
                              </div>
                            </td>
                            <td>
                              <div>Agapetus Tadeáš</div>
                              <div class="small text-muted">
                                <span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <i class="flag-icon flag-icon-es h4 mb-0" id="es" title="es"></i>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left">
                                  <strong>22%</strong>
                                </div>
                                <div class="float-right">
                                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                </div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <i class="fa fa-google-wallet" style="font-size:24px"></i>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div>
                              <strong>Last week</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="avatar">
                                <img class="img-avatar" src="{{URL::asset('assets/images/avatars/6.jpg')}}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-danger"></span>
                              </div>
                            </td>
                            <td>
                              <div>Friderik Dávid</div>
                              <div class="small text-muted">
                                <span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <i class="flag-icon flag-icon-pl h4 mb-0" id="pl" title="pl"></i>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left">
                                  <strong>43%</strong>
                                </div>
                                <div class="float-right">
                                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                </div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <i class="fa fa-cc-amex" style="font-size:24px"></i>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div>
                              <strong>Yesterday</strong>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
            </div>
          </div>
        </main>
      </div>
@endsection
