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
        <link type="text/css" rel="stylesheet" href="{{ url('css/rickshaw.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ url('css/graph.css') }}">
    	<link type="text/css" rel="stylesheet" href="{{ url('css/detail.css') }}">
    	<link type="text/css" rel="stylesheet" href="{{ url('css/legend.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ url('css/extensions.css?v=2') }}">
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
                    @include('layouts.topnav')
                </header>

                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    @include('layouts.menu')
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
        <script src="{{ url('js/d3.v3.js') }}"></script>
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
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Class.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Compat.ClassList.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Ajax.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Renderer.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Renderer.Area.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Renderer.Line.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Renderer.Bar.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Renderer.ScatterPlot.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Renderer.Stack.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.RangeSlider.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.RangeSlider.Preview.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.HoverDetail.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Annotate.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Legend.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Axis.Time.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Behavior.Series.Toggle.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Behavior.Series.Order.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Behavior.Series.Highlight.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Smoother.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Fixtures.Time.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Fixtures.Time.Local.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Fixtures.Number.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Fixtures.RandomData.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Fixtures.Color.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Color.Palette.js') }}"></script>
        <script src="{{ url('js/plugins/rickshaw/Rickshaw.Graph.Axis.Y.js') }}"></script>
        <script src="{{ url('js/extensions.js') }}"></script>
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
