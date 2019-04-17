<!DOCTYPE html>
<html>

<head>
    
    <title>IPCA - User Dashboard</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.tabledit.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.toast.min.js') }}"></script>
    <style>
.dropbtn {
  /*background-color: #4CAF50;
  color: white;*/
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: block;
}

.dropdown-content {
  display: none;
    position: absolute;
    background-color: #055e80;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    padding: 0;
    margin: 0;
    width: 100%;

}
.dropdown-content li{
    list-style-type: none;
}
.dropdown-content li a {
    font-size: 14px;
    border-top: 1px solid #fff6;
}

.dropdown-content a {
  color: #fff;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
.dropbtn .fa.fa-angle-right {
    text-align: right;
    float: right;
}
.dropdown:hover .fa.fa-angle-right {
    transform: rotateZ(91deg);
    transition: 0.5s;
}

.dropdown-content a:hover {background-color: #00adee;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown-nw .fa.fa-circle-o {
    color: #fff;
    font-size: 14px;
}

/*.dropdown:hover .dropbtn {background-color: #ffffff;}*/
</style>
</head>

<body class="after-login">
    <div class="container-fluid">
        <div class="dashboard-page-wrapper">
            <div class="display-table">
                <div class="row display-table-row">
                    <div class="col-md-3 col-sm-4 display-table-cell v-align box" id="navigation">
                        <div class="navigation-new-cls">
                            <div class="logo">
                                <a hef="#"><img src="{{ asset('public/images/logo.png') }}" alt="logo" class="hidden-xs hidden-sm">
                                    <img src="{{ asset('public/images/logo.png') }}" alt="logo" class="visible-xs visible-sm circle-logo">
                                </a>
                            </div>
                            <div class="navi nav-drop">
                                <ul>
                                    @if(Auth::user()->usertype == 1)
                                        <li class="@if($page == 'dashboard') active @endif"><a href="{{ route('dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
                                        <li class="@if($page == 'incentive_configurator') active @endif dropdown-nw"><a href="#" class="dropbtn-nw"><i class="fa fa-tasks" aria-hidden="true"></i><span>Incentive Configurator</span> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                            <ul class="dropdown-content-nw">
                                                <li><a href="{{ route('incentive-configurator-slab') }}"><i class="fa fa-circle-o" aria-hidden="true"></i> Slab </a></li>
                                                <li><a href="{{ route('incentive-configurator-prospective-earner-factor') }}"><i class="fa fa-circle-o" aria-hidden="true"></i> Prospective Earner Factor</a></li>
                                            </ul>
                                        </li>
                                        <li class="@if($page == 'processor') active @endif dropdown-nw"><a href="#" class="dropbtn-nw"><i class="fa fa-spinner" aria-hidden="true"></i><span>Process</span><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                            <ul class="dropdown-content-nw">
                                                <li><a href="{{ route('process-audit') }}"><i class="fa fa-circle-o" aria-hidden="true"></i> Audit </a></li>
                                                <li><a href="{{ route('process-actual') }}"><i class="fa fa-circle-o" aria-hidden="true"></i> Actual </a></li>
                                            </ul>
                                        </li>
                                        <li class="@if($page == 'reports') active @endif dropdown-nw"><a href="#" class="dropbtn-nw"><i class="fa fa-file" aria-hidden="true"></i><span>Reports</span><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                        <ul class="dropdown-content-nw">
                                                <li><a href="{{ route('reports-general') }}"><i class="fa fa-circle-o" aria-hidden="true"></i> General </a></li>
                                                <li><a href="{{ route('reports-audit') }}"><i class="fa fa-circle-o" aria-hidden="true"></i> Audit </a></li>
                                            </ul></li>
                                        <li class="@if($page == 'incentive_simulator') active @endif "><a href="{{ route('incentive-simulator') }}"><i class="fa fa-cogs" aria-hidden="true"></i><span>Incentive Simulator</span></a>
                                        </li>
                                        <li class="@if($page == 'incentive_guidance') active @endif "><a href="{{ route('incentive-guidance') }}" ><i class="fa fa-money" aria-hidden="true"></i><span>Incentive Guidance</span></a>
                                        </li>
                                    @else
                                        <li class="@if($page == 'dashboard') active @endif"><a href="{{ route('dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
                                        <li class="@if($page == 'incentive_simulator') active @endif"><a href="{{ route('incentive-simulator') }}"><i class="fa fa-cogs" aria-hidden="true"></i><span>Incentive Simulator</span></a></li>
                                        <li class="@if($page == 'incentive_guidance') active @endif"><a href="{{ route('incentive-guidance') }}"><i class="fa fa-money" aria-hidden="true"></i><span>Incentive Guidance</span></a></li>
                                    @endif                                                      
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 display-table-cell v-align">
                        <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
                        <div class="row">
                            <header>
                                <div class="col-md-7">
                                    <nav class="navbar-default pull-left">
                                        <h4 class="page-title">Welcome {{ ucwords(Auth::user()->user_name) }}</h4>
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                                                <span class="sr-only">{{ __('Toggle navigation') }}</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>
                                    </nav>                            
                                </div>
                                <div class="col-md-5">
                                    <div class="header-rightside">
                                        <ul class="list-inline header-top pull-right">                                  
                                            <li>
                                                <a href="#"><img src="{{ asset('public/images/user.png') }}" alt="user">
                                                </a>
                                                <ul class="login-out">
                                                    <li><a class="dropdown-item" href="{{ route('user.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form></li>
                                                </ul>                                  
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </header>
                        </div>
                         
                        
                        @yield('content')


                        
                    </div>
                </div>
            </div>            
        </div>
    </div>
</body>
</html>