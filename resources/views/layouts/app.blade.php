<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Page</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="css/skins/_all-skins.min.css">
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
                          <!-- Notifications: style can be found in dropdown.less -->
                          <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-bell-o"></i>
                              <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                            </ul>
                          </li>
                          <!-- User Account: style can be found in dropdown.less -->
                          <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <span class="hidden-xs">{{ Auth::user()->username }}</span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                <div class="pull-right">
                                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Logout</a>
                                </div>
                              </li>
                            </ul>
                          </li>
                          <!-- Control Sidebar Toggle Button -->
                          <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
                              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                              </button>
                            </span>
                      </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list"></i> <span>Devices</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="icon fa fa-server"></i>All Devices
                                    <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li><a href="{{ url('/devices') }}"><i class="icon fa fa-server"></i> Devices</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
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
                  <div class="pull-right hidden-xs">
                    <b>Version</b> x.x.x
                  </div>
                  <strong>Copyright &copy; 2016 <a href="http://www.librenms.org">LibreNMS</a>.</strong> All rights
                  reserved.
                </footer>

                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                  <!-- Create the tabs -->
                  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                </aside>
                <!-- /.control-sidebar -->
                <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
            <div>
        @endif

        @if (Auth::guest())
            @yield('content')
        @endif

        <!-- Javascript Libs -->
        <!-- jQuery 2.1.4 -->
        <script src="js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="js/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="js/app.min.js"></script>
    </body>
</html>
