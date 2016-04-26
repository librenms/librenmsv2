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
                                        <span class="label label-warning" id="notification-menu-count">{{ count($menu_notifications) }}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <!-- Inner Menu: contains the notifications -->
                                            <ul id="dropdown-notifications-list" class="menu">
                                        @foreach($menu_notifications->take(5) as $notification)
                                                <li><!-- start notification -->
                                                    <a href="{{ url('/notifications/'.$notification->notifications_id) }}" title="{{ $notification->body }}">
                                                        <i class="fa fa-bell text-aqua"></i> {{ $notification->title }}
                                                    </a>
                                                </li>
                                        @endforeach
                                                <!-- end notification -->
                                            </ul>
                                        </li>
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
                                            <div class="pull-left"><a href="{{ url('/preferences') }}" class="btn btn-default btn-flat"><i class="fa fa-cog"></i> {{ trans('nav.mysettings') }}</a></div>
                                            <div class="pull-right"><a href="{{ url('/logout') }}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> {{ trans('nav.logout') }}</a></div>
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
                                <input type="text" name="q" class="form-control" placeholder="{{ trans('nav.search') }}">
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
                                    <i class="fa fa-lightbulb-o"></i> <span>{{ trans('nav.overview.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ url('/') }}"><i class="icon fa fa-lightbulb-o"></i> {{ trans('nav.overview.dashboard') }}</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-exclamation-circle"></i> {{ trans('nav.overview.alerts.main') }}
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="{{ url('alerting/alerts') }}"><i class="icon fa fa-bell"></i> {{ trans('nav.overview.alerts.notifications')}}</a></li>
                                            <li><a href="{{ url('alerting/logs') }}"><i class="icon fa fa-th-list"></i> {{ trans('nav.overview.alerts.log') }}</a></li>
                                            <li><a href="{{ url('alerting/stats') }}"><i class="icon fa fa-bar-chart"></i> {{ trans('nav.overview.alerts.stats') }}</a></li>
                                            @if (Auth::user()->isAdmin())
                                            <li><a href="#"><i class="icon fa fa-tasks"></i> {{ trans('nav.overview.alerts.rules') }}</a></li>
                                            <li><a href="#"><i class="icon fa fa-calendar"></i> {{ trans('nav.overview.alerts.maintenance') }}</a></li>
                                            <li><a href="#"><i class="icon fa fa-link"></i> {{ trans('nav.overview.alerts.mapping') }}</a></li>
                                            <li><a href="#"><i class="icon fa fa-sitemap"></i> {{ trans('nav.overview.alerts.templates') }}</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-sitemap"></i> {{ trans('nav.overview.maps.main') }}
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="#"><i class="icon fa fa-arrow-circle-up"></i> {{ trans('nav.overview.maps.availability') }}</a></li>
                                            <li><a href="#"><i class="icon fa fa-desktop"></i> {{ trans('nav.overview.maps.network') }}</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-wrench"></i> {{ trans('nav.overview.tools.main') }}
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="{{ url('rirtools') }}"><i class="icon fa fa-arrow-circle-up"></i> {{ trans('nav.overview.tools.rirtools') }}</a></li>
                                        </ul>
                                    </li>
                                    <li><hr></li>
                                    <li><a href="{{ url('eventlog') }}"><i class="icon fa fa-book"></i> {{ trans('nav.overview.eventlog') }}</a></li>
                                    <!-- only if enabled -->
                                    <li><a href="{{ url('syslog') }}"><i class="icon fa fa-book"></i> {{ trans('nav.overview.syslog') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-book"></i> {{ trans('nav.overview.graylog') }}</a></li>
                                    <!-- /.only if enabled -->
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-cube"></i> {{ trans('nav.overview.inventory') }}</a></li>
                                    <!-- If data exists -->
                                    <li><a href="#"><i class="icon fa fa-archive"></i> {{ trans('nav.overview.packages') }}</a></li>
                                    <!-- /.if data exists -->
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> {{ trans('nav.overview.ipv4') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> {{ trans('nav.overview.ipv6') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> {{ trans('nav.overview.mac') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-search"></i> {{ trans('nav.overview.arp') }}</a></li>
                                    <li><hr></li>
                                    <!-- only if enabled -->
                                    <li><a href="#"><i class="icon fa fa-file-text-o"></i> {{ trans('nav.overview.mib') }}</a></li>
                                    <!-- /.only if enabled -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.overview sub-menu -->
                        <!-- Devices sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-list"></i> <span>{{ trans('nav.devices.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="#"><i class="icon fa fa-server"></i> {{ trans('nav.devices.all') }}
                                        <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <li><a href="{{ url('/devices') }}"><i class="icon fa fa-server"></i> {{ trans('nav.devices.devices') }}</a></li>
                                            <!-- Loop through all device types -->
                                        </ul>
                                    </li>
                                    <li><hr></li>
                                    <li>
                                        <a href="#"><i class="icon fa fa-th"></i> {{ trans('nav.devices.groups') }}
                                        <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <!-- Loop through all device groups -->
                                        </ul>
                                    </li>
                                    @if (Auth::user()->isAdmin())
                                    <li><a href="#"><i class="icon fa fa-th"></i> {{ trans('nav.devices.managegroups') }}</a></li>
                                    @endif
                                    <li><hr></li>
                                    <!-- if enabled -->
                                    <li>
                                        <a href="#"><i class="icon fa fa-map-marker"></i> {{ trans('nav.devices.locations') }}
                                        <i class="fa fa-angle-left pull-right"></i></a>
                                        <ul class="treeview-menu">
                                            <!-- Loop through all device locations -->
                                        </ul>
                                    </li>
                                    <li><hr></li>
                                    <!-- /.if enabled -->
                                    <!-- if enabled -->
                                    <li><a href="#"><i class="icon fa fa-file-text-o"></i> {{ trans('nav.devices.mib') }}</a></li>
                                    <!-- /.if enabled -->
                                    <li><hr></li>
                                    <li><a href="{{ route('devices.create') }}"><i class="icon fa fa-plus text-green"></i> {{ trans('nav.devices.add') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-trash text-aqua"></i> {{ trans('nav.devices.del') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.devices sub-memu -->
                        <!-- ports sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-link"></i> <span>{{ trans('nav.ports.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ url('/ports') }}"><i class="icon fa fa-link"></i> {{ trans('nav.ports.all') }}</a></li>
                                    <li><hr></li>
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-exclamation-circle"></i> {{ trans('nav.ports.errored') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-question-circle"></i> {{ trans('nav.ports.ignored') }}</a></li>
                                    <!-- /.if data -->
                                    <li><hr></li>
                                    <!-- if enabled -->
                                    <li><a href="#"><i class="icon fa fa-money"></i> {{ trans('nav.ports.bills') }}</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-arrows-alt"></i> {{ trans('nav.ports.pseudowires') }}</a></li>
                                    <!-- /.if enabled -->
                                    <li><hr></li>
                                    @if (Auth::user()->hasGlobalRead())
                                    <li><a href="#"><i class="icon fa fa-users"></i> {{ trans('nav.ports.customers') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-link"></i> {{ trans('nav.ports.l2tp') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-truck"></i> {{ trans('nav.ports.transit') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-plus"></i> {{ trans('nav.ports.peering') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-secret"></i> {{ trans('nav.ports.transpeer') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-anchor"></i> {{ trans('nav.ports.core') }}</a></li>
                                    <!-- loop through custom ports -->
                                    @endif
                                    <li><hr></li>
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-exclamation-circle"></i> {{ trans('nav.ports.alerts') }}</a></li>
                                    <!-- /.if data -->
                                    <li><a href="#"><i class="icon fa fa-exclamation-triangle text-red"></i> {{ trans('nav.ports.down') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-pause text-blue"></i> {{ trans('nav.ports.disabled') }}</a></li>
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-minus-circle text-aqua"></i> {{ trans('nav.ports.deleted') }}</a></li>
                                    <!-- /.if data -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.ports sub-menu -->
                        <!-- services sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-cogs"></i> <span>{{ trans('nav.services.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="icon fa fa-cogs"></i> {{ trans('nav.services.all') }}</a></li>
                                    <!-- if enabled -->
                                    <li><a href="#"><i class="icon fa fa-bell-o"></i> {{ trans('nav.services.alerts') }}</a></li>
                                    <!-- /.if enabled -->
                                    <li><hr></li>
                                    @if (Auth::user()->isAdmin())
                                    <li><a href="#"><i class="icon fa fa-bell-o text-green"></i> {{ trans('nav.services.add') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-bell-o text-aqua"></i> {{ trans('nav.services.edit') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-bell-o text-red"></i> {{ trans('nav.services.del') }}</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                        <!-- /.services sub-menu -->
                        <!-- health sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-heartbeat"></i> <span>{{ trans('nav.health.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="icon fa fa-gears"></i> {{ trans('nav.health.memory') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-desktop"></i> {{ trans('nav.health.processor') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-database"></i> {{ trans('nav.health.storage') }}</a></li>
                                    <!-- Loop through other health sensors -->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.health sub-menu -->
                        <!-- apps sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-tasks"></i> <span>{{ trans('nav.apps.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- Loop through app types-->
                                </ul>
                            </li>
                        </ul>
                        <!-- /.apps sub-menu -->
                        <!-- routing sub-menu -->
                        @if (Auth::user()->hasGlobalRead())
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-arrows"></i> <span>{{ trans('nav.routing.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- if data -->
                                    <li><a href="#"><i class="icon fa fa-arrows-alt"></i> {{ trans('nav.routing.vrfs') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-circle-o-notch"></i> {{ trans('nav.routing.ospf') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-exchange"></i> {{ trans('nav.routing.otv') }}</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-link"></i> {{ trans('nav.routing.bgpall') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-external-link"></i> {{ trans('nav.routing.bgpext') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-external-link"></i> {{ trans('nav.routing.bgpint') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-exclamation-circle"></i> {{ trans('nav.routing.alerted') }}</a></li>
                                    <!-- /.if data -->
                                </ul>
                            </li>
                        </ul>
                        @endif
                        <!-- /.routing sub-menu -->
                        <!-- settings sub-menu -->
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-gears"></i> <span>{{ trans('nav.settings.main') }}</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    @if (Auth::user()->isAdmin())
                                    <li><a href="{{ url('/settings') }}"><i class="icon fa fa-sitemap"></i> {{ trans('nav.settings.global') }}</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-user-plus"></i> {{ trans('nav.settings.add') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-times"></i> {{ trans('nav.settings.del') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-user-secret"></i> {{ trans('nav.settings.edit') }}</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-key"></i> {{ trans('nav.settings.authlog') }}</a></li>
                                    <li><hr></li>
                                    <li><a href="#"><i class="icon fa fa-list-alt"></i> {{ trans('nav.settings.pollerlog') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-clock-o"></i> {{ trans('nav.settings.pollers') }}</a></li>
                                    <!-- if distributed poller -->
                                    <li><a href="#"><i class="icon fa fa-gears"></i> {{ trans('nav.settings.pollergroups') }}</a></li>
                                    <li><hr></li>
                                    <!-- /.if distributed poller -->
                                    <li><a href="#"><i class="icon fa fa-wrench"></i> {{ trans('nav.settings.apitokens') }}</a></li>
                                    <li><a href="#"><i class="icon fa fa-book"></i> {{ trans('nav.settings.apidocs') }}</a></li>
                                    @endif
                                    <li><hr></li>
                                    <li><a href="{{ url('/about') }}"><i class="icon fa fa-exclamation-circle"></i> {{ trans('nav.settings.about') }}</a></li>
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
                    <strong>{{ trans('nav.copyright') }} {{ date("Y") }} <a href="http://www.librenms.org">LibreNMS</a>.</strong> {{ trans('nav.reserved') }}
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
        @yield('flotjs')
        <!-- FastClick -->
        <script src="{{ url('js/plugins/fastclick/fastclick.js') }}"></script>
        <!-- Toastr -->
        <script src="{{ url('js/plugins/toastr/toastr.min.js') }}"></script>
        <!-- Lodash -->
        <script src="{{ url('js/lodash.min.js') }}"></script>
        <!-- Gridstack -->
        <script src="{{ url('js/gridstack.min.js') }}"></script>
        <!-- AdminLTE Options and App -->
        <script src="{{ url('js/util.js') }}"></script>
        <script>
            var AdminLTEOptions = {
                // set the treview slide speed
                animationSpeed: 150,
            };
        @if(Auth::check())
            $.Util.ajaxSetup('{{ JWTAuth::fromUser(Auth::user()) }}');

            setInterval($.Util.updateNotificationMenu('{{ url('/') }}'), {{ Settings::get('notifications.pollinterval', 3600000) }});
        @endif
        </script>
        <script src="{{ url('js/app.min.js') }}"></script>
        <!-- page script -->
        @yield('scripts')
    </body>
</html>
