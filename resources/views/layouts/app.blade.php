<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
        @yield('title')
        </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ url('css/ionicons.min.css') }}">
        @yield('datatablescss')
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('css/AdminLTE.min.css') }}">
        <!-- Toastr style -->
        <link href="{{ url('css/toastr.min.css') }}" rel="stylesheet"/>
        <!-- LibreNMS stylesheet -->
        <link href="{{ url('css/librenms.css') }}" rel="stylesheet"/>
        <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ url('css/skins/_all-skins.min.css') }}">
        <!-- Gridstack style -->
        <link href="{{ url('css/gridstack.min.css') }}" rel="stylesheet"/>
          <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
          <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
        @if (Auth::check())
            <div class="wrapper">
                <header class="main-header">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><i class="fa fa-home"></i></span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><b>Libre</b>NMS</span>
                    </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- Notifications Menu -->
                                <li class="dropdown notifications-menu">
                                    <!-- Menu toggle button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-warning">{{ count($notifications) }}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have {{ count($notifications) }} unread notifications</li>
                                        @foreach($notifications->take(5) as $notification)
                                        <li>
                                            <!-- Inner Menu: contains the notifications -->
                                            <ul class="menu">
                                                <li><!-- start notification -->
                                                    <a href="{{ url('/notifications/'.$notification->notifications_id) }}" title="{{ $notification->body }}">
                                                        <i class="fa fa-bell text-aqua"></i> {{ $notification->title }}
                                                    </a>
                                                </li>
                                                <!-- end notification -->
                                            </ul>
                                        </li>
                                        @endforeach
                                        <li class="footer"><a href="{{ url('/notifications') }}">View all</a></li>
                                    </ul>
                                </li>
                                <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                      <span class="hidden-xs">{{ Auth::user()->username }}</span> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="user-header">
                                            <p>{{ Auth::user()->realname }} ({{ Auth::user()->username }})</p>
                                            <p><small>Email: {{ Auth::user()->email }}</small></p>
                                            <p><small>Userlevel: {{ Auth::user()->level }}</small></p>
                                        </li>
                                        <li class="user-footer">
                                            <div class="pull-left"><a href="{{ url('/preferences') }}" class="btn btn-default btn-flat"><i class="fa fa-cog"></i> My Settings</a></div>
                                            <div class="pull-right"><a href="{{ url('/logout') }}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Logout</a></div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- search form -->
                        <form action="#" method="get" class="sidebar-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                        <!-- /.search form -->
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <!-- Overview sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-lightbulb-o"></i> <span>Overview</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ url('/') }}"><i class="icon fa fa-lightbulb-o"></i> Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-exclamation-circle"></i> Alerts
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="#"><i class="icon fa fa-bell"></i> Notifications</a></li>
                                            <li><a href="#"><i class="icon fa fa-th-list"></i> Historical log</a></li>
                                            <li><a href="#"><i class="icon fa fa-bar-chart"></i> Statistics</a></li>
                                            <!-- Admin only -->
                                            <li><a href="#"><i class="icon fa fa-tasks"></i> Rules</a></li>
                                            <li><a href="#"><i class="icon fa fa-calendar"></i> Maintenance window</a></li>
                                            <li><a href="#"><i class="icon fa fa-link"></i> Rule mapping</a></li>
                                            <li><a href="#"><i class="icon fa fa-sitemap"></i> Templates</a></li>
                                            <!-- /.admin only -->
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-sitemap"></i> Maps
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="#"><i class="icon fa fa-arrow-circle-up"></i> Availability</a></li>
                                            <li><a href="#"><i class="icon fa fa-desktop"></i> Network</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-wrench"></i> Tools
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="#"><i class="icon fa fa-arrow-circle-up"></i> RIPE NCC API</a></li>
                                        </ul>
                                    </li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-book"></i> Eventlog</a></li>
                                    <!-- only if enabled -->
                                    <li><a href="#"><i class="icon fa fa-book"></i> Syslog</a></li>
                                    <li><a href="#"><i class="icon fa fa-book"></i> Graylog</a></li>
                                    <!-- /.only if enabled -->
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-cube"></i> Inventory</a></li>
                                    <!-- If data exists -->
                                    <li><a href="#"><i class="icon fa fa-archive"></i> Packages</a></li>
                                    <!-- /.if data exists -->
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> IPv4 Search</a></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> IPv6 Search</a></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> MAC Search</a></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> ARP Tables</a></li>
                                    <li><hr></li>
                                    <!-- only if enabled -->
                                    <li><a href="#"><i class="icon fa fa-file-text-o"></i> MIB definitions</a></li>
                                    <!-- /.only if enabled -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.overview sub-menu -->
                        <!-- Devices sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-list"></i> <span>Devices</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="#"><i class="icon fa fa-server"></i> All Devices
                                        <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <li><a href="{{ url('/devices') }}"><i class="icon fa fa-server"></i> Devices</a></li>
                                            <!-- Loop through all device types -->
                                        </ul>
                                    </li>
                                    <li><hr></li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-th"></i> Device Groups
                                        <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <!-- Loop through all device groups -->
                                        </ul>
                                    </li>
                                    <!-- if admin -->
                                    <li><a href="#"><i class="icon fa fa-th"></i> Manage groups</a></li>
                                    <!-- /.if admin -->
                                    <li><hr></li>
                                    <!-- if enabled -->
                                    <li>
                                        <a href="#"><i class="icon fa fa-map-marker"></i> Locations
                                        <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <!-- Loop through all device locations -->
                                        </ul>
                                    </li>
                                    <li><hr></li>
                                    <!-- /.if enabled -->
                                    <!-- if enabled -->
                                    <li><a href="#"><i class="icon fa fa-file-text-o"></i> MIB associations</a></li>
                                    <!-- /.if enabled -->
                                    <li><hr></li>
                                    <li><a href="{{ route('devices.create') }}"><i class="icon fa fa-plus text-green"></i> Add device</a></li>
                                    <li><a href="#"><i class="icon fa fa-trash text-aqua"></i> Delete device</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.devices sub-memu -->
                        <!-- ports sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-link"></i> <span>Ports</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ url('/ports') }}"><i class="icon fa fa-link"></i> All ports</a></li>
                                    <li><hr></li>
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-exclamation-circle"></i> Errored</a></li>
                                    <li><a href="#"><i class="icon fa fa-question-circle"></i> Ignored</a></li>
                                    <!-- /.if data -->
                                    <li><hr></li>
                                    <!-- if enabled -->
                                    <li><a href="#"><i class="icon fa fa-money"></i> Traffic bills</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-arrows-alt"></i> Pseudowires</a></li>
                                    <!-- /.if enabled -->
                                    <li><hr></li>
                                    <!-- if admin/read and enabled -->
                                    <li><a href="#"><i class="icon fa fa-users"></i> Customers</a></li>
                                    <li><a href="#"><i class="icon fa fa-link"></i> L2TP</a></li>
                                    <li><a href="#"><i class="icon fa fa-truck"></i> Transit</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-plus"></i> Peering</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-secret"></i> Transit + Peering</a></li>
                                    <li><a href="#"><i class="icon fa fa-anchor"></i> Core</a></li>
                                    <!-- loop through custom ports -->
                                    <!-- /.if admin/read and enabled-->
                                    <li><hr></li>
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-exclamation-circle"></i> Alerts</a></li>
                                    <!-- /.if data -->
                                    <li><a href="#"><i class="icon fa fa-exclamation-triangle text-red"></i> Down</a></li>
                                    <li><a href="#"><i class="icon fa fa-pause text-blue"></i> Disabled</a></li>
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-minus-circle text-aqua"></i> Deleted</a></li>
                                    <!-- /.if data -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.ports sub-menu -->
                        <!-- services sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-cogs"></i> <span>Services</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="icon fa fa-cogs"></i> All services</a></li>
                                    <!-- if enabled -->
                                    <li><a href="#"><i class="icon fa fa-bell-o"></i> Alerts</a></li>
                                    <!-- /.if enabled -->
                                    <li><hr></li>
                                    <!-- if admin -->
                                    <li><a href="#"><i class="icon fa fa-bell-o text-green"></i> Add service</a></li>
                                    <li><a href="#"><i class="icon fa fa-bell-o text-aqua"></i> Edit service</a></li>
                                    <li><a href="#"><i class="icon fa fa-bell-o text-red"></i> Delete service</a></li>
                                    <!-- /.if admin -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.services sub-menu -->
                        <!-- health sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-heartbeat"></i> <span>Health</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="icon fa fa-gears"></i> Memory</a></li>
                                    <li><a href="#"><i class="icon fa fa-desktop"></i> Processor</a></li>
                                    <li><a href="#"><i class="icon fa fa-database"></i> Storage</a></li>
                                    <!-- Loop through other health sensors -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.health sub-menu -->
                        <!-- apps sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-tasks"></i> <span>Apps</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- Loop through app types-->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.apps sub-menu -->
                        <!-- routing sub-menu -->
                        <!-- if admin/read -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-arrows"></i> <span>Routing</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-arrows-alt"></i> VRFs</a></li>
                                    <li><a href="#"><i class="icon fa fa-circle-o-notch"></i> OSPF</a></li>
                                    <li><a href="#"><i class="icon fa fa-exchange"></i> Cisco OTV</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-link"></i> BGP All sessions</a></li>
                                    <li><a href="#"><i class="icon fa fa-external-link"></i> BGP External</a></li>
                                    <li><a href="#"><i class="icon fa fa-external-link"></i> BGP Internal</a></li>
                                    <li><a href="#"><i class="icon fa fa-exclamation-circle"></i> Alerted BGP</a></li>
                                    <!-- /.if data -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.if admin/read -->
                        <!-- /.routing sub-menu -->
                        <!-- settings sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-gears"></i> <span>Settings</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- if admin -->
                                    <li><a href="{{ url('/settings') }}"><i class="icon fa fa-sitemap"></i> Global settings</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-user-plus"></i> Add user</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-times"></i> Remove user</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-secret"></i> Edit user</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-key"></i> Authlog</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-list-alt"></i> Pollers log</a></li>
                                    <li><a href="#"><i class="icon fa fa-clock-o"></i> Pollers</a></li>
                                    <!-- if distributed poller -->
                                    <li><a href="#"><i class="icon fa fa-gears"></i> Poller groups</a></li>
                                    <li><hr></li>
                                    <!-- /.if distributed poller -->
                                    <li><a href="#"><i class="icon fa fa-wrench"></i> API tokens</a></li>
                                    <li><a href="#"><i class="icon fa fa-book"></i> API Docs</a></li>
                                    <!-- /.if admin -->
                                    <li><hr></li>
                                    <li><a href="{{ url('/about') }}"><i class="icon fa fa-exclamation-circle"></i> About LibreNMS</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.settings sub-menu -->
                    </section>
                    <!-- /.sidebar -->
                </aside>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        @yield('content-header')
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        @yield('content')
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <strong>Copyright &copy; {{ date("Y") }} <a href="http://www.librenms.org">LibreNMS</a>.</strong> All rights reserved.
                </footer>
                @yield('settings-menu')
            <div>
        @endif

        @if (Auth::guest())
            @yield('content')
        @endif

        <!-- Javascript Libs -->
        <!-- jQuery 2.1.4 -->
        <script src="{{ url('js/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <script src="{{ url('js/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{ url('js/bootstrap.min.js') }}"></script>
        @yield('datatablesjs')
        <!-- FastClick -->
        <script src="{{ url('js/plugins/fastclick/fastclick.js') }}"></script>
        <!-- Toastr -->
        <script src="{{ url('js/plugins/toastr/toastr.min.js') }}"></script>
        <!-- Lodash -->
        <script src="{{ url('js/lodash.min.js') }}"></script>
        <!-- Gridstack -->
        <script src="{{ url('js/gridstack.min.js') }}"></script>
        <!-- AdminLTE Options and App -->
        <script>
            var AdminLTEOptions = {
                // set the treview slide speed
                animationSpeed: 150,
            }
        </script>
        <script src="{{ url('/js/app.min.js') }}"></script>
        <!-- page script -->
        @yield('scripts')
    </body>
</html>
